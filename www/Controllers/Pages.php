<?php
namespace App\Controller;

use App\Core\FormValidator;
use App\Core\Routes;
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
        $view->assign("title", "Création de la page");


        $form = $pages->formBuilderRegister();

        if(!empty($_POST)){

            $errors = FormValidator::checkPage($form, $_POST);

            if(empty($errors)){

                    $pages->populate($_POST);
                    $pages->setUserid(2);
                    $pages->save();

                    file_put_contents("./publisher/templatesPublisher/".$_POST["name"].".json", "");

                    $pageRoute = new Routes(explode("/", $_POST["slug"])[1]);

                    try {
                        $pageRoute->addRoute();
                    }catch (MyException $e){
                        echo $e->error();
                    }

                    header('location:/admin/display-pages');

            }else{
                $view->assign("errors", $errors);
            }
        }

    }

    public function updatePageAction(){

        if (isset($_GET['id']) && !empty($_GET['id'])){

            $pages = new modelPages();
            $verifyId = $pages->select()->where("id = :id")->setParams(["id" => $_GET['id']])->get();

            if (empty($verifyId)){
                header("Location: /admin/display-pages");
                exit();
            }

            $view = new View("updatePage.back", "back");

            $form = $pages->formBuilderRegister();

            if(!empty($_POST)){

                $errors = FormValidator::checkPage($form, $_POST);

                if(empty($errors)){
                    $pages->populate($_POST);
                    $pages->setUserid(2);
                    $pages->setId($_GET['id']);
                    $pages->save();

                    rename("./publisher/templatesPublisher/".$verifyId[0]["name"].".json","./publisher/templatesPublisher/".$_POST["name"].".json");

                    header('location:/admin/display-pages');

                }else{
                    $view->assign("errors", $errors);
                }
            }

            $pages->populate($verifyId[0]);
            $view->assign("title", "Modification de la page");
            $view->assign("values", $pages);
        }else{
            header("Location: /admin/display-page");
            exit();
        }
    }

    public function deletePageAction(){
        $idPage = $_GET["idPage"];
        $name = $_GET["name"];
        $slug = explode("/", $_GET["slug"])[1];

        $pages = new modelPages();
        $pages->where("id =:id")->setParams(["id" => $idPage])->delete();
        unlink("./publisher/templatesPublisher/".$name.".json");

        $pageRoute = new Routes($slug);

        try {
            $pageRoute->deleteRoute();
        }catch (MyException $e){
            echo $e->error();
        }

        header("Location: /admin/display-pages");
    }
}