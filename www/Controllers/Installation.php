<?php

namespace App\Controller;

use App\Core\ConstantManager;
use App\Core\FormValidator;
use App\Core\View;
use App\Core\Security;
use App\Models\Shop as ShopModel;

session_start();


class Installation
{
    private $pdo;
    private $fileRoutes = "./routes.yml";
    private $fileConstantManager = "./Core/ConstantManager.php";

    public function installAction(){
        $view = new View("install", "install");
        $view->assign("title", "Installation");
    }

    public function startInstallAction(){ //Vérification, insertion et redirection première page d'installation

        if (!empty($_POST)){

            $dataArray = $this->checkInformations($_POST);
            $this->createFile($dataArray);

            Security::changeFile($this->fileConstantManager, 'changeConstantManager');

            $this->insertBDD($dataArray[5], $dataArray[0]);

            Security::changeFile($this->fileRoutes, 'shopInstallation');

            header('Location: /');
        }else{
            header('Location: /');
        }
    }

    private function checkInformations($data){ //Vérification des informations de la BDD, STRIPE, SMTP
        if(count($data) != 14){
            $this->errorRedirection('Formulaire non conforme');
        }else{

            $dataArray = [];

            array_push($dataArray, htmlspecialchars(trim($data['name_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['user_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['pwd_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['address_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['port_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['prefix_bdd'])));
            array_push($dataArray, htmlspecialchars(trim($data['smtp_mail'])));
            array_push($dataArray, htmlspecialchars(trim($data['smtp_password'])));
            array_push($dataArray, htmlspecialchars(trim($data['smtp_host'])));
            array_push($dataArray, htmlspecialchars(trim($data['smtp_auth'])));
            array_push($dataArray, htmlspecialchars(trim($data['smtp_port'])));
            array_push($dataArray, htmlspecialchars(trim($data['smtp_encrypt'])));
            array_push($dataArray, htmlspecialchars(trim($data['public_key'])));
            array_push($dataArray, htmlspecialchars(trim($data['private_key'])));

            $_SESSION['dataInstall'] = $dataArray;

            if (empty($dataArray[0])
                ||empty($dataArray[1])
                ||empty($dataArray[3])
                ||empty($dataArray[4])
                ||empty($dataArray[5])
                ||empty($dataArray[6])
                ||empty($dataArray[7])
                ||empty($dataArray[8])
                ||empty($dataArray[9])
                ||empty($dataArray[10])
                ||empty($dataArray[11])
                ||empty($dataArray[12])
                ||empty($dataArray[13])){

                $this->errorRedirection('Veuillez remplir tous les champs');
            }

            if(!preg_match("/^[0-9]+$/", $dataArray[4])){
                $this->errorRedirection('Le port n\'est pas valide');
            }

            if(!preg_match("/^[a-zA-z-_]{2,50}$/", $dataArray[5])){
                $this->errorRedirection('Le préfixe n\'est pas valide');
            }

            if(!preg_match("/^[a-zA-z]+$/", $dataArray[0])){
                $this->errorRedirection('Le nom de la base de données ne peut contenir ques des lettres minuscules ou majuscules');
            }

            if(!filter_var($dataArray[6], FILTER_VALIDATE_EMAIL)){
                $this->errorRedirection('L\'email du serveur SMTP n\'est pas valide');
            }

            if(!preg_match("/^[a-z]+[.][a-z]+[.][a-z]+$/", $dataArray[8])){
                $this->errorRedirection('La valeur de l\'host n\'est pas correct');
            }

            if(!preg_match("/^[0-9]+$/", $dataArray[10])){
                $this->errorRedirection('Le port SMTP n\'est pas valide');
            }

            if($dataArray[9] !== 'true' && $dataArray[9] !== 'false') {
                $this->errorRedirection('Formulaire non conforme');
            }

            if($dataArray[11] !== 'tls' && $dataArray[11] !== 'none') {
                $this->errorRedirection('Formulaire non conforme');
            }

            if($dataArray[11] === 'none'){
              $dataArray[11] = '';
            }


                return $dataArray;
        }
        return null;
    }

    private function createFile($dataArray){ //Création du fichier config.env
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


    private function verificationBDD($dbDriver, $dataArray){ //Vérification de la connexion à la BDD

        $dbDriver = explode('=', $dbDriver);


        try{
            $this->pdo = new \PDO( $dbDriver[1].":host=".$dataArray[3].";dbname=".$dataArray[0].";port=".$dataArray[4] , $dataArray[1] , $dataArray[2]);
        }catch(\Exception $e){

            $errorCode = $e->getCode();

            switch ($errorCode){
                case 1045:
                    $this->errorRedirection("Les identifiants de connexion à la base de données sont incorrects");
                    die();
                case 1049:
                    $this->errorRedirection("Il existe aucune base de données avec ce nom.<br>Créer une base de données avant de commencer l'installation");
                    die();
                case 2002:
                    $this->errorRedirection("Vérifier l'adresse de la base de données et le port");
                    die();
                default:
                    $this->errorRedirection("Une erreur s'est produite pendant la connexion à la base de données");
            }
        }
    }


    private function insertBDD($prefix, $database){ //Création des tables
        $sql = file_get_contents("clickcreate.sql");

        $installSql = str_replace("cc_", $prefix, $sql);
        $installSql = str_replace("clickCreate", $database, $installSql);

        try {
            $this->pdo->query($installSql);
        }catch(\Exception $e){
            $this->errorRedirection("Une erreur s'est produite pendant la création de la base de données");
        }
    }

    private function errorRedirection($error){ //Redirection des erreurs
        $_SESSION['securityInstall'] = $error;
        header('Location: /');
        exit();
    }

    public function shopInstallationAction(){ //Enregistrement et vérification de la page d'installation du magasin
        $shop = new ShopModel();

        $view = new View("installShop", "install");

        $formShop = $shop->formBuilderCreateShop();

        if(!empty($_POST)){

            $errors = FormValidator::check($formShop, $_POST);
            if (!is_numeric(htmlspecialchars(trim($_POST['zipCode'])))){
                array_push($errors,"Le code postale doit etre composé uniquement de chiffres");
            }

            if(empty($errors)){

                $shop->setName(htmlspecialchars(trim($_POST['nom'])));
                $shop->setAddress(htmlspecialchars(trim($_POST['address'])));
                $shop->setCity(htmlspecialchars(trim($_POST['ville'])));
                $shop->setZipCode(htmlspecialchars(trim($_POST['zipCode'])));
                $shop->setDescription(htmlspecialchars(trim($_POST['description'])));
                $shop->setPhoneNumber(htmlspecialchars(trim($_POST['telephone'])));
                $shop->save();

                Security::changeFile($this->fileRoutes, 'deleteStartInstallation');
                Security::changeFile($this->fileRoutes, 'changeRoute');

                header('Location: /');
            }else{
                $view->assign("errors", $errors);
            }
        }
        $view->assign("form", $formShop);
        $view->assign("title", "Installation");
    }
}