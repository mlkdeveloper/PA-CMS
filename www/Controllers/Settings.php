<?php


namespace App\Controller;

use App\Core\View;
use App\Models\User;


class Settings
{


    public function displaySettingsAction(){
        $view = new View("settings.back", "back");
        $view->assign("title", "Paramètres");

        $users = new User();
        $emailAdmin = $users->select("email")->where("id = :id")->setParams(["id" => 1])->get();
        $view->assign("email", $emailAdmin);
    }

    public function updateAction()
    {
        if (!empty($_POST)) {

            $dataArray = $this->checkInformations($_POST);
            $this->updateFile($dataArray);

            header('Location: /admin/parametres');
        } else {
            header('Location: /admin/parametres');
        }
    }

    private function checkInformations($data){
        if(count($data) != 8){
            $this->errorRedirection('Formulaire non conforme');
        }else{

            $dataArray = [];

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
                ||empty($dataArray[7])) {

                $this->errorRedirection('Veuillez remplir tous les champs');
            }


            if(!filter_var($dataArray[0], FILTER_VALIDATE_EMAIL)){
                $this->errorRedirection('L\'email du serveur SMTP n\'est pas valide');
            }

            if(!preg_match("/^[a-z]+[.][a-z]+[.][a-z]+$/", $dataArray[2])){
                $this->errorRedirection('La valeur de l\'host n\'est pas correct');
            }

            if(!preg_match("/^[0-9]+$/", $dataArray[4])){
                $this->errorRedirection('Le port SMTP n\'est pas valide');
            }

            if($dataArray[3] !== 'true' && $dataArray[3] !== 'false') {
                $this->errorRedirection('Formulaire non conforme');
            }

            if($dataArray[5] !== 'tls' && $dataArray[5] !== 'none') {
                $this->errorRedirection('Formulaire non conforme');
            }

            if($dataArray[5] === 'none'){
                $dataArray[5] = '';
            }


            return $dataArray;
        }
        return null;
    }

    private function updateFile($dataArray){
        $file = "config.env";

        $ptr = fopen($file, "r");
        $contenu = fread($ptr, filesize($file));

        fclose($ptr);
        $contenu = explode(PHP_EOL, $contenu);

        $contenu = $this->searchDataFile($contenu, 'SMTPMAIL', $dataArray[0]);
        $contenu = $this->searchDataFile($contenu, 'SMTPPWD', $dataArray[1]);
        $contenu = $this->searchDataFile($contenu, 'SMTPHOST', $dataArray[2]);
        $contenu = $this->searchDataFile($contenu, 'SMTPAUTH', $dataArray[3]);
        $contenu = $this->searchDataFile($contenu, 'SMTPPORT', $dataArray[4]);
        $contenu = $this->searchDataFile($contenu, 'SMTPENCRYPT', $dataArray[5]);
        $contenu = $this->searchDataFile($contenu, 'PUBLICKEYSTRIPE', $dataArray[6]);
        $contenu = $this->searchDataFile($contenu, 'PRIVATEKEYSTRIPE', $dataArray[7]);

        $contenu = array_values($contenu);

        $contenu = implode(PHP_EOL, $contenu);

        $ptr = fopen($file, "w");
        fwrite($ptr, $contenu);
        fclose($ptr);
    }

    private function searchDataFile($newContenu, $superVar, $data){

        $line = false;

        foreach ($newContenu as $index => $value) {
            if (strpos($value, $superVar) !== false) {
                $line = $index;
                break;
            }
        }
        $newContenu[$line] = $superVar."=".$data;

        return $newContenu;
    }

    private function errorRedirection($error){
        $_SESSION['securityInstall'] = $error;
        header('Location: /admin/parametres');
        exit();
    }

    public function updateAdminAction(){

        $users = new User();
        $pwdAdmin = $users->select("pwd")->where("id = :id")->setParams(["id" => 1])->get();

        print_r($pwdAdmin);
    }
}