<?php


namespace App\Controller;


use App\Core\View;
use App\Models\Attributes;
use App\Models\Terms;
use App\Models\Group_variant;
use App\Models\Product_term;

class Product
{

    public function addProductAction(){

        $view = new View("createProduct.back","back");
        $view->assign("title","Produit");

        $attribute = new Attributes();
        $attributes = $attribute->select("id, name")->get();

        $view->assign("attributes", $attributes);
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
        //tableau récupéré
        //Bouclage tableau
        //Récupération du dernier id de cc_group_variant + 1
            //stocker dans une variable l'id
            //Insertion du stock et le prix avec l'id dans cc_group_variant
        //Insertion dans cc_products_terms id group_variant id_terms

        if(isset($_POST['comb_array'])){
            $comb = json_decode($_POST['comb_array']);

            $gv = new Group_variant;
            $pt = new Product_term;

            foreach($comb as $key => $value){
                $s = $value[count($value)-2];
                $p = $value[count($value)-1];

                //Plus besoin de ces variables de merde
                    unset($value[count($value)-1], $value[count($value)-1]);

                $gv->setPrice($p);
                $gv->setStock($s);
                $gv->save();
                //Récupération de l'id
                $id = $gv
                    ->select("MAX(id) as id")
                    ->get();

                $id = $id[0]["id"];

                foreach($value as $k => $v){
                    $pt->setIdTerm($v);
                    $pt->setIdGroup($id);
                    $pt->save();
                }

            }

            echo "<div class='alert alert--success'>Produit créé avec succès !</div>";
            http_response_code(201);

        }else{
            echo "<div class='alert alert--red'>Erreur dans la création du produit !</div>";
            \http_response_code(400);
        }


    }

}