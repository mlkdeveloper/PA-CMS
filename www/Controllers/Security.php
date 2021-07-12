<?php


namespace App\Controller;
use App\Core\Email;
use App\Core\FormValidator;
use App\Models\User as UserModel;


use App\Core\View;
use PHPMailer\PHPMailer\PHPMailer;

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

    public function startInstall(){


    }
    public function logoutAction(){
        session_start();
        unset($_SESSION['user']);
        session_destroy();
        header('location:/');
        exit();
    }

    public function pwdPerduAction(){

        $view = new View("mdpOublie");
        $view->assign("title", "test php Mailer");
        $user = new UserModel();

        $form = $user->formBuilderpwdOublie();
        $view->assign("form", $form);

        $errors = [];

        if (!empty($_POST)){
            $email = $_POST['email'];

            if(!$user->select('email', 'token')->where('email=:email')->setParams(["email" => htmlspecialchars($_POST['email'])])->get()){
                array_push($errors, "L'email n'est pas connu de notre base de données, vous pouvez créer un nouveau compte");
            }
            $user = $user->select('email', 'token')->where('email=:email')->setParams(["email" => htmlspecialchars($_POST['email'])])->get();

            if (empty($errors)) {

                Email::sendEmail($email, "Récupération du mot de passe","http://localhost:8080/recuperation-mot-de-passe?tkn=".$user[0]["token"], "Je modifie mon mot de passe", "http://localhost:8080/connexion");

            }else{
                $view->assign("errors", $errors);
            }

        }

    }
    public function confirmedRegisterAction(){
        $view = new View("confirmationInscription");
        $view->assign("title", "C&C - Confirmation du compte");
        $user = new UserModel();


        if (empty($user->select("*")->where('token= :token')->setParams(["token"=>$_GET['tkn']])->get())){
            header("location:/");
        }

        $users = new UserModel();
        $user = $user->select("*")->where('token= :token')->setParams(["token"=>$_GET['tkn']])->get();

        $users->populate($user[0]);
        $users->setIdRole($user[0]['id_role']);
        $users->setIsConfirmed(1);

        // Création du nv token
        
        $users->save();
    }

    public function recuperationpwdAction(){
        $view = new View("recuperationPwd");
        $view->assign("title", "C&C - Modification du mot de passe");

        $user = new UserModel();

        $form = $user->formBuildermodifyPwd();
        $view->assign("form", $form);

        //$errors = FormValidator::check($form, $_POST);
    $errors = [];

        if (!empty($_POST)){

            $pwd = htmlspecialchars($_POST['pwd']);
            $pwdConfirm = htmlspecialchars(($_POST['pwdConfirm']));
            $token = htmlspecialchars($_GET['tkn']);


            if ($pwd != $pwdConfirm){
                array_push($errors, 'Les mot de passe ne correspondent pas');
            }
            if (!$user->select('id')->where('token=:token')->setParams(['token' => $token])->get()){
                array_push($errors, "ALERTE : modification du token dans le GET");
            }


            if (empty($errors)){

                $userSelect = $user->select('*')->where('token=:token')->setParams(['token' => $token])->get();

                //Generate a random string.
                $newToken = openssl_random_pseudo_bytes(32);
                //Convert the binary data into hexadecimal representation.
                $newToken = bin2hex($newToken);

                $user->populate($userSelect[0]);
                $user->setId($userSelect[0]['id']);
                $pwdHash = password_hash($pwd, PASSWORD_BCRYPT);
                $user->setPwd($pwdHash);
                $user->setToken($newToken);
                $user->save();
                echo '<pre>';

                header('location:/connexion');

            }else{
                $view->assign("errors", $errors);
            }
        }

    }
}