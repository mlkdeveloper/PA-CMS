<?php

namespace App\Controller;

use App\Core\View;

class Category{

    public function showAction(){

        $view = new View("displayCategory.back", "back");
        $view->assign("title", "test");

    }

}

