<?php
namespace App\Controller;

use App\Core\FormValidator;
use App\Core\Security as SecurityCore;
use App\Core\View;
use App\Models\User as UserModel;

class Security
{
    private $pdo;


    //Method : Action
    public function registerInstallAction(){

        $user = new UserModel();

        //Affiche la vue home intégrée dans le template du front
        $view = new View("installRegister.install", "install");

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
}