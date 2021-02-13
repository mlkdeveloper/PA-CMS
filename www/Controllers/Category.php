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



        if(!empty($_POST)){

            unset($_POST["table_length"]);

            $name = htmlspecialchars(trim($_POST['name']));
            $description = htmlspecialchars(trim($_POST['description']));
            $status = $_POST['status'];

            $fields = [ "name" => $name, "description" => $description, "status" => $status];

            $errors = FormValidator::checkFormCategory($form, $fields);


            if (empty($errors)){

                $category->setName($name);
                $category->setDescription($description);
                $category->setStatus($status);

                $category->save();

            }else{

                $view->assign("errors", $errors);
            }

        }
        $view->assign("title", "Admin - catégorie");

    }




}

