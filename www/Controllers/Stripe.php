<?php


namespace App\Controller;


use App\Core\Security;
use App\Core\View;
use App\Models\Group_variant;
use App\Models\Product_order;
use App\Models\Orders as Orders_model;

session_start();

class Stripe
{
    function paymentStripeAction(){


        if (!Security::isConnected()){
            header("Location: /connexion");
            exit();
        }

        require 'vendor/autoload.php';

        \Stripe\Stripe::setApiKey(PRIVATEKEYSTRIPE);

        header('Content-Type: application/json');

        $YOUR_DOMAIN = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];


        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $_SESSION['panierTotal']*100,
                    'product_data' => [
                        'name' => 'Montant du panier',
                        'images' => [],
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success',
            'cancel_url' => $YOUR_DOMAIN . '/cancel',
        ]);

        echo json_encode(['id' => $checkout_session->id, 'payment_intent' => $checkout_session->payment_intent]);
    }

    function successAction(){

        if (!Security::isConnected()){
            header("Location: /connexion");
            exit();
        }

        $view = new View("successStripe");

        $orders = new Orders_model();
        $orders->setUserId($_SESSION['user']['id']);
        $orders->setMontant($_SESSION['panierTotal']);
        $orders->setPaymentIntent($_SESSION['payment_intent']);
        $orders->setStatus(0);
        $orders->save();

        $panier = New Orders_model();
        $panier = $orders->select('*')->where("montant = :montant", "status = 0", "User_id = :id")
            ->setParams(["montant" =>$_SESSION['panierTotal'], "id" => $_SESSION['user']['id']])->get();
        $stock = new Group_variant();
        foreach ($_SESSION['panier'] as $key => $value) {

            for($i = 0; $i< intval($value); $i++ ){

                $stock = $stock->select('stock, price')->where("id = :id")->setParams(["id" => $key])->get();

                $_SESSION['errorPanier']  = null;

                if ($stock[0]['stock'] == "0"){
                    $_SESSION['errorPanier'] = "un ou plusieurs produit n'ont plus assez de stock ";
                    exit();
                }else{
                    $variant = new Group_variant();
                    $variant->setId($key);
                    $variant->setStock(intval($stock[0]['stock']) -1 );
                    $variant->setPrice(intval($stock[0]['price']) );
                    $variant->save();


                    $product = new Product_order();
                    $product->setIdGroupVariant($key);
                    $product->setIdOrder($panier[0]['id']);
                    $product->save();
                }

                $stock = new Group_variant();
            }
        }
        unset($_SESSION['panier']);
        unset($_SESSION['panierTotal']);

        $view->assign("title", "C&C - Succes du paiement");
    }
    function cancelAction(){

        if (!Security::isConnected()){
            header("Location: /connexion");
            exit();
        }
        $view = new View("cancelStripe");
        $view->assign("title", "C&C - Echec du paiement");
    }

    /*
     * Vérification du stock en ajax
     */
    function checkStockProductsAction(){

        if (!Security::isConnected()){
            header("Location: /connexion");
            exit();
        }

        $view = new View("cancelStripe");
        $view->assign("title", "C&C - Echec du paiement");

        $stocks = new Group_variant();
        $stock = new Group_variant();

        foreach ($_SESSION['panier'] as $key => $value) {
            $stocks = $stock->select('*')->where("id = :id")->setParams(["id" => $key])->get();
            $stock->populate($stocks[0]);

            for($i = 0; $i< intval($value); $i++ ) {
                $stock->setStock(intval($stock->getStock()) - 1);
                if ($stock->getStock() < 0){
                    http_response_code(400);
                    exit();
                }
            }
            http_response_code(200);
            $stock = new Group_variant();
            $stocks = new Group_variant();
        }
    }

    public function insertPaymentIntentAction(){

        if(!isset($_GET['payment_intent'])){
            header('location:/');
            exit();
        }
        $_SESSION['payment_intent'] = $_GET['payment_intent'];

    }
}