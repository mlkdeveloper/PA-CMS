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

            if(empty($errors)){
                $pages->setName($_POST['title']);
                $pages->setSlug($_POST['slug']);
                $pages->setUserid(2);
                $pages->save();

                header('location:/admin/display-pages');
            }else{
                $view->assign("errors", $errors);
            }
        }

    }
}