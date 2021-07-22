<?php
namespace App\Controller;
use App\Core\Email;
use App\Core\FormValidator;
use App\Models\User as UserModel;
use App\Core\Security as SecurityCore;
use App\Core\View;
use PHPMailer\PHPMailer\PHPMailer;

class Security
{
    private $pdo;


    //Method : Action
    public function registerInstallAction(){

        $user = new UserModel();

        //Affiche la vue home intégrée dans le template du front
        $view = new View("installRegister.install", "install");
        $view->assign("title", "Intallation");

        $formInstallRegister = $user->formBuilderInstallRegister();


        if(!empty($_POST)){

            $lastname = htmlspecialchars(trim($_POST["lastname"]));
            $firstname = htmlspecialchars(trim($_POST["firstname"]));
            $email = htmlspecialchars(trim($_POST["email"]));
            $pwd = htmlspecialchars(trim($_POST["pwd"]));
            $pwdConfirm = htmlspecialchars(trim($_POST['pwdConfirm']));

            $emailVerif = $user->select('email')->where("email=:email")->setParams(["email" => $email])->get();

            $errors = [];
            if ($emailVerif){
                array_push($errors, "L'email est deja connu de notre base de données");
                $view->assign("errors", $errors);
            }

            if(empty($errors)) {

                if ($pwd == $pwdConfirm) {

                    //Generate a random string.
                    $token = openssl_random_pseudo_bytes(32);
                    //Convert the binary data into hexadecimal representation.
                    $token = bin2hex($token);

                    $pwdHash = password_hash($pwd, PASSWORD_BCRYPT);

                    $user->setLastname($lastname);
                    $user->setFirstname($firstname);
                    $user->setEmail($email);
                    $user->setPwd($pwdHash);
                    $user->setStatus(1);
                    $user->setIdRole(1);
                    $user->setToken($token);

                    $user->save();

                    $this->insertInstallation();

                    SecurityCore::changeFile('./routes.yml', 'finalChangeRoute');
                    SecurityCore::changeFile('./index.php', 'removeRedirection');


                    header('Location: /');
                }else{
                    array_push($errors, "Le mot de passe de confirmation ne correspond pas");
                    $view->assign("errors", $errors);
                }
            }else{
                $view->assign("errors", $errors);
            }
        }
        $view->assign("form", $formInstallRegister);

    }

    private function insertInstallation(){
        try{
            $this->pdo = new \PDO(DBDRIVER . ":host=" . DBHOST . ";dbname=" . DBNAME . ";port=" . DBPORT, DBUSER, DBPWD);

            $sqlInsert = file_get_contents("insert-clickcreate.sql");
            $installSqlInsert = str_replace("cc_", DBPREFIXE, $sqlInsert);

            $this->pdo->query($installSqlInsert);
        }catch(\Exception $e){
            $_SESSION['securityInstall'] = "Une erreur s'est produite pendant l'installation";
            header('Location: /');
            exit();
        }
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

                Email::sendEmail("C&C - Recuperation du mot de passe",$email, "Récupération du mot de passe","http://".$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT']."/recuperation-mot-de-passe?tkn=".$user[0]["token"], "Je modifie mon mot de passe", "http://".$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT']."/connexion");

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
    if (empty($_GET['tkn'])){
        header('location:/connexion');
    }

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