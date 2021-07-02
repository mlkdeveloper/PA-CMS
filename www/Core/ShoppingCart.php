<?php


namespace App\Core;


class ShoppingCart
{

    public function __construct(){

        if(!isset($_SESSION)){
           session_start();
        }
        if(!isset($_SESSION["panier"])){
            $_SESSION["panier"] = [];
        }
    }


    public function add($id,$quantity){

        if(isset($_SESSION['panier'][$id])){
            $_SESSION['panier'][$id] += $quantity;
        }else{
            $_SESSION['panier'][$id] = $quantity;
        }

    }

    public function delete($id){
        unset($_SESSION['panier'][$id]);
    }

}