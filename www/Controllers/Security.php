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
        $this->createFile($dataArray);

    }



    private function checkInformations($data){
        if(count($data) != 6){
            $_SESSION['securityInstall'] = 'Formulaire non conforme';
            header('Location: /');
            die();
        }else{

            if (empty($data['name_bdd'])
                ||empty($data['user_bdd'])
                ||empty($data['pwd_bdd'])
                ||empty($data['address_bdd'])
                ||empty($data['port_bdd'])
                ||empty($data['prefixe_bdd'])){

                $_SESSION['securityInstall'] = "Veuillez remplir tous les champs";
                header('Location: /');
                die();
            }

            $dataArray = [];


            array_push($dataArray, trim($data['name_bdd']));
            array_push( $dataArray, trim($data['user_bdd']));
            array_push($dataArray, trim($data['pwd_bdd']));
            array_push($dataArray, trim($data['address_bdd']));
            array_push($dataArray, trim($data['port_bdd']));
            array_push($dataArray, trim($data['prefixe_bdd']));

            return $dataArray;
        }
    }


    private function createFile($dataArray){
        $dbDriver = file_get_contents("config-sample.env", true, null, 0,14);
        $configFile = file_get_contents("config-sample.env", true, null, 14);

        $configFileExploded = explode('=', $configFile);

        $newDB='';
        $newDB .= $dbDriver;
        for ($i = 0; $i < count($dataArray); $i++){
            $newDB .= $configFileExploded[$i].'='.$dataArray[$i];
        }

        file_put_contents('config.env', $newDB);
    }
}