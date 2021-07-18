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
use App\Core\MyException;
use App\Core\Uploader;


class Product
{

    public function addProductAction(){

        $view = new View("createProduct.back","back");
        $view->assign("title","Produit");

        $attribute = new Attributes();
        $attributes = $attribute
            ->select("id, name")
            ->where("id <> 1")
            ->get();

        $category = new Category;
        $categories = $category
        ->select("id, name")
        ->where("status = 0")
        ->get();

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

        if(
            isset($_POST['comb_array']) && 
            isset($_POST['product']) &&
            count($_POST) === 2
        ){
            //Instanciation des classes
            $gv = new Group_variant;
            $pt = new Product_term;
            $product_model = new Products;
            $terms = new Terms;
            $category = new Category;

            $comb = json_decode($_POST['comb_array'], true);
            $product = json_decode($_POST['product'], true);

            $lt= $terms
                ->select("id")
                ->get();

            $lc = $category
                ->select("id")
                ->where("status = 0")
                ->get();

            $list_categories = [];
            $list_terms = [];


            foreach ($lt as $value) {
                $list_terms[] = $value["id"];
            }
            foreach ($lc as $value) {
                $list_categories[] = $value["id"];
            }


            $errors = 
            FormValidator::checkProduct2($product, $list_categories, $comb, $product_model, $list_terms);

            if (empty($errors)) {

                $product_model->populate($product);
                $product_model->setStatus(1);
                $product_model->save();

                //Récupération de l'id produit
                $idProduct = $product_model
                ->select("MAX(id) as id")
                ->get();

                $idProduct = $idProduct[0]["id"];



                foreach($comb as $key => $value){
                    //Id group pour l'image
                    $idG = new Group_variant;

                    $idG = $idG->select("MAX(id) as id")->get();
                    $idG = $idG[0]["id"] + 1;
                    if(isset($_FILES['file_'.$key])){    
                        $f = $_FILES['file_'.$key];                   
                        $upload = new Uploader($f,false);
                        $res = $upload
                            ->setName("file_".$idG)
                            ->setSize(10)
                            ->setDirectory("./images/products")
                            ->upload();
                        $s = $value[count($value)-2];
                        $p = $value[count($value)-1];

                            unset($value[count($value)-1], $value[count($value)-1]);

                        $gv->setPrice($p);
                        $gv->setStock($s);
                        ($res) ? $gv->setPicture($upload->getName().".".$upload->getExtension()) : $gv->setPicture("");
                        $gv->save();
                    }else{
                        $s = $value[count($value)-2];
                        $p = $value[count($value)-1];

                            unset($value[count($value)-1], $value[count($value)-1]);

                        $gv->setPrice($p);
                        $gv->setStock($s);
                        $gv->setPicture("");
                        $gv->save();
                    }

                    //Récupération de l'id du groupe
                    $idGroup = $gv
                    ->select("MAX(id) as id")
                    ->get();

                    $idGroup = $idGroup[0]["id"];

                    foreach($value as $v){
                        $pt->setIdProduct($idProduct);
                        $pt->setIdTerm($v);
                        $pt->setIdGroup($idGroup);
                        $pt->setStatus(1);
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

    public function showProductsAction(){
        $product_model = new Products;

        $view = new View("showProducts.back","back");
        $view->assign("title", "Liste des produits");
        $view->assign("stylesheet", "products");
        
        $datas = $product_model
            ->select()
            ->where("status = 1")
            ->get();

        $view->assign("produits", $datas);
    }

    public function infoProductsAction(){
        //Instanciation des classes
        $gv = new Group_variant;
        $pt = new Product_term;
        $product_model = new Products;
        $terms = new Terms;
        $category = new Category;

        if(isset($_GET["id"]) && is_numeric($_GET["id"])){
            $view = new View("infoProducts_products.back","back");
            $view->assign("title", "Information");
            $view->assign("stylesheet", "products");
            
            $datas = $pt
                ->select("*, ". DBPREFIXE."product_term.id as idPt, ".DBPREFIXE."products.id as idProduit")
                ->innerJoin(DBPREFIXE."products", "idProduct", "=", DBPREFIXE."products.id")
                ->innerJoin(DBPREFIXE."group_variant", "idGroup", "=", DBPREFIXE."group_variant.id")
                ->innerJoin(DBPREFIXE."terms", "idTerm", "=", DBPREFIXE."terms.id")
                ->where(DBPREFIXE."products.id = :id", DBPREFIXE."product_term.status = 1")->setParams(["id" => $_GET["id"]])
                ->get();

            $view->assign("produits", $datas);
        }
    }

    public function deleteProductAction()
    {
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {

            $product_term = new Product_term;
            $pt = new Product_term;
            $datas = $product_term
                ->select("*")
                ->where("idGroup = :id")->setParams(["id" => $_GET["id"]])
                ->get(); 

            foreach($datas as $key => $d){
                $pt->populate($datas[$key]);
                $pt->setStatus(0);
                $pt->save();
            }

        } 

        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }

    public function updateProductFormAction()
    {
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
            $product_model = new Products;
            $categories = new Category;
            $attribute = new Attributes();
            $product = new Products;

            $checkId = $product
                ->select("id")
                ->where("id = :id")->setParams(["id" => $_GET["id"]])
                ->get();

            if(!empty($checkId)){
                $view = new View("updateProduct.back","back");
                $view->assign("title", "Modification d'un produit");
                $view->assign("stylesheet", "products");
                
                $datas = $product_model
                    ->select("*, ". DBPREFIXE ."products.name as productName, ". DBPREFIXE ."products.id as idP, ". DBPREFIXE ."product_term.id as idpt, ". DBPREFIXE ."group_variant.id as idgv, ". DBPREFIXE ."terms.id as idt")
                    ->innerJoin(DBPREFIXE."category", DBPREFIXE."category.id", "=", DBPREFIXE."products.idCategory")
                    ->innerJoin(DBPREFIXE."product_term", DBPREFIXE."product_term.idProduct", "=", DBPREFIXE."products.id")
                    ->innerJoin(DBPREFIXE."terms", DBPREFIXE."terms.id", "=", DBPREFIXE."product_term.idTerm")
                    ->innerJoin(DBPREFIXE."group_variant", DBPREFIXE."group_variant.id", "=", DBPREFIXE."product_term.idGroup")
                    ->where(DBPREFIXE."products.id = :id", DBPREFIXE."product_term.status <> 0")->setParams(["id" => $_GET["id"]])
                    ->get();

                $datas_inputs = [];

                $keys = ["picture","nameAttr", "stock", "price", "idGroup", "idAttr", "idTerm", "idProductTerm", "idProduct"];

                $comb = [];

                foreach($datas as $key => $data){
                    $datas_inputs[$key] = [];
                    array_push($datas_inputs[$key], $data["picture"]);
                    array_push($datas_inputs[$key], $data["name"]);
                    array_push($datas_inputs[$key], $data["stock"]);
                    array_push($datas_inputs[$key], $data["price"]);
                    array_push($datas_inputs[$key], $data["idgv"]);
                    array_push($datas_inputs[$key], $data["idAttributes"]);
                    array_push($datas_inputs[$key], $data["idTerm"]);
                    array_push($datas_inputs[$key], $data["idpt"]);
                    array_push($datas_inputs[$key], $data["idP"]);
                    $datas_inputs[$key] = array_combine($keys, $datas_inputs[$key]);
                }

                foreach($datas_inputs as $key => $value){
                    isset($comb[$value["idGroup"]]) ? 
                    array_push($comb[$value["idGroup"]], $value) :
                    $comb[$value["idGroup"]] = [$value];
                }


                $categories = $categories
                    ->select()
                    ->where("status = 0")
                    ->get();

                $attributes = $attribute
                    ->select("id, name")
                    ->where("id <> 1")
                    ->get();

                $product = new Products;
                $datas_p = $product
                    ->select("*,name as productName")
                    ->where("id = :id")->setParams(["id" => $_GET["id"]])
                    ->get();

                $view->assign("attributes", $attributes);
                $view->assign("datas_inputs", $comb);
                $view->assign("produits", $datas);
                $view->assign("p", $datas_p);
                $view->assign("categories", $categories);
                $view->assign("file_stylesheet","../../dist/product.css");
            }else{
                throw new MyException("Produit introuvable !", 404);
            }
        }else{
            header("location:javascript://history.go(-1)");
        }
    }

    //Mise à jour du produit
    public function updateProductAjaxAction(){

        $pid = new Products;
        $checkId = FormValidator::checkId($_GET['id'], $pid);
        if( isset($_POST['comb_array']) && 
            isset($_POST['product']) &&
            count($_POST) === 2 &&
            isset($_GET["id"]) &&
            is_numeric($_GET["id"]) &&
            $checkId
        ){

            //Instanciation des classes
            $gv = new Group_variant;
            $pt = new Product_term;
            $pt1 = new Product_term;
            $product_model = new Products;
            $terms = new Terms;
            $category = new Category;
            $produit = new Products;

            $comb = json_decode($_POST['comb_array'], true);
            $product = json_decode($_POST['product'], true);

            $lt= $terms
                ->select("id")
                ->get();

            $lc = $category
                ->select("id")
                ->where("status = 0")
                ->get();

            $list_categories = [];
            $list_terms = [];

            foreach ($lt as $value) {
                $list_terms[] = $value["id"];
            }
            foreach ($lc as $value) {
                $list_categories[] = $value["id"];
            }

            $errors = FormValidator::checkProductUpdate($product, $list_categories, $comb, $product_model, $list_terms);

            if (empty($errors)) {

                $pt_data = $pt
                    ->select()
                    ->where("idProduct= :idProduct", "status = 1")
                    ->setParams(["idProduct" => $_GET["id"]])
                    ->get();

                foreach($pt_data as $key => $data){
                    $pt->populate($pt_data[$key]);
                    $pt->setStatus(0);
                    $pt->save();
                }


                $produit->populate($product);
                $produit->setId($_GET["id"]);
                $produit->setType(1);
                $produit->setStatus(1);
                $produit->save();

                $idProduct = $_GET["id"];

                foreach($comb as $key => $value){

                    //Id group pour l'image
                    $idG = new Group_variant;

                    $idG = $idG->select("MAX(id) as id")->get();
                    $idG = $idG[0]["id"] + 1;
                    if(isset($_FILES['file_'.$key])){    
                        $f = $_FILES['file_'.$key];                   
                        $upload = new Uploader($f,false);
                        $res = $upload
                            ->setName("file_".$idG)
                            ->setSize(10)
                            ->setDirectory("./images/products")
                            ->upload();
                        $s = $value[count($value)-2];
                        $p = $value[count($value)-1];

                        //Destruction des variables prix - stock
                        unset($value[count($value)-1], $value[count($value)-1]);
                        $gv->setPrice($p);
                        $gv->setStock($s);
                        ($res) ? $gv->setPicture($upload->getName().".".$upload->getExtension()) : $gv->setPicture("");
                        $gv->save();
                    }else{
                        $s = $value[count($value)-2];
                        $p = $value[count($value)-1];

                        //Destruction des variables prix - stock
                        unset($value[count($value)-1], $value[count($value)-1]);

                        $gv->setPrice($p);
                        $gv->setStock($s);
                        $gv->setPicture("");
                        $gv->save();
                    }

                    //Récupération de l'id du groupe
                    $idGroup = $gv
                    ->select("MAX(id) as id")
                    ->get();

                    $idGroup = $idGroup[0]["id"];

                    foreach($value as $v){
                        $pt1->setIdProduct($idProduct);
                        $pt1->setIdTerm($v);
                        $pt1->setIdGroup($idGroup);
                        $pt1->setStatus(1);
                        $pt1->save();
                    }
                }
                echo "<div class='alert alert--green'>Produit modifié avec succès !</div>";
                \http_response_code(201);

            }else{
                echo "<ul class='alert alert--red'>";
                    foreach($errors as $err){
                        echo "<li>". $err ;
                    }
                echo "</ul>";
            }

        }else{
            \http_response_code(403);
        }
    }


    public function updateVarAction(){
        if (isset($_GET["id"], $_POST['price'], $_POST['stock']) &&
            is_numeric($_GET["id"]) &&
            count($_POST) === 2) 
        {
            $group_id = new Group_variant;
            $checkId = FormValidator::checkId($_GET["id"], $group_id);
            $errors = FormValidator::checkGroup($_POST["stock"], $_POST["price"]);
            if(empty($errors)){
                $group = new Group_variant;
                $group->setId($_GET["id"]);
                $group->setPrice($_POST['price']);
                $group->setStock($_POST['stock']);
                $group->save();

                echo "<div class='alert alert--green'>Variante modifiée avec succès !</div>";

                \http_response_code(201);
            }else{
                echo "<ul class='alert alert--red'>";
                foreach($errors as $err){
                    echo "<li>". $err ;
                }
                echo "</ul>";   
            }
        }else{
            \http_response_code(403);
        }

    }

    public function updateAction(){
        if (isset($_GET["id"], 
            $_POST['name'], 
            $_POST['idCategory'],
            $_POST['description'],
            $_POST['type']) &&
            is_numeric($_GET["id"]) &&
            count($_POST) === 4) 
        {
            $product_id = new Products;
            $checkId = FormValidator::checkId($_GET["id"], $product_id);
            $product = new Products;

            $category = new Category;
            $category = $category
                ->select("id")
                ->get();

            $categories = [];
            foreach ($category as $value) {
                $categories[] = $value["id"];
            }

            $errors = 
            FormValidator::checkProduct1($product, $_POST['name'], $_POST['idCategory'], $categories, $_POST['type'], false);

            if(empty($errors) && $checkId){
                $p = new Products;
                $p->populate($_POST);
                $p->setId($_GET["id"]);
                $p->setStatus(0);
                $p->setIsPublished(0);
                $p->save();

                echo "<div class='alert alert--green'>Produit modifié avec succès !</div>";

                \http_response_code(201);
            }else{
                echo "<ul class='alert alert--red'>";
                foreach($errors as $err){
                    echo "<li>". $err ;
                }
                echo "</ul>";   
            }
        }else{
            \http_response_code(403);
        }    
    }

    public function addProductWVAction(){
        if(isset($_POST["product"]) && count($_POST) === 1 &&
            isset($_FILES["file"]) && count($_FILES) === 1 || 
            isset($_POST["product"], $_POST['file']) && count($_POST) === 2
        ){

            $product = json_decode($_POST["product"], true);
            $s = $product["stock"];
            $p = $product["price"];

            $gv = new Group_variant;
            $product_model = new Products;
            $pt = new Product_term;

            $gv->setStock($product["stock"]);
            $gv->setPrice($product["price"]);

            $f = $_FILES["file"];
            //Id group pour l'image
            $idG = new Group_variant;

            $idG = $idG->select("MAX(id) as id")->get();
            $idG = $idG[0]["id"] + 1;
            $upload = new Uploader($f,false);
            $res = $upload
                ->setName("file_".$idG)
                ->setSize(10)
                ->setDirectory("./images/products")
                ->upload();

            if(isset($f) && $res){
                $gv->setPicture($upload->getName().".".$upload->getExtension());
            }else{
                $gv->setPicture("");
            }
            $gv->save();

            unset($s, $p);
            $product_model->populate($product);
            $product_model->setStatus(1);
            $product_model->save();

            //Récupération de l'id produit
            $idProduct = $product_model
            ->select("MAX(id) as id")
            ->get();

            $idProduct = $idProduct[0]["id"];

            //Récupération de l'id du groupe
            $idGroup = $gv
            ->select("MAX(id) as id")
            ->get();

            $idGroup = $idGroup[0]["id"];
            $pt->setIdProduct($idProduct);
            $pt->setIdGroup($idGroup);
            $pt->setStatus(1);
            $pt->save();

            echo "<div class='alert alert--green'>Produit créé avec succès !</div>";

            http_response_code(201);

        }else{
            http_response_code(403);
        }
    }

    public function delProductAction()
    {
        if(isset($_GET["id"]) && is_numeric($_GET["id"])){
            
            $pid = new Products;
            $checkId = FormValidator::checkId($_GET['id'], $pid);
            $product = new Products;

            $product_datas = $product
                ->select()
                ->where("id = :id")->setParams(["id" => $_GET["id"]])
                ->get();

            if($checkId){
                $product->populate($product_datas[0]);
                $product->setStatus(0);
                $product->save();
            }else{
                throw new MyException("Erreur sur la suppression du produit", 403);
            }
            header("Location: /admin/liste-produits");
        }else{
            http_response_code(404);
        }
    }

    public function publishProductAction(){
        if(isset($_GET["id"]) && is_numeric($_GET["id"])){
            $pid = new Products;
            $checkId = FormValidator::checkId($_GET['id'], $pid);
            $product = new Products;

            $product_datas = $product
                ->select()
                ->where("id = :id")->setParams(["id" => $_GET["id"]])
                ->get();

            if($checkId){
                $product->populate($product_datas[0]);
                $product->setIsPublished(1);
                $product->save();
            }else{
                throw new MyException("Erreur sur la publication du produit", 403);
            }
            header("Location: /admin/liste-produits");
        }else{
            http_response_code(404);
        } 
    }

    public function depublishProductAction(){
        if(isset($_GET["id"]) && is_numeric($_GET["id"])){
            $pid = new Products;
            $checkId = FormValidator::checkId($_GET['id'], $pid);
            $product = new Products;

            $product_datas = $product
                ->select()
                ->where("id = :id")->setParams(["id" => $_GET["id"]])
                ->get();

            if($checkId){
                $product->populate($product_datas[0]);
                $product->setIsPublished(0);
                $product->save();
            }else{
                throw new MyException("Erreur sur la dépublication du produit", 403);
            }
            header("Location: /admin/liste-produits");
        }else{
            http_response_code(404);
        } 
    }

}
