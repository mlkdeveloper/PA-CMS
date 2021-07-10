<?php


namespace App\Controller;

use App\Core\View;
use App\Models\Navbar as modelNavbar;
use App\Models\Category as modelCategory;
use App\Models\Pages as modelPages;


class Navbar
{


    public function displayNavbarAction(){
        $navbar = new modelNavbar();
        $dataNavbar = $navbar->select()->get();

        $view = new View("navbar.back", "back");
        $view->assign("title", "Barre de navigation");
        $view->assign("dataNavbar",$dataNavbar);
    }

    public function newNavbarTabAction(){
        $navbar = new modelNavbar();

        $view = new View("newNavbarTab.back", "back");
        $view->assign("title", "Barre de navigation");

        $form = $navbar->formBuilderRegister();

        if (!empty($_POST)){

//            $errors = FormValidator::checkFormNavbar($form, $_POST);

            if (empty($errors)){
                $navbar->setName($_POST['name']);
                $navbar->setSort(1);
                $navbar->setStatus(0);
                $navbar->setPage($_POST['selectType']);
                $navbar->save();

                header('Location: /admin/barre-de-navigation');
            }else{
                $view->assign("errors", $errors);
            }
        }

    }

    public function getDataNavbarAction(){
        $type = $_POST['type'];

        switch ($type){
            case 'page':
                $page = new modelPages();
                $dataPage = $page->select('name, id')->get();
                echo json_encode($dataPage);
            break;
            case 'category':
                $category = new modelCategory();
                $dataCategory = $category->select('name, id')->get();
                echo json_encode($dataCategory);
            break;
            default:
                echo json_encode('error');
        }
    }
}