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
            array_push($array,$productTerm->select(DBPREFIXE."terms.name AS nameTerm, ".DBPREFIXE."group_variant.id, ".DBPREFIXE."products.name, ".DBPREFIXE."group_variant.price ")
                ->innerJoin(DBPREFIXE."group_variant",DBPREFIXE."product_term.idGroup ","=",DBPREFIXE."group_variant.id")
                ->innerJoin(DBPREFIXE."products",DBPREFIXE."product_term.idProduct ","=",DBPREFIXE."products.id")
                ->innerJoin(DBPREFIXE."terms",DBPREFIXE."product_term.idTerm ","=",DBPREFIXE."terms.id")
                ->where(DBPREFIXE."product_term.idGroup = :idGroup")->setParams(["idGroup" => $key])->get());
        }

        return $array;
    }


}