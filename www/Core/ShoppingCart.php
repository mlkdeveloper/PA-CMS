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


    public function add($id){

        if(isset($_SESSION['panier'][$id])){
            $_SESSION['panier'][$id]++;
        }else{
            $_SESSION['panier'][$id] = 1;
        }

    }

    public function delete($id){
        unset($_SESSION['panier'][$id]);
    }

}