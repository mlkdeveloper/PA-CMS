<?php


namespace App\Controller;

use App\Core\View;


class Dashboard
{


    public function dashboardAction(){
        $view = new View("dashboard.back", "back");
        $view->assign("title", "Dashboard");
    }
}