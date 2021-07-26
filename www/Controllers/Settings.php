<?php


namespace App\Controller;

use App\Core\Uploader;
use App\Core\View;
use App\Models\Themes;
use App\Models\User;

use App\Core\Security;

session_start();

class Settings
{

    public function displaySettingsAction(){

        Security::auth("settingsCms");
        $view = new View("settings.back", "back");
        $view->assign("title", "Paramètres");

        $admin = new User();
        $emailAdmin = $admin->select("email")->where("id = :id")->setParams(["id" => 1])->get();
        foreach ($emailAdmin[0] as $email):
            $view->assign("email", $email);
        endforeach;
    }

    public function updateAction()
    {

        Security::auth("settingsCms");
        if (!empty($_POST)) {

            $dataArray = $this->checkInformations($_POST);
            $this->updateFile($dataArray);

            $this->errorRedirection('Modification réussie', 'success');
        } else {
            header('Location: /admin/parametres');
        }
    }

    private function checkInformations($data){
        if(count($data) != 8){
            $this->errorRedirection('Formulaire non conforme', 'error');
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

            $_SESSION['dataSettings'] = $dataArray;

            if (empty($dataArray[0])
                ||empty($dataArray[1])
                ||empty($dataArray[3])
                ||empty($dataArray[4])
                ||empty($dataArray[5])
                ||empty($dataArray[6])
                ||empty($dataArray[7])) {

                $this->errorRedirection('Veuillez remplir tous les champs', 'error');
            }


            if(!filter_var($dataArray[0], FILTER_VALIDATE_EMAIL)){
                $this->errorRedirection('L\'email du serveur SMTP n\'est pas valide', 'error');
            }

            if(!preg_match("/^[a-z]+[.][a-z]+[.][a-z]+$/", $dataArray[2])){
                $this->errorRedirection('La valeur de l\'host n\'est pas correct', 'error');
            }

            if(!preg_match("/^[0-9]+$/", $dataArray[4])){
                $this->errorRedirection('Le port SMTP n\'est pas valide', 'error');
            }

            if($dataArray[3] !== 'true' && $dataArray[3] !== 'false') {
                $this->errorRedirection('Formulaire non conforme', 'error');
            }

            if($dataArray[5] !== 'tls' && $dataArray[5] !== 'none') {
                $this->errorRedirection('Formulaire non conforme', 'error');
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

    private function errorRedirection($msg, $type){
        if ($type === 'error'){
            $_SESSION['errorSettings'] = $msg;
        }else{
            $_SESSION['successSettings'] = $msg;
        }
        header('Location: /admin/parametres');
        exit();
    }

    public function updateAdminEmailAction(){

        Security::auth("settingsCms");
        if (!empty($_POST)) {
            $admin = new User();

            if (count($_POST) != 1) {
                $this->errorRedirection('Formulaire non conforme', 'error');
            } else {

                $mailAdmin = htmlspecialchars(trim($_POST['admin_mail']));

                if (empty($mailAdmin) ||
                    !filter_var($mailAdmin, FILTER_VALIDATE_EMAIL)) {
                    $this->errorRedirection('Veuillez remplir tous les champs', 'error');
                }

                $checkMail = $admin->select()->where("email = :email")->setParams(["email" => $mailAdmin])->get();

                if ($checkMail) {
                    $this->errorRedirection('Ce mail est déjà utilisé', 'error');
                }

                $dataAdmin = $admin->select()->where("id = :id")->setParams(["id" => 1])->get();

                $admin->populate($dataAdmin[0]);
                $admin->setEmail($mailAdmin);
                $admin->save();
                $this->errorRedirection('Modification réussie', 'success');
            }
        }else{
            header('Location: /admin/parametres');
        }
    }

    public function updateAdminPasswordAction(){

        Security::auth("settingsCms");

        if (!empty($_POST)) {
            $admin = new User();

            if (count($_POST) != 3) {
                $this->errorRedirection('Formulaire non conforme', 'error');
            } else {

                $oldPwd = htmlspecialchars($_POST['old_pwd']);
                $newPwd = htmlspecialchars($_POST['new_pwd']);
                $newPwdConfirm = htmlspecialchars($_POST['new_pwd_confirm']);

                if (empty($oldPwd) ||
                    empty($newPwd) ||
                    empty($newPwdConfirm)) {
                    $this->errorRedirection('Veuillez remplir tous les champs', 'error');
                }

                $dataAdmin = $admin->select()->where("id = :id")->setParams(["id" => 1])->get();

                if (!password_verify($oldPwd, $dataAdmin[0]['pwd'])) {
                    $this->errorRedirection('Le mot de passe est incorrect', 'error');
                }

                if( !preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]){8,}/",$newPwd)){
                    $this->errorRedirection('Votre mot de passe doit faire au minimum 8 caractères, contenir une majuscule et un chiffre.', 'error');
                }

                if ($newPwd !== $newPwdConfirm) {
                    $this->errorRedirection('Les deux mots de passe sont différents', 'error');
                }

                $pwdHash = password_hash($newPwd, PASSWORD_BCRYPT);

                $admin->populate($dataAdmin[0]);
                $admin->setPwd($pwdHash);
                $admin->save();
                $this->errorRedirection('Modification réussie', 'success');
            }
        }else{
            header('Location: /admin/parametres');
        }
    }

    public function displaySettingsSiteAction(){

        Security::auth("settingsSite");

        $view = new View("settingsSite.back", "back");
        $view->assign("title","Paramètres du site");

        if (isset($_FILES['logo']) && !empty($_FILES['logo'])){

            $upload = new Uploader($_FILES['logo'],true);
            $res = $upload->setName("logo")->setSize(10)->setDirectory("./images/logo")->upload();
            ($res) ? $view->assign("success","Logo modifié !") : $view->assign("errors",$upload->errorsFile());
        }

        $file = scandir("./images/logo/",1);

        $theme = new Themes();
        $themes = $theme->select()->get();

        $view->assign("logo",$file[0]);
        $view->assign("themes",$themes);

    }

}