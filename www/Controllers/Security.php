<?php


namespace App\Controller;


use App\Core\View;

class Security
{
    //Method : Action
    public function registerInstallAction(){


        //Affiche la vue home intégrée dans le template du front
        $view = new View("installRegister", "install");




    }

    public function installAction(){
        $view = new View("install", "install");
        $view->assign("title", "Intallation");
    }

    public function startInstallAction(){

//        file_get_contents('/test/fzef/azeqfzeenv', false);
//        file_get_contents("/path/to/your/file/edit.json", true);
        fopen('/.env', "r");
    }
}