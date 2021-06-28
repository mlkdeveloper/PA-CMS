<?php

namespace App\Controller;


use App\Core\View;
use App\Core\ShoppingCart as Panier;

class ShoppingCart {


    public function displayShoppingCartAction(){

        session_start();
        $view = new View("displayShoppingCart.front");
        $view->assign("title","Panier");
    }


    public function addShoppingCartAction(){


       $shoppingCart = new Panier();

    }

    public function deleteShoppingCartAction()
    {

        if(isset($_GET['idGroup']) && !empty($_GET['idGroup']))
        {
            $shoppingCart = new Panier();
            $shoppingCart->delete($_GET['idGroup']);
        }
    }



}