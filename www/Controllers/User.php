<?php

namespace App\Controller;

use App\Core\Email;
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
			
			//$errors = FormValidator::check($form, $_POST);
            $errors = [];
			if(empty($errors)){


			    if ($user->select('*')->where('email=:email')->setParams([":email" => $_POST['email']])->get()){
                    $pwdGet = $user->select('pwd')->where('email=:email')->setParams([":email" => $_POST['email']])->get();


                    if(password_verify($_POST["pwd"], $pwdGet[0]["pwd"])){
                        session_start();
                        $monUser = $user->select('*')->where('email=:email', 'pwd=:pwd')->setParams([":email" => $_POST['email'],":pwd" => $pwdGet[0]["pwd"],])->get();
                        $_SESSION['user'] = $monUser;
                        var_dump($_SESSION["user"]);
                        header('location:/');
                    }else{
                        array_push($errors,"L'email et le mot de passe ne correspondent pas");
                        $view->assign("errors", $errors);

                    }
                }else{
                    array_push($errors,"L'email inconnu");
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
        //echo "<pre>";
        //var_dump($user->select('id')->where("email=:email", "id_role = :role")->setParams([":email" => "samy.saberi@gmail.com", ":role" => 1])->get());
        //exit();
        if(!empty($_POST)){
            $errors = [];
            if(empty($errors)){

                $pwdGet = $user->select('pwd')->where('email=:email')->setParams([":email" => $_POST['email']])->get();




                if ($user->select('*')->where("email=:email", "id_role = 1")->setParams([":email" => $_POST['email']])->get()){
                    $pwdGet = $user->select('pwd')->where('email=:email')->setParams([":email" => $_POST['email']])->get();


                    if(password_verify($_POST["pwd"], $pwdGet[0]["pwd"])){
                        session_start();
                        $monUser = $user->select('*')->where('email=:email', 'pwd=:pwd')->setParams([":email" => $_POST['email'],":pwd" => $pwdGet[0]["pwd"],])->get();
                        $_SESSION['user'] = $monUser;
                        var_dump($_SESSION["user"]);
                        header('location:/');
                    }else{
                        array_push($errors,"L'email et le mot de passe ne correspondent pas");
                        $view->assign("errors", $errors);

                    }
                }else{
                    array_push($errors,"Cette adresse mail est inconnu ou n'a pas les droits administrateur");
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


        if(!empty($_POST)){

            //$errors = FormValidator::check($form, $_POST);

            $lastname = $_POST["lastname"];
            $firstname = $_POST["firstname"];
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];
            $pwdConfirm = $_POST['pwdConfirm'];
            $country = $_POST['country'];

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
                    $user->setIdRole(2);
                    $user->setToken($token);

                    $user->save();

                    Email::sendEmail("samy.sab92@gmail.com", "Veuillez confirmer votre compte", "http://localhost:8080/confirmation-inscription?tkn=".$token,"Confimer mon compte", "/");


                    header('location:/connexion');
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
