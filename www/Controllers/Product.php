<?php


namespace App\Controller;


use App\Core\View;
use App\Models\Products;
use App\Models\Products as productModel;
use App\Models\Category;

class Product
{

    public function displayProductsFrontAction(){

        if (isset($_GET['name']) && !empty($_GET['name'])){

            if (isset($_GET['page'])){
                $page = $_GET['page'];
            }else{
                $page = 1;
            }

            $category = new Category();
            $idCategory = $category->select('id,description')->where("name = :name")->setParams(['name' => $_GET['name']])->get();

            if (empty($idCategory)){
                header("Location: /");
                exit();
            }

            $product = new productModel();
            $nbProduct = $product->select("count(*) as nbProduct")->where("idCategory = :id")->setParams(["id" =>$idCategory[0]['id']])->get();
            $nbProduct = $nbProduct[0]['nbProduct'];

            $perPage = 8;
            $pages = ceil( $nbProduct/ $perPage);
            $first = ($page * $perPage) - $perPage;

            $products = new productModel();
            $result = $products->select()->where("idCategory = :id")->setParams(['id' => $idCategory[0]['id']])->limit("$first,$perPage")->get();

            $view = new View("products.front");
            $view->assign("title","produits");
            $view->assign("products",$result);
            $view->assign("name",$_GET['name']);
            $view->assign("page",$page);
            $view->assign("pages",$pages);

            if (!empty($idCategory[0]['description'])){
                $view->assign("description",$idCategory[0]['description']);
            }

        }else{
            header("Location: /");
        }
    }

    public function infoProductFrontAction(){

        if (isset($_GET['id']) && !empty($_GET['id'])){

            $getVariant = [];

            $product = new Products();
            $verify = $product->select('id')->where("id = :id")->setParams(['id' => $_GET['id']])->get();

            if (empty($verify)){
                header("Location: /");
                exit();
            }

            $getProduct = $product->select()->where("id = :id")->setParams(['id' => $_GET['id']])->get();

            $sqlVariant = $product->select("DISTINCT cc_attributes.name AS variant, cc_product_term.idTerm, cc_terms.name")
                ->innerJoin("cc_product_term","cc_products.id ","=","cc_product_term.idProduct")
                ->innerJoin("cc_terms","cc_product_term.idTerm","=","cc_terms.id")
                ->innerJoin("cc_attributes","cc_terms.idAttributes","=","cc_attributes.id")
                ->where("cc_products.id = :id")->setParams(['id' => $_GET['id']])->get();

            foreach ($sqlVariant as $key => $value){
                empty($getVariant[$value["variant"]]) ?
                    $getVariant[$value["variant"]] = [ $value["idTerm"] => $value["name"]]
                    : array_push( $getVariant[$value["variant"]],$value["name"]);
            }



            $view = new View('infoProduct.front');
            $view->assign("product",$getProduct[0]);
            $view->assign("title","produit");
            $view->assign("getVariant",$getVariant);
        }
    }

}