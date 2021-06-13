<?php


namespace App\Controller;

use App\Core\View;


class Settings
{


    public function displaySettingsAction(){
        $view = new View("settings.back", "back");
        $view->assign("title", "Paramètres");
    }
}