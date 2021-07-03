<?php


namespace App\Core;


use App\Models\Group_variant;

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

        $group = new Group_variant();
        $getQuantity = $group->select("stock")->where("id = :idGroup")->setParams(["idGroup" => $id])->get();
        $stock = $getQuantity[0]['stock'];
        $res = true;

        if(isset($_SESSION['panier'][$id])){
            $stock -  ($_SESSION['panier'][$id] + $quantity) >= 0 ?  $_SESSION['panier'][$id] += $quantity : $res = false;
        }else{
            $stock - $quantity >=0 ? $_SESSION['panier'][$id] = $quantity : $res = false;
        }

        $this->calcTotal();

        return $res;

    }

    public function delete($id){
        unset($_SESSION['panier'][$id]);

        $this->calcTotal();
    }

    public function calcTotal(){

        $_SESSION['panierTotal'] = 0;

        foreach ($_SESSION['panier'] as $key => $product){

            $group = new Group_variant();
            $getQuantity = $group->select("price")->where("id = :idGroup")->setParams(["idGroup" => $key])->get();


            $_SESSION['panierTotal'] += $getQuantity[0]['price'] * $product;

        }
    }


}