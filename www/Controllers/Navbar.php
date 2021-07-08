<?php


namespace App\Controller;

use App\Core\View;
use App\Models\Navbar as modelNavbar;


class Navbar
{


    public function displayNavbarAction(){
        $navbar = new modelNavbar();
        $dataNavbar = $navbar->select()->get();
        
        $view = new View("navbar.back", "back");
        $view->assign("title", "Barre de navigation");
        $view->assign("dataNavbar",$dataNavbar);
    }
}