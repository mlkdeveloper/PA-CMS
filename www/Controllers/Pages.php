<?php
namespace App\Controller;

use App\Core\View;


class Pages
{


    public function pagesAction(){
        $view = new View("pages.back", "back");
        $view->assign("title", "Pages");
    }
}