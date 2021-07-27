<?php


namespace App\Controller;

use App\Core\FormValidator;
use App\Core\View;
use App\Models\Navbar as modelNavbar;
use App\Models\Tab_navbar as modelTab_navbar;
use App\Models\Category as modelCategory;
use App\Models\Pages as modelPages;

use App\Core\Security;

session_start();


class Navbar
{


    public function displayNavbarAction(){ //Affichage des onglets principaux

        Security::auth("settingsSite");

        $navbar = new modelNavbar();
        $dataNavbar = $navbar->select('id,name, status')->orderBy('sort', 'ASC')->get();

        $view = new View("navbar.back", "back");
        $view->assign("title", "Barre de navigation");
        $view->assign("dataNavbar",$dataNavbar);
    }

    public function newNavbarTabAction(){ //Création d'un onglet

        Security::auth("settingsSite");


        $navbar = new modelNavbar();
        $tabNavbar = new modelTab_navbar();
        $sortMax = $navbar->select('MAX(sort)')->get();

        $newSort = 0;
        $newId = 0;

        foreach ($sortMax[0] as $value):
            $newSort = $value;
        endforeach;

        $newSort++;

        $view = new View("newNavbarTab.back", "back");
        $view->assign("title", "Barre de navigation");

        if (!empty($_POST)){

            if (isset($_POST['dropdown']) && $_POST['dropdown'] === 'dropdown'){
                $form = $tabNavbar->formBuilderRegister();
                $countInputs = $this->dropdownNavbar($_POST);
                $errors = FormValidator::checkFormTabNavbar($form, $_POST, $countInputs);
            }else{
                $form = $navbar->formBuilderRegister();
                $errors = FormValidator::checkFormNavbar($form, $_POST);
            }

            if (empty($errors)){
                $navbar->setName(htmlspecialchars(trim($_POST['name'])));
                $navbar->setSort($newSort);

                if (isset($_POST['dropdown']) && $_POST['dropdown'] === 'dropdown'){
                    $navbar->setStatus(1);
                    $navbar->save();

                    $idMax = $navbar->select('MAX(id)')->get();

                    foreach ($idMax[0] as $value):
                        $newId = $value;
                    endforeach;

                    for ($i = 1; $i <= $countInputs; $i++){
                        $tabNavbar = new modelTab_navbar();

                        $tabNavbar->setName(htmlspecialchars(trim($_POST['nameDropdown'.$i])));
                        $tabNavbar->setNavbar($newId);

                        switch ($_POST['typeDropdown'.$i]){
                            case 'page':
                                $tabNavbar->setPage($_POST['selectTypeDropdown'.$i]);
                                break;
                            case 'category':
                                $tabNavbar->setCategory($_POST['selectTypeDropdown'.$i]);
                                break;
                        }
                        $tabNavbar->save();
                    }
                }else{
                    $navbar->setStatus(0);

                    switch ($_POST['typeNavbar']){
                        case 'page':
                            $navbar->setPage($_POST['selectType']);
                            break;
                        case 'category':
                            $navbar->setCategory($_POST['selectType']);
                            break;
                    }
                    $navbar->save();
                }


                header('Location: /admin/barre-de-navigation');
            }else{
                $view->assign("errors", $errors);
            }
        }

    }

    public function getDataNavbarAction(){ //Récupération de la liste des pages et des catégories

        Security::auth("settingsSite");

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

    private function dropdownNavbar($data){ //Vérification du dropdown

        Security::auth("settingsSite");

        $countSelectTypeDropdown = 0;
        $countTypeDropdown = 0;
        $countNameDropdown = 0;

        foreach ($data as $key => $value){
            if (preg_match('/^nameDropdown.*$/', $key)){
                $countNameDropdown++;
            }

            if (empty($value)){
                $_SESSION['errorDropDown'] = 'Veuillez remplir tous les champs des onglets de la liste déroulante';
                header('Location: /admin/nouveau-onglet-navigation');
                exit();
            }

            if (preg_match('/^typeDropdown.*$/', $key)){
                $countTypeDropdown++;
            }

            if (preg_match('/^selectTypeDropdown.*$/', $key)){
                $countSelectTypeDropdown++;
            }
        }

        if ($countNameDropdown !== $countTypeDropdown || $countNameDropdown !== $countSelectTypeDropdown){
            $_SESSION['errorDropDown'] = 'Veuillez remplir tous les champs des onglets de la liste déroulante';
            header('Location: /admin/nouveau-onglet-navigation');
            exit();
        }
        return $countTypeDropdown;
    }

    public function upNavbarAction(){ //Déplacement vers le haut de l'onglet

        Security::auth("settingsSite");

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
                    http_response_code(201);
                }else{
                    http_response_code(200);
                }

            }else{
                http_response_code(400);
            }
        }else{
            http_response_code(400);
        }
    }

    public function downNavbarAction(){ //Déplacement vers le bas de l'onglet

        Security::auth("settingsSite");

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

    public function deleteTabAction(){ //Suppression de l'onglet

        Security::auth("settingsSite");

        if (isset($_GET['id']) && isset($_GET['status'])){
            $idTab = htmlspecialchars($_GET['id']);
            $statusTab = htmlspecialchars($_GET['status']);

            $trueStatus = 2;

            $navbar = new modelNavbar();
            $result = $navbar->select('status')->where('id = :id')->setParams(['id' => $idTab])->get();

            foreach ($result[0] as $value):
                $trueStatus = $value;
            endforeach;

            if (!empty($result) && $trueStatus < 2 && $trueStatus === $statusTab){
                if ($trueStatus == 1){
                    $tabNavbar = new modelTab_navbar();
                    $tabNavbar->where('navbar = :navbar')->setParams(['navbar' => $idTab])->delete();
                }

                $navbar->where('id = :id')->setParams(['id' => $idTab])->delete();
                header('Location: /admin/barre-de-navigation');
            }else{
                $_SESSION['errorDeleteTab'] = 'Des informations sont manquantes';
                header('Location: /admin/barre-de-navigation');
            }
        }else {
            $_SESSION['errorDeleteTab'] = 'Des informations sont manquantes';
            header('Location: /admin/barre-de-navigation');
        }
    }
}