<?php


namespace App\Controller;


use App\Core\FormValidator;
use App\Core\View;
use App\Models\Group_variant;
use App\Models\Products;
use App\Models\Products as productModel;
use App\Models\Category;
use App\Models\Review;

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
            $nbProduct = $product->select("count(*) as nbProduct")->where("idCategory = :id","status = 1")->setParams(["id" =>$idCategory[0]['id']])->get();
            $nbProduct = $nbProduct[0]['nbProduct'];

            $perPage = 8;
            $pages = ceil( $nbProduct/ $perPage);
            $first = ($page * $perPage) - $perPage;

            $products = new productModel();
            $result = $products->select()->where("idCategory = :id","status = 1")->setParams(['id' => $idCategory[0]['id']])->limit("$first,$perPage")->get();

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
            $getProduct = $product->select()->where("id = :id","status = 1")->setParams(['id' => $_GET['id']])->get();

            if (empty($getProduct)){
                header("Location: /");
                exit();
            }

            $sqlVariant = $product->select("DISTINCT ".DBPREFIXE."attributes.name AS variant, ".DBPREFIXE."product_term.idTerm, ".DBPREFIXE."terms.name")
                ->innerJoin(DBPREFIXE."product_term",DBPREFIXE."products.id ","=",DBPREFIXE."product_term.idProduct")
                ->innerJoin(DBPREFIXE."terms",DBPREFIXE."product_term.idTerm","=",DBPREFIXE."terms.id")
                ->innerJoin(DBPREFIXE."attributes",DBPREFIXE."terms.idAttributes","=",DBPREFIXE."attributes.id")
                ->where(DBPREFIXE."products.id = :id")->setParams(['id' => $_GET['id']])->get();

            foreach ($sqlVariant as $key => $value){
                empty($getVariant[$value["variant"]]) ?
                    $getVariant[$value["variant"]] = [ $value["idTerm"] => $value["name"]]
                    : array_push( $getVariant[$value["variant"]],$value["name"]);
            }

            $view = new View('infoProduct.front');
            $review = new Review();

            $form = $review->formBuilderRegister();
            if (!empty($_POST)){

                $errors = FormValidator::checkFormReview($form, $_POST);

                if (empty($errors)){
                    session_start();
                    $review->populate($_POST);
                    $review->setStatus(0);
                    $review->setProductsId($_GET['id']);
                    $review->setUserId($_SESSION['user']['id']);
                    $review->save();

                    $view->assign("success", "Commentaire envoyé !");

                }else{
                    $view->assign("errors", $errors);
                }

            }

            $reviews = $review->select(DBPREFIXE."user.lastname, ".DBPREFIXE."review.commentary, ".DBPREFIXE."review.mark, ".DBPREFIXE."review.createdAt")
                ->innerJoin(DBPREFIXE."user",DBPREFIXE."review.User_id","=",DBPREFIXE."user.id")
                ->where("Products_id = :id",DBPREFIXE."review.status = 1")->setParams(["id" => $_GET['id']])->get();


            $view->assign("product",$getProduct[0]);
            $view->assign("title","produit");
            $view->assign("getVariant",$getVariant);
            $view->assign("reviews",$reviews);
        }
    }

    public function getPriceAction(){

        if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['values']) && !empty($_GET['values'])){

            $values = $_GET['values'];
            $column['id'] = $_GET['id'];
            $product = new Products();

            $getIdGroup = $product->select()
                ->innerJoin(DBPREFIXE."product_term",DBPREFIXE."products.id ","=",DBPREFIXE."product_term.idProduct");


            if (count($values ) != 1){

                foreach ($values as $key => $value) {
                    $param = ":p".$key;
                    $getIdGroup = $getIdGroup->whereOr(DBPREFIXE."product_term.idTerm = $param");
                    $column[$param] = $value;
                }

                $count = count($values) - 1;
                $getIdGroup = $getIdGroup->where(DBPREFIXE."products.id = :id")->groupBy(DBPREFIXE."product_term.idGroup")->having("COUNT(*) > $count");

            }else{
                $column['idTerm'] = $values[0];
                $getIdGroup = $getIdGroup->where(DBPREFIXE."products.id = :id",DBPREFIXE."product_term.idTerm = :idTerm");
            }

            $getIdGroup = $getIdGroup->setParams($column)->get();

            if (!empty($getIdGroup)){

                $groupVariant = new Group_variant();
                $getPrice = $groupVariant->select('id,price,stock')->where("id = :id")->setParams(['id' => $getIdGroup[0]['idGroup'] ])->get();

                echo json_encode($getPrice[0]);
                http_response_code(200);
            }else{
                http_response_code(404);
            }

        }else{
            http_response_code(404);
        }
    }

}