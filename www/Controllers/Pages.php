<?php
namespace App\Controller;

use App\Core\FormValidator;
use App\Core\View;
use App\Models\Pages as modelPages;


class Pages
{
    public function showAction(){

        $pages = new modelPages();
        $array = $pages->select()->get();


        $view = new View("displayPages.back", "back");
        $view->assign("title", "Liste des pages");
        $view->assign("array", $array);
    }


    public function newPageAction(){

        $pages = new modelPages();
        $view = new View("createPage.back", "back");
        $view->assign("title", "Admin - page");


        $form = $pages->formBuilderRegister();

        if(!empty($_POST)){

            $errors = FormValidator::check($form, $_POST);
            $errorSlug = FormValidator::checkSlug($_POST["slug"]);

            if(empty($errors)){
                if (empty($errorSlug)){
                    $pages->populate($_POST);
                    $pages->setUserid(2);
                    $pages->save();

                    file_put_contents("./publisher/templatesPublisher/".$_POST["name"].".json", "");

                    header('location:/admin/display-pages');
                }else{
                    $view->assign("errors", $errorSlug);
                }
            }else{
                $view->assign("errors", $errors);
            }
        }

    }

    public function updatePageAction(){

        if (isset($_GET['id']) && !empty($_GET['id'])){

            $pages = new modelPages();
            $verifyId = $pages->select("id")->where("id = :id")->setParams(["id" => $_GET['id']])->get();

            if (empty($verifyId)){
                header("Location: /admin/display-pages");
                exit();
            }

            $view = new View("updatePage.back", "back");

            $form = $pages->formBuilderRegister();
            $this->saveForm($view,$pages,$form,true);

            $values = $pages->select("*")->where("id = :id")->setParams(["id" => $_GET['id']])->get();

            $view->assign("values", $values);
            $view->assign("title", "Admin - Page");

        }else{
            header("Location: /admin/display-page");
            exit();
        }
    }
}