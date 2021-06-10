<?php

namespace App\Controller;

use App\Core\FormValidator;
use App\Core\View;
use App\Models\Category as modelCategory;

class Category{

    public function showAction(){

        $category = new modelCategory();
        $listCategory = $category->select()->get();

        $view = new View("displayCategory.back", "back");
        $view->assign("title", "Liste des catégories");
        $view->assign("listCategory", $listCategory);

    }

    public function newCategoryAction(){

        $category = new modelCategory();
        $view = new View("createCategory.back", "back");

        $form = $category->formBuilderRegister();

        if(!empty($_POST)){

            $errors = FormValidator::checkFormCategory($form, $_POST);

            if (empty($errors)){

                $category->populate($_POST);
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
            $columns = $category->select()->where("id = :id")->setParams(["id" => $_GET['id']])->get();

            if (empty($columns))
                header("Location: /admin/display-category");

            $category->populate($columns[0]);
            $view = new View("updateCategory.back", "back");
            $view->assign("title", "Admin - catégorie");


            $form = $category->formBuilderRegister();
            $this->saveForm($view,$category,$form,false);

            $view->assign("category", $category);
        }else{
            header("Location: /admin/display-category");
        }
    }

    public function saveForm($view,$category,$form,$newCategory){

        if(!empty($_POST) ){

            if (isset($_POST["table_length"]))
                unset($_POST["table_length"]);

            $errors = FormValidator::checkFormCategory($form, $_POST);

            if (empty($errors)){

                if ($newCategory === false)
                    $category->setId($_GET['id']);

               $category->populate($_POST);
               $category->save();
            }else{
                $view->assign("errors", $errors);
            }
        }
    }

}

