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
    /*
     * Enregistrement de l'administrateur lors de l'instalation
     */
    public function registerInstallAction(){

        $user = new UserModel();

        //Affiche la vue home intégrée dans le template du front
        $view = new View("installRegister.install", "install");
        $view->assign("title", "Intallation");

        $formInstallRegister = $user->formBuilderInstallRegister();


        if(!empty($_POST)){

            $errors = FormValidator::checkClient($formInstallRegister, $_POST,false);


            if(empty($errors)) {

                    $user->populate($_POST);
                    $token = openssl_random_pseudo_bytes(32);
                    $token = bin2hex($token);
                    $pwdHash = password_hash($_POST['pwd'], PASSWORD_BCRYPT);
                    $user->setPwd($pwdHash);
                    $user->setStatus(1);
                    $user->setIdRole(1);
                    $user->setToken($token);
                    $user->setIsConfirmed(1);

                    $user->save();

                    $this->insertInstallation();

                    SecurityCore::changeFile('./routes.yml', 'finalChangeRoute');//Suppression de la partie installation
                    SecurityCore::changeFile('./index.php', 'removeRedirection');
                    SecurityCore::changeFile('./sitemap.php', 'removeRedirectionSitemap');

                    header('Location: /');
            }else{
                $view->assign("errors", $errors);
            }
        }
        $view->assign("form", $formInstallRegister);

    }

    private function insertInstallation(){ //Insertion des données dans les tables
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

    /*
     * Méthode de déconnexion
     */
    public function logoutAction(){
        session_start();
        unset($_SESSION['user']);
        session_destroy();
        header('location:/');
        exit();
    }

    /*
     * Récupération de mot de passe
     * Envoie de mail
     */
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

                Email::sendEmail("C&C - Récupération du mot de passe",$email, utf8_decode('Récupération du mot de passe'),"http://".$_SERVER['SERVER_NAME']."/recuperation-mot-de-passe?tkn=".$user[0]["token"], "Je modifie mon mot de passe", "http://".$_SERVER['SERVER_NAME']."/connexion");

            }else{
                $view->assign("errors", $errors);
            }

        }

    }
    /*
     * Envoie d'un mail de confirmation du compte
     */
    public function confirmedRegisterAction(){
        $view = new View("confirmationInscription");
        $view->assign("title", "C&C - Confirmation du compte");
        $user = new UserModel();


        if (empty($user->select("*")->where('token= :token')->setParams(["token"=>$_GET['tkn']])->get())){
            header("location:/");
            exit();
        }

        $users = new UserModel();
        $user = $user->select("*")->where('token= :token')->setParams(["token"=>$_GET['tkn']])->get();

        $users->populate($user[0]);
        $users->setIdRole($user[0]['id_role']);
        $users->setIsConfirmed(1);

        $users->save();
    }

    /*
     * Récupération du mot de passe
     */
    public function recuperationpwdAction(){
        $view = new View("recuperationPwd");
        $view->assign("title", "C&C - Modification du mot de passe");

        if (empty($_GET['tkn'])){
            header('location:/connexion');
            exit();
        }

        $user = new UserModel();

        $form = $user->formBuildermodifyPwd();
        $view->assign("form", $form);

        if (!empty($_POST)){

            $errors = FormValidator::checkClient($form, $_POST,false);
            $token = htmlspecialchars($_GET['tkn']);

            if (!$user->select('id')->where('token=:token')->setParams(['token' => $token])->get()){
                array_push($errors, "ALERTE : modification du token dans le GET");
            }

            if (empty($errors)){

                $userSelect = $user->select('*')->where('token=:token')->setParams(['token' => $token])->get();

                $newToken = openssl_random_pseudo_bytes(32);
                $newToken = bin2hex($newToken);

                $user->populate($userSelect[0]);
                $user->setId($userSelect[0]['id']);
                $pwdHash = password_hash($_POST['pwd'], PASSWORD_BCRYPT);
                $user->setPwd($pwdHash);
                $user->setToken($newToken);
                $user->setIsConfirmed($userSelect[0]['isConfirmed']);
                $user->setIdRole($userSelect[0]['id_role']);
                $user->save();

                header('location:/connexion');

            }else{
                $view->assign("errors", $errors);
            }
        }

    }
}