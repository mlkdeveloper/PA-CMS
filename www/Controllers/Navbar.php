<?php


namespace App\Controller;

use App\Core\FormValidator;
use App\Core\View;
use App\Models\Navbar as modelNavbar;
use App\Models\Category as modelCategory;
use App\Models\Pages as modelPages;


class Navbar
{


    public function displayNavbarAction(){
        $navbar = new modelNavbar();
        $dataNavbar = $navbar->select('name, status')->get();

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

            $errors = FormValidator::checkFormNavbar($form, $_POST);

            if (empty($errors)){
                $navbar->setName($_POST['name']);
                $navbar->setSort(1);

                if (isset($_POST['dropdown']) && $_POST['dropdown'] === 'dropdown'){
                    $navbar->setStatus(1);
                }else{
                    $navbar->setStatus(0);
                }

                switch ($_POST['typeNavbar']){
                    case 'page':
                        $navbar->setPage($_POST['selectType']);
                        break;
                    case 'category':
                        $navbar->setCategory($_POST['selectType']);
                        break;
                    default:
                        $view->assign("errorType", 'Le type n\'est pas correct');
                        exit();
                }

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