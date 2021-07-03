<?php

namespace App\Controller;


use App\Core\View;
use App\Core\ShoppingCart as Panier;
use App\Models\Group_variant;
use App\Models\Product_term;

class ShoppingCart {


    public function displayShoppingCartAction(){

        session_start();

        $array = [];

        foreach ($_SESSION['panier'] as $key => $product){

            $productTerm = new Product_term();
             array_push($array,$productTerm->select("cc_terms.name AS nameTerm,cc_group_variant.id,cc_products.name, cc_group_variant.price ")
                 ->innerJoin("cc_group_variant","cc_product_term.idGroup ","=","cc_group_variant.id")
                 ->innerJoin("cc_products","cc_product_term.idProduct ","=","cc_products.id")
                 ->innerJoin("cc_terms","cc_product_term.idTerm ","=","cc_terms.id")
                 ->where("cc_product_term.idGroup = :idGroup")->setParams(["idGroup" => $key])->get());
        }

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
            $getTerms = $productTerm->select('idTerm')->where("idGroup = :idGroup","idProduct = :idProduct")->setParams(["idGroup" => $_GET['idGroup'], "idProduct" => $_GET['id']])->get();
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