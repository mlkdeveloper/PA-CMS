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
        }else{

            if (empty($data['name_bdd'])
                ||empty($data['user_bdd'])
                ||empty($data['pwd_bdd'])
                ||empty($data['address_bdd'])
                ||empty($data['port_bdd'])
                ||empty($data['prefix_bdd'])){

                $_SESSION['securityInstall'] = "Veuillez remplir tous les champs";
                header('Location: /');
            }

            $dataArray = [];


            array_push($dataArray, htmlspecialchars(trim($data['name_bdd'])));
            array_push( $dataArray, htmlspecialchars(trim($data['user_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['pwd_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['address_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['port_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['prefix_bdd'])));

            $_SESSION['dataInstall'] = $dataArray;

            return $dataArray;
        }
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
            $_SESSION['securityInstall'] = "Le fichier config-sample.env n'existe pas";
            header('Location: /');
        }

        file_put_contents('config.env', $newDB);

        new ConstantManager();

        //Insertion bdd
        $this->insertBDD($dataArray[5], $dataArray[0]);

        //Redirection

    }


    private function verificationBDD($dbDriver, $dataArray){

        $dbDriver = explode('=', $dbDriver);

        try{
            $this->pdo = new \PDO( $dbDriver[1].":host=".$dataArray[3].";dbnamehost=".$dataArray[0].";port=".$dataArray[4] , $dataArray[1] , $dataArray[2]);
        }catch(\Exception $e){

            $errorCode = $e->getCode();

            switch ($errorCode){
                case 1045:
                    $_SESSION['securityInstall'] = "Les identifiants de connexion à la base de données sont incorrects";
                    header('Location: /');
                    break;
                case 2002:
                    $_SESSION['securityInstall'] = "L'adresse de la base de données est incorrecte";
                    header('Location: /');
                    break;
                default:
                    $_SESSION['securityInstall'] = "Une erreur s'est produite pendant la connexion à la base de données";
                    header('Location: /');
            }
        }

        $verificationDatabase = $this->pdo->prepare('SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?');
        $verificationDatabase->execute(array($dataArray[0]));
        if ($verificationDatabase->fetchColumn() == 0) {
            $_SESSION['securityInstall'] = "La base de données renseignée n'existe pas";
            header('Location: /');
        }
    }


    private function insertBDD($prefix, $database){
        $sql = file_get_contents("clickcreate.sql");

        $installSql = str_replace("cc_", $prefix, $sql);
        $installSql = str_replace("clickCreate", $database, $installSql);

        echo $installSql;
        file_put_contents("test.sql", $installSql);
    }
}