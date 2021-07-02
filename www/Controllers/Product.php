<?php


namespace App\Controller;


use App\Core\View;
use App\Core\FormValidator;
use App\Core\Helpers;
use App\Models\Attributes;
use App\Models\Terms;
use App\Models\Group_variant;
use App\Models\Product_term;
use App\Models\Products;
use App\Models\Category;


class Product
{

    public function addProductAction(){

        $view = new View("createProduct.back","back");
        $view->assign("title","Produit");

        $attribute = new Attributes();
        $attributes = $attribute->select("id, name")->get();

        $category = new Category;
        $categories = $category->select("id, name")->get();

        $view->assign("attributes", $attributes);
        $view->assign("categories", $categories);
        $view->assign("file_stylesheet","../../dist/product.css");
    }


    public function getValuesAttributeAction(){

        if (isset($_GET['id']) && $_GET['id'] != 1){

            $term = new Terms();
            $terms = $term->select("name, id")->where("idAttributes = :idAttributes" )->setParams(["idAttributes" => $_GET['id']])->get();
            echo json_encode($terms);
        }
    }

    public function createProductAction(){

        if(isset($_POST['comb_array']) && 
            isset($_POST['product']) &&
            count($_POST) === 2
        ){

            //Instanciation des classes
            $gv = new Group_variant;
            $pt = new Product_term;
            $product_model = new Products;

            $comb = json_decode($_POST['comb_array']);
            $product = json_decode($_POST['product']);

            
            $category = new Category;
            $lc = $category
                ->select("id")
                ->get();

            $list_categories = [];

            foreach ($lc as $value) {
                $list_categories[] = $value["id"];
            }

            $errors = FormValidator::checkProduct($product, $list_categories, $comb, $product_model);

            if (empty($errors)) {

                $product_model->populate($product);
                $product_model->save();

                //Récupération de l'id produit
                $idProduct = $product_model
                ->select("MAX(id) as id")
                ->get();

                $idProduct = $idProduct[0]["id"];

                foreach($comb as $key => $value){
                    $s = $value[count($value)-2];
                    $p = $value[count($value)-1];

                        unset($value[count($value)-1], $value[count($value)-1]);

                    $gv->setPrice($p);
                    $gv->setStock($s);
                    $gv->save();

                    //Récupération de l'id du groupe
                    $idGroup = $gv
                    ->select("MAX(id) as id")
                    ->get();

                    $idGroup = $idGroup[0]["id"];

                    foreach($value as $v){
                        $pt->setIdProduct($idProduct);
                        $pt->setIdTerm($v);
                        $pt->setIdGroup($idGroup);
                        $pt->save();
                    }

                }

                echo "<div class='alert alert--green'>Produit créé avec succès !</div>";
                http_response_code(201);

            }else{
                echo "<ul class='alert alert--red'>";
                    foreach($errors as $err){
                        echo "<li>". $err ;
                    }
                echo "</ul>";
            }


        }else{
            echo "<div class='alert alert--red'>Erreur dans la création du produit !</div>";
            \http_response_code(400);
        }
    }

    public function deleteProductAction()
    {
        if (isset($_GET["id"]) && is_int($_GET['id']) ) {
            $product_term = new Product_term;

            
        }
    }

}