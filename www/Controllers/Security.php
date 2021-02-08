<?php
namespace App\Controller;
use App\Core\ConstantManager;
use App\Core\View;

session_start();

class Security
{
    private $pdo;

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


            array_push($dataArray, htmlspecialchars(trim($data['name_bdd'])));
            array_push( $dataArray, htmlspecialchars(trim($data['user_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['pwd_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['address_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['port_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['prefixe_bdd'])));

            $_SESSION['dataInstall'] = $dataArray;

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

        $this->verificationBDD($dbDriver, $dataArray);

        if(!file_exists('config-sample.env')){
            $_SESSION['securityInstall'] = "Le fichier config-sample.env n'existe pas";
            header('Location: /');
            die();
        }


        file_put_contents('config.env', $newDB);

        //Insertion bdd

        new ConstantManager();


        //Redirection

    }


    private function verificationBDD($dbDriver, $dataArray){

//        echo $dbDriver;
//        print_r($dataArray);

        $dbDriver = explode('=', $dbDriver);

        try{
            $this->pdo = new \PDO( $dbDriver[1].":host=".$dataArray[3].";dbnamehost=".$dataArray[0].";port=".$dataArray[4] , $dataArray[1] , $dataArray[2]);
        }catch(\Exception $e){

            $erroCode = $e->getCode();

            switch ($erroCode){
                case 1045:
                    $_SESSION['securityInstall'] = "Les identifiants de connexion à la base de données sont incorrects";
                    header('Location: /');
                    die();
                case 2002:
                    $_SESSION['securityInstall'] = "L'adresse de la base de données est incorrecte";
                    header('Location: /');
                    die();
            }
        }
    }
}