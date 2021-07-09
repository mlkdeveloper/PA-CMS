<?php


namespace App\Controller;

use App\Core\Database;
use App\Core\Email;
use App\Core\Helpers;
use App\Core\View;
use App\Core\FormValidator;
use App\Models\Orders;
use App\Models\Product_order;

class Commande extends Database
{

    public function listeCommandeAction(){
        $view = new View("commandeList.back", "back");
        $view->assign("title", "Liste des commandes");
        $commande = new Product_order();
        $listOrders = $commande->select('*, COUNT(cc_product_order.id) as nbArticle, cc_orders.status as idStatus ')
            ->innerJoin("cc_orders", "cc_product_order.id_order", "=", "cc_orders.id")
            ->innerJoin("cc_user", "cc_orders.User_id", "=", "cc_user.id")
            ->groupBy("id_order")->get();
        $view->assign("array", $listOrders);
    }

    public function displayCommandeAction(){
        $view = new View("displayCommande.back", "back");
        $view->assign("title", "Détail de la commande");

        if (!isset($_GET['id']) && empty($_GET['id'])){
            header('location:/admin/liste-commande');
        }

        $product = new Product_order();
        $listProduct = $product->select('cc_terms.name as termName,cc_product_order.id as idProductOrder, cc_product_order.id_group_variant, cc_products.name as productName, cc_group_variant.price as variantPrice, cc_group_variant.stock as variantStock ')
            ->innerJoin("cc_product_term", "cc_product_order.id_group_variant", "=", "cc_product_term.idGroup")
            ->innerJoin("cc_products", "cc_product_term.idProduct", "=", "cc_products.id")
            ->innerJoin("cc_terms", "cc_product_term.idTerm", "=", "cc_terms.id")
            ->innerJoin("cc_group_variant", "cc_product_term.idGroup", "=", "cc_group_variant.id")
            ->innerJoin("cc_attributes", "cc_terms.idAttributes", "=", "cc_attributes.id")
            ->where("id_order = :id")->setParams(["id" => $_GET['id']])
            ->orderBy('cc_product_order.id', 'ASC')
            ->get();

        if (empty($listProduct)){
            header('location:/admin/liste-commande');
        }

        /*
         * Récupération des informations de la commande dans la table Orders
         */

        $order = new Orders();
        $commande = new Orders();

        $commande = $order->select('*, cc_orders.status as idStatus')
            ->innerJoin('cc_user', 'cc_user.id', '=', 'cc_orders.User_id')
            ->where("cc_orders.id= :id")->setParams(["id" => $_GET['id']])->get();

        $view->assign("commande", $commande);
        /*
         * 1. faire un for()
         * Je créer un nv array j'insere array[0] dans nv tableau
         * si array[i][id] est dans nv tableau alors j'insere uniquement termName dans nv tableau
         * sinon j'ajoute array[i] dans mon nv tableau
         */
        $newArrayProducts = [];
        array_push($newArrayProducts, $listProduct[0]);
        unset($listProduct[0]);


        for ($i = 1; $i < sizeof($listProduct); $i ++){
            if (Helpers::filter_by_value($newArrayProducts, 'idProductOrder', $listProduct[$i]['idProductOrder']) != null){
                $array = Helpers::filter_by_value($newArrayProducts, 'idProductOrder', $listProduct[$i]['idProductOrder']);

            }else{
                array_push($newArrayProducts, $listProduct[$i]);

            }
        }

        print_r($newArrayProducts);

        $view->assign("array", $newArrayProducts);

        /*
        SELECT cc_product_order.id as idProductOrder, cc_product_order.id_group_variant, cc_products.name as productName, cc_terms.name as termName, cc_group_variant.price as variantPrice,
        cc_group_variant.stock as variantStock FROM `cc_product_order`
        INNER JOIN cc_product_term ON cc_product_order.id_group_variant = cc_product_term.idGroup
        INNER JOIN cc_products ON cc_product_term.idProduct = cc_products.id
        INNER JOIN cc_terms ON cc_product_term.idTerm = cc_terms.id
        INNER JOIN cc_group_variant ON cc_product_term.idGroup = cc_group_variant.id
        INNER JOIN cc_attributes ON cc_terms.idAttributes = cc_attributes.id
        WHERE cc_product_order.`id_order` = 3 ORDER BY cc_product_order.`id`

         */

    }

    public function cancelCommandeAction(){

        if (!isset($_GET['id']) && empty($_GET['id'])){
            $view->assign("errors", "Parametre manquant dans le GET");
        }
        $order = new Orders();
        $user = new \App\Models\User();
        $orderTosave = new Orders();

        $commande = $order->select('*')->where("id = :id")->setParams(["id" => $_GET['id']])->get();
        $utilisateur = $user->select('*')->where("id = :id")->setParams(["id" => $commande[0]["User_id"]])->get();

        $orderTosave->populate($commande[0]);
        $orderTosave->setId($commande[0]['id']);
        $orderTosave->setUserId($commande[0]['User_id']);
        $orderTosave->setStatus(-1);
        $orderTosave->save();


        Email::sendEmail($utilisateur[0]["email"], "Votre commande viens d'etre annulé ", "http://localhost:8082/connexion","Mon compte", "/admin/liste-commande");

    }

    public function ValidCommandeAction(){
        $view = new View("displayCommande.back", "back");

        if (!isset($_GET['id']) && empty($_GET['id'])){
            $view->assign("errors", "Parametre manquant dans le GET");
        }

        $order = new Orders();
        $user = new \App\Models\User();
        $orderTosave = new Orders();

        $commande = $order->select('*')->where("id = :id")->setParams(["id" => $_GET['id']])->get();
        $utilisateur = $user->select('*')->where("id = :id")->setParams(["id" => $commande[0]["User_id"]])->get();


        $orderTosave->populate($commande[0]);
        $orderTosave->setId($commande[0]['id']);
        $orderTosave->setUserId($commande[0]['User_id']);
        $orderTosave->setStatus(1);
        $orderTosave->save();

        Email::sendEmail($utilisateur[0]["email"], "Votre commande est prete ! <br> Vous pouvez venir la chercher en magasin", "http://localhost:8082/connexion","Mon compte", "/admin/liste-commande");

    }

    public function DoneCommandeAction(){
        $view = new View("displayCommande.back", "back");

        if (!isset($_GET['id']) && empty($_GET['id'])){
            $view->assign("errors", "Parametre manquant dans le GET");
        }

        $order = new Orders();
        $user = new \App\Models\User();
        $orderTosave = new Orders();

        $commande = $order->select('*')->where("id = :id")->setParams(["id" => $_GET['id']])->get();
        $utilisateur = $user->select('*')->where("id = :id")->setParams(["id" => $commande[0]["User_id"]])->get();


        $orderTosave->populate($commande[0]);
        $orderTosave->setId($commande[0]['id']);
        $orderTosave->setUserId($commande[0]['User_id']);
        $orderTosave->setStatus(2);
        $orderTosave->save();

        Email::sendEmail($utilisateur[0]["email"], "Votre commande viens d'etre cloturer <br> Merci et a bientot !", "http://localhost:8082/connexion","Mon compte", "/admin/liste-commande");

    }
}