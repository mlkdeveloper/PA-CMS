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

            $array = [
                [ "name" => "couleur", "valeur"=>"XS", "id"=>"30"],
                [ "name" => "couleur", "valeur"=>"S","id"=>"31"],
                [ "name" => "Taille", "valeur"=>"18", "id"=>"37"],
                [ "name" => "Taille", "valeur"=>"19","id"=>"38"],

            ];

           foreach ($array as $key => $value){

                if (empty($getVariant[$value["name"]])){

                    $getVariant[$value["name"]] = [ $value["id"] => $value["valeur"]];
                }else{
                   array_push( $getVariant[$value["name"]],$value["valeur"]);
                }
           }








            $product = new Products();
            $verify = $product->select('id')->where("id = :id")->setParams(['id' => $_GET['id']])->get();

            if (empty($verify)){
                header("Location: /");
                exit();
            }

            $getProduct = $product->select()->where("id = :id")->setParams(['id' => $_GET['id']])->get();

          //SELECT DISTINCT cc_attributes.name, cc_terms.name, cc_terms.id FROM `cc_product_term` INNER JOIN cc_terms ON cc_product_term.idTerm = cc_terms.id INNER JOIN cc_attributes ON cc_terms.idAttributes = cc_attributes.id WHERE cc_product_term.idProduct = 1


            $view = new View('infoProduct.front');
            $view->assign("product",$getProduct[0]);
            $view->assign("title","produit");
            $view->assign("getVariant",$getVariant);
        }
    }

}