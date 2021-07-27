<?php
namespace App\Controller;

use App\Core\FormValidator;
use App\Core\Routes;
use App\Core\View;
use App\Models\Pages as modelPages;
use App\Models\Navbar as modelNavbar;
use App\Models\Tab_navbar as modelTab_navbar;
use App\Core\Security;

session_start();

class Pages
{

    public function showAction(){ //Affichage des pages


        Security::auth("pages");

        $pages = new modelPages();
        $array = $pages->select()->get();


        $view = new View("displayPages.back", "back");
        $view->assign("title", "Liste des pages");
        $view->assign("array", $array);
    }


    public function newPageAction(){ //Création d'une nouvelle page

        Security::auth("pages");
        $pages = new modelPages();
        $view = new View("createPage.back", "back");
        $view->assign("title", "Création de la page");


        $form = $pages->formBuilderRegister();

        if(!empty($_POST)){

            $errors = FormValidator::checkPage($form, $_POST, false,false);

            if(empty($errors)){

                    $pages->populate($_POST);
                    $pages->setUserid($_SESSION['user']['id']);
                    $pages->setPublication(0);
                    $pages->save();

                    file_put_contents("./publisher/templatesPublisher/".$_POST["name"].".json", "");

                    $pageRoute = new Routes(explode("/", $_POST["slug"])[1]);

                    try {
                        $pageRoute->addRoute();
                    }catch (MyException $e){
                        echo $e->error();
                    }

                    header('location:/admin/pages');

            }else{
                $view->assign("errors", $errors);
            }
        }

    }

    public function updatePageAction(){ //Modification d'une page

        Security::auth("pages");
        if (isset($_GET['id']) && isset($_GET['slug']) && $_GET['id'] != 1){

            $pages = new modelPages();
            $verifyId = $pages->select()->where("id = :id", "slug = :slug")->setParams(["id" => $_GET['id'], "slug" => $_GET['slug']])->get();
            if (empty($verifyId)){
                header("Location: /admin/pages");
                exit();
            }
            $pages->populate($verifyId[0]);

            $view = new View("updatePage.back", "back");

            $form = $pages->formBuilderRegister();

            if(!empty($_POST)){
                $errors = FormValidator::checkPage($form, $_POST, trim($_POST['name']) === $pages->getName(), trim($_POST['slug']) == $pages->getSlug());

                if(empty($errors)){
                    $pages->populate($_POST);
                    $pages->setUserid($_SESSION['user']['id']);
                    $pages->setId($_GET['id']);
                    $pages->save();

                    rename("./publisher/templatesPublisher/".$verifyId[0]["name"].".json","./publisher/templatesPublisher/".$_POST["name"].".json");

                    $pageRoute = new Routes(explode("/", $_POST["slug"])[1]);

                    try {
                        $pageRoute->updateRoute(explode("/", $_GET["slug"])[1]);
                    }catch (MyException $e){
                        echo $e->error();
                    }

                    header('location:/admin/pages');

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

    public function deletePageAction(){ //Suppression d'une page

        Security::auth("pages");

        if(isset($_GET["idPage"])
            && isset($_GET["name"])
            && $_GET['idPage'] != 1) {
            $idPage = $_GET["idPage"];
            $name = $_GET["name"];
            $slug = explode("/", $_GET["slug"])[1];

            $pages = new modelPages();
            $navbar = new modelNavbar();
            $tabNavbar = new modelTab_navbar();

            $arrayNavbar = $navbar->select()->where("page =:page")->setParams(["page" => $idPage])->get();
            $arrayTabNavbar = $tabNavbar->select()->where("page =:page")->setParams(["page" => $idPage])->get();

            if (!empty($arrayNavbar) || !empty($arrayTabNavbar)){
                $_SESSION['errorNavbar'] = 'Un onglet dans la barre de navigation comprend cette page, impossible de la supprimer';
                header("Location: /admin/pages");
                exit();
            }

            $pages->where("id =:id")->setParams(["id" => $idPage])->delete();
            unlink("./publisher/templatesPublisher/" . $name . ".json");

            $pageRoute = new Routes($slug);

            try {
                $pageRoute->deleteRoute();
            } catch (MyException $e) {
                echo $e->error();
            }

            header("Location: /admin/pages");
            exit();
        }else{
            header("Location: /admin/pages");
            exit();
        }
    }

    public function displayFrontAction(){ //Affichage des pages statiques côté front
        $uri = $_SERVER['REQUEST_URI'];
        $pages = new modelPages();

        $arrayPage = $pages->select("name", "publication")->where("slug = :slug")->setParams(["slug" => $uri])->get();
        foreach ($arrayPage as $value);


        if ($value["publication"] == 1) {
            $view = new View("displayPagesFront", "front");
            $view->assign("title", $value['name']);
        }else{
            header("Location: /");
            exit();
        }
    }

    public function readPageAction(){ //Lecture du fichier json
        $namePage = $_POST['jsonPage'];

        if (file_exists("./publisher/templatesPublisher/".$namePage.".json")){
            echo (file_get_contents("./publisher/templatesPublisher/".$namePage.".json"));
        }else {
            echo null;
        }
    }

    public function updatePublicationAction(){ //Publication d'un page

        Security::auth("pages");

        if(isset($_POST['valuePublication'])
        && isset($_POST['idPage'])
        && $_POST['idPage'] != 1
        && ($_POST['valuePublication'] == 0 || $_POST['valuePublication'] == 1)){

            $pages = new modelPages();

            $verifyId = $pages->select()->where("id = :id")->setParams(["id" => $_POST['idPage']])->get();

            $pages->populate($verifyId[0]);


            if (empty($verifyId)){
                header("Location: /admin/pages");
                exit();
            }

            $pages->setPublication($_POST['valuePublication']);
            $pages->setUserid(1);
            $pages->setId($_POST['idPage']);
            $pages->save();
        }else{
            header("Location: /admin/pages");
            exit();
        }
    }
}