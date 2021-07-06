<?php


namespace App\Core;


use App\Models\Group_variant;
use App\Models\Product_term;

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

    public function display(){

        $array = [];

        foreach ($_SESSION['panier'] as $key => $product){

            $productTerm = new Product_term();
            array_push($array,$productTerm->select("cc_terms.name AS nameTerm,cc_group_variant.id,cc_products.name, cc_group_variant.price ")
                ->innerJoin("cc_group_variant","cc_product_term.idGroup ","=","cc_group_variant.id")
                ->innerJoin("cc_products","cc_product_term.idProduct ","=","cc_products.id")
                ->innerJoin("cc_terms","cc_product_term.idTerm ","=","cc_terms.id")
                ->where("cc_product_term.idGroup = :idGroup")->setParams(["idGroup" => $key])->get());
        }

        return $array;
    }


}