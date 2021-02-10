<?php

namespace App\Controller;

use App\Core\View;
use App\Models\Category as modelCategory;

class Category{

    public function showAction(){

        $category = new modelCategory();
        $array = $category->select()->get();


        $view = new View("displayCategory.back", "back");
        $view->assign("title", "Liste des catégories");
        $view->assign("array", $array);


    }

    public function newCategoryAction(){

        $view = new View("createCategory.back", "back");
        $view->assign("title", "Admin - catégorie");

    }




}

