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
        $commande = new Orders();
        $listOrders = $commande->select('*')->get();

        $view->assign("array", $listOrders);
    }

    public function displayCommandeAction(){
        $view = new View("displayCommande.back", "back");
        $view->assign("title", "Détail de la commande");

        if (!isset($_GET['id']) && empty($_GET['id'])){
            $view->assign("errors", "Parametre manquant dans le GET");
        }
        $product = new Product_order();
        $listProduct = $product->select('*')
            ->innerJoin("cc_product_term", "cc_product_order.id_product_term", "=", "cc_product_term.id")
            ->innerJoin("cc_products", "cc_product_term.idProduct", "=", "cc_products.id")
            ->innerJoin("cc_terms", "cc_product_term.idTerm", "=", "cc_terms.id")
            ->innerJoin("cc_group_variant", "cc_product_term.idGroup", "=", "cc_group_variant.id")
            ->innerJoin("cc_attributes", "cc_terms.idAttributes", "=", "cc_attributes.id")
            ->where("id_order = :id")->setParams(["id" => $_GET['id']])
            ->get();

        /*
         *
         *             ->innerJoin(DBPREFIXE."products", "Products_id", "=", DBPREFIXE."products.id")

         *
         * LA REQUETE
         *
         * SELECT * FROM `cc_product_order`
           INNER JOIN cc_product_term ON cc_product_order.id_product_term = cc_product_term.id
           INNER JOIN cc_products ON cc_product_term.idProduct = cc_products.id
           INNER JOIN cc_terms ON cc_product_term.idTerm = cc_terms.id
           INNER JOIN cc_group_variant ON cc_product_term.idGroup = cc_group_variant.id
           INNER JOIN cc_attributes ON cc_terms.idAttributes = cc_attributes.id
           WHERE `id_order` = 1
         */


    }

    public function cancelCommandeAction(){

        if (!isset($_GET['id']) && empty($_GET['id'])){
            $view->assign("errors", "Parametre manquant dans le GET");
        }
        $order = new Orders();
        $user = new \App\Models\User();

        $commande = $order->select('*')->where("User_id = :id")->setParams(["id" => $_GET['id']])->get();
        $utilisateur = $user->select('*')->where("id = :id")->setParams(["id" => $commande[0]["User_id"]])->get();


        Email::sendEmail($utilisateur[0]["email"], "Annulation de votre commande", "http://localhost:8082/connexion","Mon compte", "/connexion");

    }
}