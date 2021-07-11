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
        $dataNavbar = $navbar->select('id,name, status')->orderBy('sort', 'ASC')->get();

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

            if (isset($_POST['dropdown']) && $_POST['dropdown'] === 'dropdown'){
                $this->dropdownNavbar($_POST);

            }else{
                $errors = FormValidator::checkFormNavbar($form, $_POST);
            }

            if (empty($errors)){
                $navbar->setName($_POST['name']);
                $navbar->setSort(1);

                if (isset($_POST['dropdown']) && $_POST['dropdown'] === 'dropdown'){
                    $navbar->setStatus(1);
                }else{
                    $navbar->setStatus(0);

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

    private function dropdownNavbar($data){
        $countTab = 1;
        $arraySelectTypeDropdown = [];
        $arrayTypeDropdown = [];
        $arrayNameDropdown = [];

        do {
            $tab = $_POST['selectTypeDropdown'.strval($countTab)];
            $tabType = $_POST['typeDropdown'.strval($countTab)];
            $tabName = $_POST['nameDropdown'.strval($countTab)];

            if (!empty($tab) && !empty($tabType) && !empty($tabName)) {
                array_push($arraySelectTypeDropdown, $tab);
                array_push($arrayTypeDropdown, $tabType);
                array_push($arrayNameDropdown, $tabName);
            }else {
                $_SESSION['errorDropDown'] = 'Veuillez remplir tous les champs';
                header('Loacation: /admin/barre-de-navigation?error=feffe');
                exit();
            }

            $countTab++;
        }while(!empty($tab));
    }

    public function upNavbarAction(){

        if (isset($_POST['id']) && !empty($_POST['id'])){

            $tab = new modelNavbar();
            $getTab = $tab->select()->where("id = :id")->setParams(['id' => $_POST['id']])->get();

            if (!empty($getTab)){

                $sort = $getTab[0]['sort'];

                if ($sort != 1){
                    $nextTab =  new modelNavbar();
                    $getNextTab = $nextTab->select()->where("sort < $sort")->orderBy('sort', 'DESC')->get();

                    $nextSort = $getNextTab[0]['sort'];

                    $tab->populate($getTab[0]);
                    $tab->setSort($nextSort);
                    $tab->save();

                    $nextTab->populate($getNextTab[0]);
                    $nextTab->setSort($sort);
                    $nextTab->save();
                }

            }else{
                http_response_code(400);
            }
        }else{
            http_response_code(400);
        }
    }

    public function downNavbarAction(){

        if (isset($_POST['id']) && !empty($_POST['id'])){

            $tab = new modelNavbar();
            $getTab = $tab->select()->where("id = :id")->setParams(['id' => $_POST['id']])->get();

            if (!empty($getTab)){

                $sort = $getTab[0]['sort'];

                $tabs = new modelNavbar();
                $getTabs = $tabs->select("max(sort) as max_sort")->get();
                if ($sort != $getTabs[0]['max_sort']){

                    $nextTab =  new modelNavbar();
                    $getNextTab = $nextTab->select()->where("sort > $sort")->orderBy('sort', 'ASC')->get();

                    $nextSort = $getNextTab[0]['sort'];

                    $tab->populate($getTab[0]);
                    $tab->setSort($nextSort);
                    $tab->save();

                    $nextTab->populate($getNextTab[0]);
                    $nextTab->setSort($sort);
                    $nextTab->save();
                    http_response_code(200);
                }

            }else{
                http_response_code(400);
            }
        }else{
            http_response_code(400);
        }
    }
}