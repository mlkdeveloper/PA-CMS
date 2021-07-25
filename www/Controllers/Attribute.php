<?php


namespace App\Controller;


use App\Core\FormValidator;
use App\Core\Security;
use App\Core\View;
use App\Models\Attributes;
use App\Models\Terms;

session_start();

class Attribute
{

    public function attributeAction(){
        Security::auth("products");

        $view = new View("attribute.back","back");
        $view->assign("title","Attribut");

        $attribute = new Attributes();
        $form = $attribute->formBuilderAttribute();

        if (!empty($_POST)){

            $errors = FormValidator::checkFormAttribute($form, $_POST,$attribute,false);

            if (empty($errors)){
                $attribute->populate($_POST);
                $attribute->save();
                $view->assign("message","Attribut ajouté !");
            }else{
                $view->assign("errors",$errors);
            }
        }
        $attributes = new Attributes();
        $getAttributes = $attributes->select()->get();
        $view->assign("attributes",$getAttributes);


    }

    public function termsAttributeAction(){
        Security::auth("products");

        if(!empty($_GET['id']) && $_GET['id'] != 1){

            $attribute = new Attributes();
            $getAttribute = $attribute->select("id,name")->where("id = :id")->setParams(["id" => $_GET['id']])->get();

            if (empty($getAttribute)){
                header("Location: /admin/attribut");
            }else{
                $view = new View("termsAttribute.back","back");
                $term = new Terms();
                $form = $term->formBuilderTerm();

                if (!empty($_POST)){
                    $errors = FormValidator::checkFormAttribute($form, $_POST,$term,false);
                    $checkTerm = $term->select("id")->where("idAttributes = :id", "name = :name")->setParams(["id" => $_GET['id'], "name" => $_POST['name']])->get();

                    if (!empty($checkTerm))
                        $errors[] = "Cette valeur existe déjà ! ";

                    if (empty($errors)){
                        $term->populate($_POST);
                        $term->setIdAttributes($_GET["id"]);
                        $term->save();
                        $view->assign("message","Valeur ajoutée !");
                    }else{
                        $view->assign("errors",$errors);
                    }
                }

                $getTerms =  $term->select()->where("idAttributes = :id")->setParams(["id" => $_GET['id']])->get();
                $view->assign("terms",$getTerms);
                $view->assign("nameAttribute",$getAttribute[0]['name']);
                $view->assign("title","Valeurs");
            }

        }else{
            header("Location: /admin/attribut");
        }

    }

    public function updateAttributeAction(){
        Security::auth("products");

        if(!empty($_GET['id']) && $_GET['id'] != 1){

            $attribute = new Attributes();
            $verifyAttribute = $attribute->select("id,name")->where("id = :id")->setParams(["id" => $_GET['id']])->get();

            if (empty($verifyAttribute)){
                header("Location: /admin/attribut");
            }else{
                $view = new View("updateAttribute.back","back");
                $view->assign("title","Modification attribut");
                $form = $attribute->formBuilderAttribute();

                if (!empty($_POST)){

                    $checkAttribute = new Attributes();
                    $errors = FormValidator::checkFormAttribute($form, $_POST,$checkAttribute,$_POST['name'] == $verifyAttribute[0]['name']);

                    if (empty($errors)){
                        $attribute->setId($_GET['id']);
                        $attribute->populate($_POST);
                        $attribute->save();
                        $view->assign("message","Attribut modifié !");
                    }else{
                        $view->assign("errors",$errors);
                    }
                }

                $getAttribute = $attribute->select("id,name,description")->where("id = :id")->setParams(["id" => $_GET['id']])->get();
                $view->assign("attribute",$getAttribute[0]);
            }

        }else{
            header("Location: /admin/attribut");
        }
    }

    public function deleteAttributeAction(){
        Security::auth("products");

        if(!empty($_POST["id"])){

            if($_POST["id"] != 1){

                $attribute = new Attributes();
                $term = new Terms();
                $verifyAttribute = $attribute->select("id")->where("id = :id")->setParams(["id" => $_POST['id']])->get();

                if (empty($verifyAttribute)){
                    echo "Erreur !";
                    http_response_code(404);
                }else{

                    $term->where("idAttributes = :id")->setParams(["id" => $_POST['id']])->delete();
                    $res = $attribute->where("id = :id")->setParams(["id" => $_POST['id']])->delete();
                
                    if($res){
                        echo "Attribut supprimé !";
                        http_response_code(200);
                    }else{
                        echo "Erreur lors de la suppression !";
                        http_response_code(400);
                    }
                }
            }else{
                echo "Erreur !";
                http_response_code(403);
            }
        }else{
            header("Location: /admin/attribut");
            http_response_code(400);
        }
    }

    public function deleteTermAction(){
        Security::auth("products");

        if(!empty($_POST["id"]) && !empty($_POST["idAttributes"])){
            
            $term = new Terms();
            $verifyTerm = $term->select("id")->where("id = :id", "idAttributes = :idAttributes")->setParams(["id" => $_POST['id'],"idAttributes" => $_POST['idAttributes']])->get();
            
            if (empty($verifyTerm)){
                echo "Erreur !";
                http_response_code(404);
                
            }else{
                $res = $term->where("id = :id")->setParams(["id" => $_POST['id']])->delete();
                if($res){
                    echo "Terme supprimé !";
                    http_response_code(200);
                }else{
                    echo "Erreur lors de la suppression !";
                    http_response_code(400);
                }
            }
        }else{
            header("Location: /admin/attribut");
            http_response_code(400);
        }
    }
}  