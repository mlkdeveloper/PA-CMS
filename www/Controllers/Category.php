<?php

namespace App\Controller;

use App\Core\FormValidator;
use App\Core\View;
use App\Models\Category as modelCategory;

class Category{

    public function showAction(){

        $category = new modelCategory();
        $array = $category->select()->get();

        $view = new View("displayCategory.back", "back");
        $view->assign("title", "Liste des catégories");
        $view->assign("array", $array);

    }

    public function newCategoryAction(){

        $category = new modelCategory();
        $view = new View("createCategory.back", "back");

        $form = $category->formBuilderRegister();

        if(!empty($_POST) && !empty($_FILES)){

            $errors = FormValidator::checkFormCategory($form, $_POST, $_FILES);

            if (empty($errors)){

                $category->populate($_POST);

                if($_FILES["categoryImage"]["error"] === 0 ) {
                    $imageName = time() . '_' . $_FILES['categoryImage']['name'];
                    $target = './images/' . $imageName;
                    move_uploaded_file($_FILES['categoryImage']['tmp_name'], $target);
                    $category->setPicPath($imageName);
                }
                $category->save();

            }else{
                $view->assign("errors", $errors);
            }
        }
        $view->assign("title", "Admin - catégorie");
    }

    public function updateCategoryAction(){

        if (isset($_GET['id']) && !empty($_GET['id'])){

            $category = new modelCategory();
            $verifyId = $category->select("id")->where("id = :id")->setParams(["id" => $_GET['id']])->get();

            if (empty($verifyId))
                header("Location: /admin/display-category");

            $view = new View("updateCategory.back", "back");

            $form = $category->formBuilderRegister();
            $this->saveForm($view,$category,$form,true);

            $values = $category->select()->where("id = :id")->setParams(["id" => $_GET['id']])->get();
            $view->assign("values", ...$values);
            $view->assign("title", "Admin - catégorie");

        }else{
            header("Location: /admin/display-category");
        }
    }

    public function saveForm($view,$category,$form,$formStatus = false){

        if(!empty($_POST) && !empty($_FILES)){

            if (isset($_POST["table_length"]))
                unset($_POST["table_length"]);

            $errors = FormValidator::checkFormCategory($form, $_POST, $_FILES);

            if (empty($errors)){

                if ($formStatus)
                    $category->setId($_GET['id']);

               $category->populate($_POST);

                if($_FILES["categoryImage"]["error"] === 0 ) {
                    $imageName = time() . '_' . $_FILES['categoryImage']['name'];
                    $target = './images/' . $imageName;
                    move_uploaded_file($_FILES['categoryImage']['tmp_name'], $target);
                    $category->setPicPath($imageName);
                }
                $category->save();
            }else{
                $view->assign("errors", $errors);
            }
        }
    }

}

