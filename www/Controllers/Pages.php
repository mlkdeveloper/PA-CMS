<?php
namespace App\Controller;

use App\Core\FormValidator;
use App\Core\Routes;
use App\Core\View;
use App\Models\Pages as modelPages;
use App\Models\Navbar as modelNavbar;
use App\Models\Tab_navbar as modelTab_navbar;

$myPage = new Pages();

if (isset($_POST['jsonPage'])){
    $myPage->readPage($_POST['jsonPage']);
}

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
                    $pages->setUserid(1);
                    $pages->setPublication(0);
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
        if (isset($_GET['id']) && isset($_GET['slug']) && $_GET['id'] != 1){

            $pages = new modelPages();
            $verifyId = $pages->select()->where("id = :id", "slug = :slug")->setParams(["id" => $_GET['id'], "slug" => $_GET['slug']])->get();
            if (empty($verifyId)){
                header("Location: /admin/display-pages");
                exit();
            }
            $pages->populate($verifyId[0]);

            $view = new View("updatePage.back", "back");

            $form = $pages->formBuilderRegister();

            if(!empty($_POST)){

                $errors = FormValidator::checkPage($form, $_POST);

                if(empty($errors)){
                    $pages->populate($_POST);
                    $pages->setUserid(3);
                    $pages->setId($_GET['id']);
                    $pages->save();

                    rename("./publisher/templatesPublisher/".$verifyId[0]["name"].".json","./publisher/templatesPublisher/".$_POST["name"].".json");

                    $pageRoute = new Routes(explode("/", $_POST["slug"])[1]);

                    try {
                        $pageRoute->updateRoute(explode("/", $_GET["slug"])[1]);
                    }catch (MyException $e){
                        echo $e->error();
                    }

                    header('location:/admin/display-pages');

                }else{
                    $view->assign("errors", $errors);
                }
            }


            $view->assign("title", "Modification de la page");
            $view->assign("values", $pages);
        }else{
            header("Location: /admin/display-page");
            exit();
        }
    }

    public function deletePageAction(){

        if(isset($_GET["idPage"])
            && isset($_GET["name"])
            && $_GET['idPage'] != 1) {
            $idPage = $_GET["idPage"];
            $name = $_GET["name"];
            $slug = explode("/", $_GET["slug"])[1];

            $pages = new modelPages();
            $pages->where("id =:id")->setParams(["id" => $idPage])->delete();
            unlink("./publisher/templatesPublisher/" . $name . ".json");

            $pageRoute = new Routes($slug);

            try {
                $pageRoute->deleteRoute();
            } catch (MyException $e) {
                echo $e->error();
            }

            header("Location: /admin/display-pages");
            exit();
        }else{
            header("Location: /admin/display-pages");
            exit();
        }
    }

    public function displayFrontAction(){
        $uri = $_SERVER['REQUEST_URI'];
        $pages = new modelPages();
        $pagesNavbar = new modelPages();
        $navbar = new modelNavbar();
        $tabNavbar = new modelTab_navbar();

        $arrayPage = $pages->select("name", "publication")->where("slug = :slug")->setParams(["slug" => $uri])->get();
        foreach ($arrayPage as $value);

        $arrayNavbar = $navbar->select()->orderBy('sort', 'ASC')->get();
        $arrayTabNavbar = $tabNavbar->select()->orderBy('sort', 'ASC')->get();
        $arrayPages = $pagesNavbar->select()->get();

        if ($value["publication"] == 1) {
            $view = new View("displayPagesFront", "front");
            $view->assign("title", $value['name']);
            $view->assign("navbar", $arrayNavbar);
            $view->assign("tabNavbar", $arrayTabNavbar);
            $view->assign("pages", $arrayPages);
        }else{
            header("Location: /");
            exit();
        }
    }

    public function readPage($namePage){
        if (file_exists("../publisher/templatesPublisher/".$namePage.".json")){
            echo (file_get_contents("../publisher/templatesPublisher/".$namePage.".json"));
        }else {
            echo null;
        }
    }

    public function updatePublicationAction(){

        if(isset($_POST['valuePublication'])
        && isset($_POST['idPage'])
        && $_POST['idPage'] != 1
        && ($_POST['valuePublication'] == 0 || $_POST['valuePublication'] == 1)){

            $pages = new modelPages();

            $verifyId = $pages->select()->where("id = :id")->setParams(["id" => $_POST['idPage']])->get();

            $pages->populate($verifyId[0]);


            if (empty($verifyId)){
                header("Location: /admin/display-pages");
                exit();
            }

            $pages->setPublication($_POST['valuePublication']);
            $pages->setUserid(1);
            $pages->setId($_POST['idPage']);
            $pages->save();
        }else{
            header("Location: /admin/display-pages");
            exit();
        }
    }
}