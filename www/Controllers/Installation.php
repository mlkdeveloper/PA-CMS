<?php

namespace App\Controller;

use App\Core\ConstantManager;
use App\Core\View;

session_start();


class Installation
{
    private $pdo;

    public function installAction(){
        $view = new View("install", "install");
        $view->assign("title", "Intallation");
    }

    public function startInstallAction(){

        $dataArray = $this->checkInformations($_POST);
        $this->createFile($dataArray);
        $this->insertBDD($dataArray[5], $dataArray[0]);

        //Redirection
    }

    private function checkInformations($data){
        if(count($data) != 6){
            $this->errorRedirection("Formulaire non conforme");
        }else{

            $dataArray = [];

            array_push($dataArray, htmlspecialchars(trim($data['name_bdd'])));
            array_push( $dataArray, htmlspecialchars(trim($data['user_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['pwd_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['address_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['port_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['prefix_bdd'])));

            $_SESSION['dataInstall'] = $dataArray;

            if (empty($dataArray[0])
                ||empty($dataArray[1])
                ||empty($dataArray[2])
                ||empty($dataArray[3])
                ||empty($dataArray[4])
                ||empty($dataArray[5])){

                $this->errorRedirection("Veuillez remplir tous les champs");
            }

            if(!preg_match("/^[0-9]*$/", $dataArray[4])){
                $this->errorRedirection("Le port n'est pas valide");
            }

            return $dataArray;
        }
        return null;
    }

    private function createFile($dataArray){
        $dbDriver = file_get_contents("config-sample.env", true, null, 0,14);
        $configFile = file_get_contents("config-sample.env", true, null, 14);

        $configFileExploded = explode('=', $configFile);

        $newDB = $dbDriver;
        for ($i = 0; $i < count($dataArray); $i++){
            $newDB .= $configFileExploded[$i].'='.$dataArray[$i];
        }

        $this->verificationBDD($dbDriver, $dataArray);

        if(!file_exists('config-sample.env')){
            $this->errorRedirection("Le fichier config-sample.env n'existe pas");
        }

        file_put_contents('config.env', $newDB);

        new ConstantManager();
    }


    private function verificationBDD($dbDriver, $dataArray){

        $dbDriver = explode('=', $dbDriver);

        try{
            $this->pdo = new \PDO( $dbDriver[1].":host=".$dataArray[3].";dbnamehost=".$dataArray[0].";port=".$dataArray[4] , $dataArray[1] , $dataArray[2]);
        }catch(\Exception $e){

            $errorCode = $e->getCode();

            switch ($errorCode){
                case 1045:
                    $this->errorRedirection("Les identifiants de connexion à la base de données sont incorrects");
                    die();
                case 2002:
                    $this->errorRedirection("L'adresse de la base de données ou le port est incorrecte");
                    die();
                default:
                    $this->errorRedirection("Une erreur s'est produite pendant la connexion à la base de données");
            }
        }
    }


    private function insertBDD($prefix, $database){
        $sql = file_get_contents("clickcreate.sql");

        $installSql = str_replace("cc_", $prefix, $sql);
        $installSql = str_replace("clickCreate", $database, $installSql);

        try {
            $this->pdo->query($installSql);
        }catch(\Exception $e){
            $this->errorRedirection("Une erreur s'est produit pendant la création de la base de données");
        }
    }

    private function errorRedirection($error){
        $_SESSION['securityInstall'] = $error;
        header('Location: /');
        die();
    }

}