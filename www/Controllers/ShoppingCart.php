<?php

namespace App\Controller;


use App\Core\View;
use App\Core\ShoppingCart as Panier;
use App\Models\Group_variant;
use App\Models\Product_term;

class ShoppingCart {


    public function displayShoppingCartAction(){

        $panier = new Panier();
        $array = $panier->display();
        $view = new View("displayShoppingCart.front");
        $view->assign("title","Panier");
        $view->assign("products",$array);
    }


    public function addShoppingCartAction(){

        if(isset($_GET['idGroup']) && !empty($_GET['idGroup'])
            && isset($_GET['id']) && !empty($_GET['id'])
            && isset($_GET['values']) && !empty($_GET['values'])
            && isset($_GET['quantity']) && $_GET['quantity'] > 0 )
        {

            $productTerm = new Product_term();
            $getTerms = $productTerm->select(DBPREFIXE.'product_term.idTerm')
                ->innerJoin(DBPREFIXE."products",DBPREFIXE."product_term.idProduct","=",DBPREFIXE."products.id")
                ->innerJoin(DBPREFIXE."category",DBPREFIXE."products.idCategory","=",DBPREFIXE."category.id")
                ->where(DBPREFIXE."product_term.idGroup = :idGroup", DBPREFIXE."product_term.idProduct = :idProduct", DBPREFIXE."products.status = 1",DBPREFIXE."product_term.status = 1",DBPREFIXE."category.status = 1")
                ->setParams(["idGroup" => $_GET['idGroup'], "idProduct" => $_GET['id']])->get();

            $array = array_map("current", $getTerms);

            if(empty(array_diff($_GET['values'], $array))){

                $shoppingCart = new Panier();

                if ($shoppingCart->add($_GET['idGroup'],$_GET['quantity'])){
                    echo "<div class='alert--green alert'>Produit ajouté au panier !</div>";
                    http_response_code(200);

                }else{

                    echo "<div class='alert--red alert'>Stock insuffisant !</div>";
                    http_response_code(400);
                }

            }else{
                http_response_code(400);
            }
        } else {
            http_response_code(400);
        }

    }

    public function deleteShoppingCartAction()
    {

        if(isset($_GET['id']) && !empty($_GET['id']))
        {
            $shoppingCart = new Panier();
            $shoppingCart->delete($_GET['id']);

            header("Location: /panier");

        }else{
            header("Location: /panier");
        }
    }

}