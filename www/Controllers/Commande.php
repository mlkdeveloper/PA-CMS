<?php


namespace App\Controller;

use App\Core\Database;
use App\Core\Email;
use App\Core\Helpers;
use App\Core\View;
use App\Core\FormValidator;
use App\Models\Group_variant;
use App\Models\Orders;
use App\Models\Product_order;
use App\Models\Product_term;
use App\Models\User;
use App\Core\Security;

session_start();

class Commande
{
    /*
    Affichage des commandes
    */
    public function listeCommandeAction(){

        Security::auth('orders');

        $view = new View("commandeList.back", "back");
        $view->assign("title", "Liste des commandes");
        $commande = new Product_order();

        $listOrders = $commande->select('*, COUNT('.DBPREFIXE.'product_order.id) as nbArticle, '.DBPREFIXE.'orders.status as idStatus ')
            ->innerJoin(DBPREFIXE."orders", DBPREFIXE."product_order.id_order", "=", DBPREFIXE."orders.id")
            ->innerJoin(DBPREFIXE."user", DBPREFIXE."orders.User_id", "=", DBPREFIXE."user.id")
            ->groupBy("id_order")->get();
        $view->assign("array", $listOrders);

    }

    /*
     * Affichage des produits liées au commandes
     */
    public function displayCommandeAction(){

        Security::auth('orders');

        if (isset($_GET['id']) && !empty($_GET['id'])) {

            $order = new Orders();
            $checkId = $order->select('id')->where("id = :id")->setParams(['id' => $_GET['id']])->get();

            if (empty($checkId)){
                header("Location: /admin/liste-commande");
                exit();
            }

            $view = new View("displayCommande.back", "back");
            $view->assign("title", "Détail de la commande");

            $order = new Orders();

            $orders = $order->select(DBPREFIXE."product_order.id_group_variant, " .DBPREFIXE."orders.id, " .DBPREFIXE."orders.CreatedAt, " .DBPREFIXE."orders.status, " .DBPREFIXE."orders.montant, " .DBPREFIXE."user.firstname, " .DBPREFIXE."user.lastname, " .DBPREFIXE."user.email"  )
                ->innerJoin(DBPREFIXE."product_order",DBPREFIXE."orders.id","=",DBPREFIXE."product_order.id_order")
                ->innerJoin(DBPREFIXE."user",DBPREFIXE."orders.User_id","=",DBPREFIXE."user.id")
                ->where(DBPREFIXE."product_order.id_order = :id")->setParams(['id' => $_GET['id']])->get();

            $array = [];

            foreach ($orders as $value){
                $productTerm = new Product_term();
                array_push($array,$productTerm->select(DBPREFIXE."terms.name AS nameTerm, ".DBPREFIXE."group_variant.id, ".DBPREFIXE."products.name, ".DBPREFIXE."group_variant.price ")
                    ->innerJoin(DBPREFIXE."group_variant",DBPREFIXE."product_term.idGroup ","=",DBPREFIXE."group_variant.id")
                    ->innerJoin(DBPREFIXE."products",DBPREFIXE."product_term.idProduct ","=",DBPREFIXE."products.id")
                    ->innerJoin(DBPREFIXE."terms",DBPREFIXE."product_term.idTerm ","=",DBPREFIXE."terms.id")
                    ->where(DBPREFIXE."product_term.idGroup = :idGroup")->setParams(["idGroup" => $value['id_group_variant']])->get());
            }

            $view->assign("products",$array);
            $view->assign("order",$orders);

        }else{
            header("Location: /admin/liste-commande");
        }

    }

    /*
     * Annulation de la commande coté Front
     */
    public function cancelOrderFrontAction(){
        require 'vendor/autoload.php';
        if (!Security::isConnected()){
            header("Location: /connexion");
            exit();
        }

        if (isset($_GET['id']) && !empty($_GET['id'])){

            $order = new Orders();
            $checkId = $order->select('id')->where("id = :id","User_id = :idUser")->setParams(['id' => $_GET['id'], 'idUser' => $_SESSION['user']['id']])->get();


            if (empty($checkId)){
                header("Location: /admin/liste-commande");
                exit();
            }

            $user = new User();
            $products = new Product_order();

            $commande = $order->select('*')->where("id = :id")->setParams(["id" => $_GET['id']])->get();
            $getUser = $user->select('*')->where("id = :id")->setParams(["id" => $commande[0]["User_id"]])->get();
            $products = $products->select('*')->where("id_order = :idOrder")->setParams(["idOrder" => $commande[0]['id']])->get();

            /*
             * Si la commande a déjà été annuler, alors je redirige
             */
            if ($commande[0]['status'] == -1 ){
                header('location:/mes-commandes');
                exit();
            }

            /*
             * Si on annule la commande
             * Alors je rajoute le stock en BDD
             */
            for ($i = 0; $i < sizeof($products); $i++){
                $product = new Group_variant();
                $prod = new Group_variant();

                $product = $product->select('*')->where("id = :id")->setParams(["id" => $products[$i]['id_group_variant']])->get();

                $prod->populate($product[0]);
                $prod->setId($product[0]['id']);
                $prod->setStock(intval($product[0]['stock']) + 1);
                $prod->save();

            }

            $order->populate($commande[0]);
            $order->setPaymentIntent($commande[0]['payment_intent']);
            $order->setUserId($commande[0]['User_id']);
            $order->setStatus(-1);
            $order->save();

            /*
             * Remboursement du montant de la commande Via Stripe
             */
            \Stripe\Stripe::setApiKey(PRIVATEKEYSTRIPE);

            $re = \Stripe\Refund::create([
                'payment_intent' => $commande[0]['payment_intent'],
            ]);

            Email::sendEmail("C&C - Annulation de votre commande",$getUser[0]["email"], utf8_decode("Votre commande vient d'être annulée.")." <br> Vous aller recevoir votre remboursement sous peu (1-2j)", "http://".$_SERVER['SERVER_NAME']."/connexion","Mon compte", "/mes-commandes");

            header('location: /mes-commandes');
        }else{
            header('Location: /mes-commandes');
        }

    }

    /*
     * Annulation de la commande _ remboursement coté BACK
     */
    public function cancelCommandeAction(){


        Security::auth('orders');


        require 'vendor/autoload.php';

        if (isset($_GET['id']) && !empty($_GET['id'])){

            $order = new Orders();
            $checkId = $order->select('id')->where("id = :id")->setParams(['id' => $_GET['id']])->get();

            if (empty($checkId)){
                header("Location: /admin/liste-commande");
                exit();
            }

            $user = new User();
            $products = new Product_order();

            $commande = $order->select('*')->where("id = :id")->setParams(["id" => $_GET['id']])->get();
            $getUser = $user->select('*')->where("id = :id")->setParams(["id" => $commande[0]["User_id"]])->get();
            $products = $products->select('*')->where("id_order = :idOrder")->setParams(["idOrder" => $commande[0]['id']])->get();

            if ($commande[0]['status'] == 1 || $commande[0]['status']  == 2){
                header('location:/admin/liste-commande');
                exit();
            }

            for ($i = 0; $i < sizeof($products); $i++){
                $product = new Group_variant();
                $prod = new Group_variant();

                $product = $product->select('*')->where("id = :id")->setParams(["id" => $products[$i]['id_group_variant']])->get();
                $prod->populate($product[0]);
                $prod->setId($product[0]['id']);
                $prod->setStock(intval($product[0]['stock']) + 1);
                $prod->save();

            }

            $order->populate($commande[0]);
            $order->setPaymentIntent($commande[0]['payment_intent']);
            $order->setUserId($commande[0]['User_id']);
            $order->setStatus(-1);
            $order->save();

            /*
             * Remboursement du montant de la commande Via Stripe
             */
           \Stripe\Stripe::setApiKey(PRIVATEKEYSTRIPE);

            $re = \Stripe\Refund::create([
                'payment_intent' => $commande[0]['payment_intent'],
            ]);

            Email::sendEmail("C&C - Annulation de votre commande",$getUser[0]["email"], utf8_decode("Votre commande vient d'être annulée"), 'http://'.$_SERVER['SERVER_NAME']."/connexion","Mon compte", "/admin/liste-commande");

        }else{
            header("Location: /admin/liste-commande");
        }

    }

    /*
     * Validation de la commande
     */
    public function ValidCommandeAction(){

        Security::auth('orders');

        if (isset($_GET['id']) && !empty($_GET['id'])){

            $order = new Orders();
            $checkId = $order->select('id')->where("id = :id")->setParams(['id' => $_GET['id']])->get();

            if (empty($checkId)){
                header("Location: /admin/liste-commande");
                exit();
            }

            $user = new User();

            $commande = $order->select('*')->where("id = :id")->setParams(["id" => $_GET['id']])->get();
            $getUser = $user->select('*')->where("id = :id")->setParams(["id" => $commande[0]["User_id"]])->get();

            if ($commande[0]['status'] == -1 || $commande[0]['status']  == 2){
                header('location:/admin/liste-commande');
                exit();
            }

            $order->populate($commande[0]);
            $order->setPaymentIntent($commande[0]['payment_intent']);
            $order->setUserId($commande[0]['User_id']);
            $order->setStatus(1);
            $order->save();

            Email::sendEmail("C&C - Votre commande est prête !", $getUser[0]["email"], utf8_decode('Votre commande est prête ! ')."<br> Vous pouvez venir la chercher en magasin", "http://".$_SERVER['SERVER_NAME']."/connexion","Mon compte", "/admin/liste-commande");

        }else{
            header("Location: /admin/liste-commande");
        }

    }

    /*
     * Cloture de la commande
     */
    public function DoneCommandeAction(){

        Security::auth('orders');

        if (isset($_GET['id']) && !empty($_GET['id'])){

            $order = new Orders();
            $checkId = $order->select('id')->where("id = :id")->setParams(['id' => $_GET['id']])->get();

            if (empty($checkId)){
                header("Location: /admin/liste-commande");
                exit();
            }

            $user = new User();

            $commande = $order->select('*')->where("id = :id")->setParams(["id" => $_GET['id']])->get();
            $getUser = $user->select('*')->where("id = :id")->setParams(["id" => $commande[0]["User_id"]])->get();

            if ($commande[0]['status'] == -1){
                header('location:/admin/liste-commande');
                exit();
            }

            $order->populate($commande[0]);
            $order->setPaymentIntent($commande[0]['payment_intent']);
            $order->setUserId($commande[0]['User_id']);
            $order->setStatus(2);
            $order->save();

            Email::sendEmail("C&C - Votre commande a été clôturé", $getUser[0]["email"], utf8_decode("Votre commande vient d'être clôturé")." <br> ". utf8_decode("Merci et à bientôt !"), "http://".$_SERVER['SERVER_NAME']."/connexion","Mon compte", "/admin/liste-commande");

        }else{
            header("Location: /admin/liste-commande");
        }

    }

    /*
     * Affichage des commandes coté Front
     */
    public function displayOrdersFrontAction(){

        if (!Security::isConnected()){
            header("Location: /connexion");
            exit();
        }

        $view = new View("displayOrders.front");
        $view->assign("title","Mes commandes");

        $order = new Orders();
        $orders = $order->select("montant,id,CreatedAt,status")->where("User_id = :id")->setParams(['id' => $_SESSION['user']['id']])->get();

        $view->assign("orders",$orders);
    }

    /*
     * Affichage du contenu de la commande (produit, prix, quantité) coté front
     */
    public function informationsOrderAction(){


        if (!Security::isConnected()){
            header("Location: /connexion");
            exit();
        }

        if (isset($_GET['id']) && !empty($_GET['id']) ){


            $order = new Orders();
            $checkId = $order->select('id')->where("id = :id","User_id = :idUser")->setParams(['id' => $_GET['id'], 'idUser' => $_SESSION['user']['id']])->get();

            if (empty($checkId)){
                header("Location: /mes-commandes");
                exit();
            }

            $view = new View("infosOrder.front");
            $view->assign("title","Ma commande");

            $order = new Orders();
            $orders = $order->select(DBPREFIXE."product_order.id_group_variant, " .DBPREFIXE."orders.id, " .DBPREFIXE."orders.CreatedAt, " .DBPREFIXE."orders.status, " .DBPREFIXE."orders.montant"  )
                ->innerJoin(DBPREFIXE."product_order",DBPREFIXE."orders.id","=",DBPREFIXE."product_order.id_order")
                ->where(DBPREFIXE."product_order.id_order = :id")->setParams(['id' => $_GET['id']])->get();

            $array = [];

            foreach ($orders as $value){
                $productTerm = new Product_term();
                array_push($array,$productTerm->select(DBPREFIXE."terms.name AS nameTerm, ".DBPREFIXE."group_variant.id, ".DBPREFIXE."products.name, ".DBPREFIXE."group_variant.price ")
                    ->innerJoin(DBPREFIXE."group_variant",DBPREFIXE."product_term.idGroup ","=",DBPREFIXE."group_variant.id")
                    ->innerJoin(DBPREFIXE."products",DBPREFIXE."product_term.idProduct ","=",DBPREFIXE."products.id")
                    ->innerJoin(DBPREFIXE."terms",DBPREFIXE."product_term.idTerm ","=",DBPREFIXE."terms.id")
                    ->where(DBPREFIXE."product_term.idGroup = :idGroup")->setParams(["idGroup" => $value['id_group_variant']])->get());
            }

            $view->assign("products",$array);
            $view->assign("order",$orders);

        }else{
            header("Location: /mes-commandes");
        }
    }
}