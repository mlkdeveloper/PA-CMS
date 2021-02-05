<?php

namespace App\Controller;

use App\Core\View;
use App\Models\Category as Categ;

class Category{

    public function showAction(){

        $category = new Categ();

        $array = $category->select();

        $view = new View("displayCategory.back", "back");
        $view->assign("title", "test");
        $view->assign("array", $array);


    }

    public function newCategoryAction(){

        $view = new View("createCategory.back", "back");
        $view->assign("title", "Admin - catégorie");

    }




}

