<?php

namespace App\Controller;

use App\Core\FormValidator;
use App\Core\View;
use App\Models\Category as modelCategory;
use App\Models\Products;

use App\Core\Security;

session_start();

class Category{

    public function showAction(){

        Security::auth('categories');

        $category = new modelCategory();
        $listCategory = $category->select()->get();

        $view = new View("displayCategory.back", "back");
        $view->assign("title", "Liste des catégories");
        $view->assign("listCategory", $listCategory);

    }

    public function newCategoryAction(){

        Security::auth('categories');

        $category = new modelCategory();
        $view = new View("createCategory.back", "back");

        $form = $category->formBuilderRegister();

        if(!empty($_POST)){

            $errors = FormValidator::checkFormCategory($form, $_POST,false);

            if (empty($errors)){

                $category->populate($_POST);
                $category->save();

                $view->assign("successNewCategory", "Catégorie créée !");

            }else{
                $view->assign("errors", $errors);
            }
        }
        $view->assign("title", "Admin - catégorie");
    }

    public function updateCategoryAction(){

        Security::auth('categories');

        if (isset($_GET['id']) && !empty($_GET['id'])){

            $category = new modelCategory();
            $columns = $category->select()->where("id = :id")->setParams(["id" => $_GET['id']])->get();

            if (empty($columns)) {
                header("Location: /admin/display-category");
                exit();
            }


            $category->populate($columns[0]);
            $view = new View("updateCategory.back", "back");
            $view->assign("title", "Admin - catégorie");


            $form = $category->formBuilderRegister();

            if(!empty($_POST) ){

                $errors = FormValidator::checkFormCategory($form, $_POST,trim($_POST['name']) === $category->getName());

                if (empty($errors)){

                    $category->setId($_GET['id']);
                    $category->populate($_POST);
                    $category->save();

                    $view->assign("successUpdateCategory", "Catégorie modifiée !");
                }else{
                    $view->assign("errors", $errors);
                }
            }

            $view->assign("category", $category);
        }else{
            header("Location: /admin/display-category");
        }
    }

    public function deleteCategoryAction(){

        Security::auth('categories');

        if(isset($_GET['id']) && !empty($_GET['id']) ){

            $category = new modelCategory();
            $checkId = $category->where("id = :id")->setParams(['id' => $_GET['id']])->get();

            if (empty($checkId)){
                header("Location: /admin/display-category");
                exit();
            }

            $product = new Products();
            $checkProduct = $product->select('id')->where("idCategory = :id")->setParams(["id" => $_GET['id']])->get();

            if (empty($checkProduct)){
                $category->where("id = :id")->setParams(['id' => $_GET['id']])->delete();
                $_SESSION['successDeleteCategory'] = "Catégorie supprimé !";
            }else{
                $_SESSION['errorDeleteCategory'] = "Vous ne pouvez pas supprimé cette catégorie.";
            }
            header("Location: /admin/display-category");
        }else{
            header("Location: /admin/display-category");
        }
    }

}

