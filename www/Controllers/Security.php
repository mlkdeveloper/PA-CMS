<?php
namespace App\Controller;
use App\Core\FormValidator;
use App\Core\View;
use App\Models\User as UserModel;

class Security
{

    //Method : Action
    public function registerInstallAction(){

        $user = new UserModel();

        //Affiche la vue home intégrée dans le template du front
        $view = new View("installRegister.install", "install");

        $formInstallRegister = $user->formBuilderInstallRegister();


        if(!empty($_POST)){

            //$errors = FormValidator::check($form, $_POST);

            $lastname = $_POST["lastname"];
            $firstname = $_POST["firstname"];
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];
            $pwdConfirm = $_POST['pwdConfirm'];

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
                    $user->setIsDeleted(0);
                    $user->setIdRole(1);
                    $user->setToken($token);

                    $user->save();
                    echo '<pre>';
                    var_dump($user);
                    exit();
                    header('location:/');
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

}