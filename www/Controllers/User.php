<?php

namespace App\Controller;

use App\Core\View;
use App\Core\FormValidator;
use App\Models\User as UserModel;
use App\Models\Page;

class User
{

	//Method : Action
	public function defaultAction(){
        $user = new UserModel();
	}


	//Method : Action
	public function loginAction(){

		$user = new UserModel();

		$monUser = new UserModel();
		$view = new View("login", "front");

		$form = $user->formBuilderLogin();

		if(!empty($_POST)){
			
			$errors = FormValidator::check($form, $_POST);

			if(empty($errors)){
				$user->setEmail($_POST["email"]);
				$user->setPwd($_POST["pwd"]);

                if($user->select('email')->where('email=:email', 'pwd=:pwd')->setParams([":email" => $_POST['email'],":pwd" => $_POST['pwd'],])->get()){
                    session_start();
                    $monUser = $user->select('*')->where('email=:email', 'pwd=:pwd')->setParams([":email" => $_POST['email'],":pwd" => $_POST['pwd'],])->get();
                    $_SESSION['user'] = $monUser;
                    header('location:/');
                }else{
                    array_push($errors,"L'email et le mot de passe ne correspondent pas");
                    $view->assign("errors", $errors);
                }


				//$user->save();
			}else{
				$view->assign("errors", $errors);
			}
		}

		$view->assign("form", $form);
        $view->assign("title", "C&C - Connexion");
		$view->assign("formLogin", $user->formBuilderLogin());
	}

    //Method : Action
    public function loginAdminAction(){

        $user = new UserModel();

        $monUser = new UserModel();
        $view = new View("login", "front");

        $form = $user->formBuilderLogin();

        if(!empty($_POST)){

            $errors = FormValidator::check($form, $_POST);

            if(empty($errors)){
                $user->setEmail($_POST["email"]);
                $user->setPwd($_POST["pwd"]);

                if($user->select('email')->where('email=:email', 'pwd=:pwd', 'id_role = 1')->setParams([":email" => $_POST['email'],":pwd" => $_POST['pwd'],])->get()){
                    session_start();
                    $monUser = $user->select('*')->where('email=:email', 'pwd=:pwd')->setParams([":email" => $_POST['email'],":pwd" => $_POST['pwd'],])->get();
                    $_SESSION['user'] = $monUser;
                    header('location:/');
                }else{
                    array_push($errors,"L'email et le mot de passe ne correspondent pas / Vous n'avez pas les droits requis");
                    $view->assign("errors", $errors);
                }


                //$user->save();
            }else{
                $view->assign("errors", $errors);
            }
        }

        $view->assign("form", $form);
        $view->assign("title", "C&C - Connexion");
        $view->assign("formLogin", $user->formBuilderLogin());
    }


	//Method : Action
	public function addAction(){
		
		//Récupérer le formulaire
		//Récupérer les valeurs de l'internaute si il y a validation du formulaire
		//Vérification des champs (uncitié de l'email, complexité du pwd, ...)
		//Affichage du résultat

	}

	//Method : Action
	public function showAction(){
		
		//Affiche la vue user intégrée dans le template du front
		$view = new View("user"); 
	}



	//Method : Action
	public function showAllAction(){
		
		//Affiche la vue users intégrée dans le template du back
		$view = new View("users", "back"); 
		
	}

	public function registerAction(){
        $user = new UserModel();

        $monUser = new UserModel();
        $view = new View("register");

        $form = $user->formBuilderRegister();
        $view->assign("form", $form);
        $view->assign("title", "C&C - Inscription");

$errors = [];
        if(!empty($_POST)){

            $errors = FormValidator::check($form, $_POST);

            $lastname = $_POST["lastname"];
            $firstname = $_POST["firstname"];
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];
            $pwdConfirm = $_POST['pwdConfirm'];
            $country = $_POST['country'];

            if(empty($errors)) {

                if ($pwd == $pwdConfirm) {

                    $user->setLastname($lastname);
                    $user->setFirstname($firstname);
                    $user->setEmail($email);
                    $user->setPwd($pwd);
                    $user->setStatus(1);
                    $user->setIsDeleted(0);
                    $user->setIdRole(2);
                    $user->save();


                    header('location:/');
                }else{
                    array_push($errors, "Le mot de passe de confirmation ne correspond pas");
                    $view->assign("errors", $errors);
                }
            }else{
                $view->assign("errors", $errors);
            }

        }

    }
}
