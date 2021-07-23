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
        ->where("status = 1")
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
                ->where("status = 1")
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
                        ($res) ? $gv->setPicture($upload->getName().".".$upload->getExtension()) : $gv->setPicture(NULL);
                        $gv->save();
                    }else{
                        $s = $value[count($value)-2];
                        $p = $value[count($value)-1];

                            unset($value[count($value)-1], $value[count($value)-1]);

                        $gv->setPrice($p);
                        $gv->setStock($s);
                        $gv->setPicture(NULL);
                        $gv->save();
                    }

                    //Récupération de l'id du groupe
                    $idGroup = $gv
                    ->select("MAX(id) as id")
                    ->get();

                    $idGroup = $idGroup[0]["id"];

                    foreach($value as $v){
                        $pt->setIdProduct($idProduct);
                        $v != 1 ? $pt->setIdTerm($v) : http_response_code(403);
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
        $product_model = new Products();
        $categories = new Category();

        if(isset($_GET["id"]) && is_numeric($_GET["id"])){
            $pid = new Products;
            $checkId = FormValidator::checkId($_GET["id"], $pid);
            $attribute = new Attributes();


            if($checkId){
                $view = new View("infoProducts_products.back","back");
                $view->assign("title", "Information du produit");
                $view->assign("stylesheet", "products");

                $datas = $product_model

                    ->select("*, ". DBPREFIXE ."products.name as productName, ". DBPREFIXE ."products.id as idP, ". DBPREFIXE ."product_term.id as idpt, ". DBPREFIXE ."group_variant.id as idgv, ". DBPREFIXE ."terms.id as idt," . DBPREFIXE."product_term.status as statuspt")

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
                    ->where("status = 1")
                    ->get();

                $attributes = $attribute
                    ->select("id, name")
                    ->where("id <> 1")
                    ->get();

                $product = new Products;
                $datas_p = $product
                    ->select("*,name as productName")
                    ->where("id = :id", "status <> 0")->setParams(["id" => $_GET["id"]])
                    ->get();


                $view->assign("attributes", $attributes);
                $view->assign("datas", $comb);
                $view->assign("produits", $datas);
                $view->assign("p", $datas_p);
                $view->assign("categories", $categories);
                $view->assign("produitVar", "");
            }else{
                throw new MyException("Produit introuvable", 403);
            }
        }else{
            throw new MyException("Produit introuvable", 403);
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

            $pid = new Products;
            $checkId = FormValidator::checkId($_GET["id"], $pid);

            if($checkId){
                $view = new View("updateProduct.back","back");
                $view->assign("title", "Modification d'un produit");
                $view->assign("stylesheet", "products");
                
                $datas = $product_model

                    ->select("*, ". DBPREFIXE ."products.name as productName, ". DBPREFIXE ."products.id as idP, ". DBPREFIXE ."product_term.id as idpt, ". DBPREFIXE ."group_variant.id as idgv, ". DBPREFIXE ."terms.id as idt," . DBPREFIXE."product_term.status as statuspt")

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
                    ->where("status = 1")
                    ->get();

                $attributes = $attribute
                    ->select("id, name")
                    ->where("id <> 1")
                    ->get();

                $product = new Products;
                $datas_p = $product
                    ->select("*,name as productName")
                    ->where("id = :id", "status <> 0")->setParams(["id" => $_GET["id"]])
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
                ->where("status = 1")
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
                        ($res) ? $gv->setPicture($upload->getName().".".$upload->getExtension()) : $gv->setPicture(NULL);
                        $gv->save();
                    }else{
                        $s = $value[count($value)-2];
                        $p = $value[count($value)-1];

                        //Destruction des variables prix - stock
                        unset($value[count($value)-1], $value[count($value)-1]);

                        $gv->setPrice($p);
                        $gv->setStock($s);
                        $gv->setPicture(NULL);
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
                $data_group = $group
                    ->select()
                    ->where("id = :id")->setParams(["id" => $_GET["id"]])
                    ->get();

                $group->populate($data_group[0]);
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
                ->where("status = 1")
                ->get();

            $categories = [];
            foreach ($category as $value) {
                $categories[] = $value["id"];
            }

            $errors = 
            FormValidator::checkProduct1($product, trim($_POST['name']), $_POST['idCategory'], $categories, $_POST['type'], false);

            if(empty($errors) && $checkId){
                $p = new Products;
                $p->populate($_POST);
                $p->setId($_GET["id"]);
                $p->setStatus(1);
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

            $category = new Category;
            $category = $category
                ->select("id")
                ->where("status = 1")
                ->get();

            $categories = [];
            foreach ($category as $value) {
                $categories[] = $value["id"];
            }


            $errors_p = 
            FormValidator::checkProduct1(
                new Products,
                $product["name"],
                $product["idCategory"],
                $categories,
                $product["type"],
                true,
                false
            );

            $errors_g = FormValidator::checkGroup($product["stock"],$product["price"]);

            $errors = array_merge($errors_p, $errors_g);

            if(empty($errors)){
                $gv = new Group_variant;
                $product_model = new Products;
                $pt = new Product_term;

                $gv->setStock($product["stock"]);
                $gv->setPrice($product["price"]);

                if(isset($_FILES["file"])){
                   
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

                }

                if(isset($f) && $res){
                    $gv->setPicture($upload->getName().".".$upload->getExtension());
                }else{
                    $gv->setPicture(NULL);
                    echo "<div class='alert alert--warning'>Attention ! Le format d'image n'est pas correct, le fichier n'a pas été ajouté !</div>";
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
                $pt->setIdTerm(1);
                $pt->setIdGroup($idGroup);
                $pt->setStatus(1);
                $pt->save();

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
            http_response_code(404);
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

    public function delPictureAction(){
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
            $gid = new Group_variant;
            $checkId = FormValidator::checkId($_GET['id'], $gid, false);

            $group = new Group_variant;
            $datas = $group
                ->select()
                ->where("id = :id")->setParams(["id" => $_GET["id"]])
                ->get();

            if($checkId){
                $group->populate($datas[0]);
                $group->setPicture(NULL);
                $group->save();
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }else{
                throw new MyException("Erreur, contactez l'administrateur", 404);
            }

        }else{
            throw new MyException("Erreur, contactez l'administrateur", 403);
        }
    }

    public function delVariantesAction(){
        if(isset($_GET["id"]) && is_numeric($_GET["id"])){
            $pid = new Products;
            $checkId = FormValidator::checkId($_GET['id'], $pid);

            if($checkId){
                $product_term = new Product_term;
                $product = new Products;

                $datas = $product_term
                    ->select()
                    ->where("idProduct = :id")->setParams(["id" => $_GET["id"]])
                    ->get();

                foreach($datas as $key => $value){
                    $product_term->populate($datas[$key]);
                    $product_term->setStatus(0);
                    $product_term->save();
                }

                $datas_product = $product
                    ->select()
                    ->where("id = :id", "status <> 0")->setParams(["id" => $_GET["id"]])
                    ->get();

                $product->populate($datas_product[0]);
                $product->setType(0);
                $product->save();

                header('Location: ' . $_SERVER['HTTP_REFERER']);


            }else{
                throw new MyException("Erreur, contactez l'administrateur", 404);
            }

        }else{
            throw new MyException("Erreur, contactez l'administrateur", 403);
        }
    }

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

    public function updateProductWVAction(){
        $pid = new Products();
        $check_id = FormValidator::checkId($_GET["id"], $pid);
        if(isset($_POST["product"], $_GET["id"]) && count($_POST) === 1 && is_numeric($_GET["id"]) &&
            isset($_FILES["file"]) && count($_FILES) === 1 && $check_id ||
            isset($_POST["product"], $_GET["id"], $_POST['file']) && count($_POST) === 2 && is_numeric($_GET["id"]) && $check_id
        ){

            $product = json_decode($_POST["product"], true);
            $s = $product["stock"];
            $p = $product["price"];

            $category = new Category;
            $category = $category
                ->select("id")
                ->where("status = 1")
                ->get();

            $categories = [];
            foreach ($category as $value) {
                $categories[] = $value["id"];
            }


            $errors_p =
                FormValidator::checkProduct1(
                    new Products,
                    $product["name"],
                    $product["idCategory"],
                    $categories,
                    $product["type"],
                    false,
                    false
                );

            $errors_g = FormValidator::checkGroup($product["stock"],$product["price"]);

            $errors = array_merge($errors_p, $errors_g);

            if(empty($errors)){
                $pt = new Product_term();
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

                $gv = new Group_variant;
                $product_model = new Products;
                $pt = new Product_term;

                $gv->setStock($product["stock"]);
                $gv->setPrice($product["price"]);

                if(isset($_FILES["file"])){

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

                }

                if(isset($f) && $res){
                    $gv->setPicture($upload->getName().".".$upload->getExtension());
                }else{
                    $gv->setPicture(NULL);
                    echo "<div class='alert alert--warning'>Attention ! Le format d'image n'est pas correct, le fichier n'a pas été ajouté !</div>";
                }
                $gv->save();

                unset($s, $p);
                $product_model->populate($product);
                $product_model->setStatus(1);
                $product_model->setId($_GET["id"]);
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
                $pt->setIdTerm(1);
                $pt->setIdGroup($idGroup);
                $pt->setStatus(1);
                $pt->save();

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
            http_response_code(404);
        }
    }

}
