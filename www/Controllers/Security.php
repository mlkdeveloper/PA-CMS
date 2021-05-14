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

            $errors = FormValidator::check($formInstallRegister, $_POST);

            if(empty($errors)){
                $user->setFirstname($_POST['firstname']);
                $user->setLastname($_POST['lastname']);
                $user->setEmail($_POST['email']);
                $user->setPwd($_POST['pwd']);
                $user->setIdRole(1);

                $user->save();

            }else{
                $view->assign("errors", $errors);
            }
        }
        $view->assign("form", $formInstallRegister);

    }
}