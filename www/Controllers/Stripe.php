<?php


namespace App\Controller;


use App\Core\View;

class Stripe
{
    function paymentStripeAction(){
        require 'vendor/autoload.php';
        session_start();
        \Stripe\Stripe::setApiKey('sk_test_51JC0puGueu1Z1r2SmxqKTcVKd7GHDBvZV0fPSbBI8GczQXd4y4bPAv5HgfMLJSy38vW6uyHwmN7bMrKUrIEw9sF400YiBrLMKe');


        header('Content-Type: application/json');

        $YOUR_DOMAIN = 'http://localhost:8080';

        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $_SESSION['panierTotal']*100,
                    'product_data' => [
                        'name' => 'Stubborn Attachments',
                        'images' => ["https://i.imgur.com/EHyR2nP.png"],
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success',
            'cancel_url' => $YOUR_DOMAIN . '/cancel',
        ]);

        echo json_encode(['id' => $checkout_session->id]);
    }
    function successAction(){
        $view = new View("successStripe");
        session_start();
        var_dump($_SESSION['panier']);
        var_dump($_SESSION['panierTotal']);

        /*
         * Insertion des produits dans la base de données
         */
        
        $view->assign("title", "C&C - Succes du paiement");
    }
    function cancelAction(){
        $view = new View("cancelStripe");
        $view->assign("title", "C&C - Echec du paiement");
    }
    function pagePaiementStripeAction(){
        $view = new View("checkoutStripe");
        $view->assign("title", "C&C - Page de paiement");
    }

}