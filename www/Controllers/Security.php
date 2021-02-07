<?php
namespace App\Controller;
use App\Core\ConstantManager;
use App\Core\View;

session_start();

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

        $dataArray = $this->checkInformations($_POST);
        print_r($dataArray);
        new ConstantManager();

//        file_get_contents("/path/to/your/file/edit.json", true);
//        fopen('/.env', "r");
    }



    private function checkInformations($data){
        if(count($data) != 6){
            $_SESSION['securityInstall'] = 'Formulaire non conforme';
            header('Location: /');
        }else{

            if (empty($data['name_bdd'])
                ||empty($data['user_bdd'])
                ||empty($data['pwd_bdd'])
                ||empty($data['address_bdd'])
                ||empty($data['port_bdd'])
                ||empty($data['prefixe_bdd'])){

                $_SESSION['securityInstall'] = "Veuillez remplir tous les champs";
                header('Location: /');
            }

            $dataArray = [];

            $dataArray['name_bdd'] = trim($data['user_bdd']);
            $dataArray['user_bdd'] = trim($data['user_bdd']);
            $dataArray['pwd_bdd'] = trim($data['pwd_bdd']);
            $dataArray['address_bdd'] = trim($data['address_bdd']);
            $dataArray['port_bdd'] = trim($data['port_bdd']);
            $dataArray['prefixe_bdd'] = trim($data['prefixe_bdd']);

            return $dataArray;
        }
    }
}