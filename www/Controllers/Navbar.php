<?php


namespace App\Controller;

use App\Core\View;
use App\Models\Navbar as modelNavbar;
use App\Models\Category as modelCategory;
use App\Models\Page as modelPage;


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
        $view = new View("newNavbarTab.back", "back");
        $view->assign("title", "Barre de navigation");
    }

    public function getDataNavbarAction(){
        $type = $_POST['type'];

        file_put_contents('test.txt2', print_r($type, true));

        switch ($type){
            case 'page':
                $page = new modelPage();
                $dataPage = $page->select('name')->get();
                echo json_encode($dataPage);
            break;
            case 'category':
                $category = new modelCategory();
                $dataCategory = $category->select('name')->get();
                echo json_encode($dataCategory);
            break;
            default:
                echo json_encode('erreur');
        }
    }
}