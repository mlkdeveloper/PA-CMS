<?php

namespace App\Controller;

use App\Core\Database;
use App\Core\View;
use App\Core\FormValidator;
use App\Models\User as UserModel;
use App\Models\Page;

class User extends Database
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


    public function displayClientAction(){
        $clients = new UserModel();
        $array = $clients->select()->where("status = :status")->setParams(["status" => 1])->get();
        $view = new View("clientList.back", "back");
        $view->assign("title", "Admin - Client");
        $view->assign("array", $array);
    }

    public function newClientAction(){
        $client = new UserModel();
        $view = new View("createClient.back", "back");
        $view->assign("title", "Admin - Nouveau client");

        $formCreateClient = $client->formBuilderCreateClient();
      //  $view->assign("form", $formCreateClient);
        $this->saveForm($view, $client, $formCreateClient);
    }

    public function saveForm($view, $client, $form, $formStatus = Database::NEW_OBJECT){

        if (!empty($_POST) && $formStatus != Database::DELETE_OBJECT) {
            $error = FormValidator::check($form, $_POST);

            if (empty($error) && $formStatus != Database::DELETE_OBJECT) {

                if ($formStatus == Database::UPDATE_OBJECT)
                    $client->setId($_GET['id']);

                $pwd = $this->pwdGenerator();

                $client->setFirstName($_POST['firstName']);
                $client->setLastname($_POST['lastName']);
                $client->setEmail($_POST['email']);
                $client->setPhoneNumber($_POST['phoneNumber']);
                $client->setAddress($_POST['address']);
                $client->setCity($_POST['city']);
                $client->setZipCode($_POST['zipCode']);
                $client->setCountry($_POST['country']);
                $client->setStatus(1);
                $client->setPwd(password_hash($pwd, PASSWORD_BCRYPT));
                $client->setCreatedAt(date("Y-m-d H:i:s"));
                $client->setIdRole(2);
                $retrunValue = $client->save();

                $message = FormValidator::returnValue($retrunValue, $formStatus); // 1 create , 2 update , 3 delete
                $view->assign("message", $message);
            } else {
                $view->assign("errors", $error);
            }
        }
        if ($formStatus == Database::DELETE_OBJECT){

            $client->setId($_POST['id']);
            $client->setStatus(0);

            $retrunValue = $client->deleteObject($_POST['id'], Database::USER_TABLE);

            $message = FormValidator::returnValue($retrunValue, $formStatus);
            $view->assign("message", $message);
        }
    }

    function pwdGenerator()
    {
        // Liste des caractères possibles
        $char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVW0123456789!<>/=:?";
        $mdp = '';
        $long = strlen($char);

        //Nombre aléatoire
        srand((double)microtime() * 1000000);
        for ($i = 0; $i < 10; $i++){
            $mdp = $mdp . substr($char, rand(0, $long - 1), 1);
        }
        return $mdp;
    }

    function updateClientAction(){
        if (isset($_GET['id']) && !empty($_GET['id'])){

            $client = new UserModel();
            $verifyId = $client->select("id")->where("id = :id")->setParams(["id" => $_GET['id']])->get();

            if (empty($verifyId))
                header("Location: /admin/liste_client");

            $view = new View("updateClient.back", "back");

            $form = $client->formBuilderCreateClient();
            $this->saveForm($view,$client,$form,Database::UPDATE_OBJECT);

            $values = $client->select()->where("id = :id")->setParams(["id" => $_GET['id']])->get();
            $view->assign("values", ...$values);
            $view->assign("title", "Admin - Client");
        }else{
            header("Location: /admin/liste_client");
        }
    }

    function deleteClientAction()
    {

        if (isset($_POST['id']) && !empty($_POST['id'])){

            $client = new UserModel();
            $verifyId = $client->select("id")->where("id = :id")->setParams(["id" => $_POST['id']])->get();

            if (empty($verifyId))
                header("Location: /admin/liste_client");

            $view = new View("clientList.back", "back");

            $form = $client->formDeleteClient();
            $this->saveForm($view,$client,$form,Database::DELETE_OBJECT);

            header("Location: /admin/liste-client");

        }else{

            header("Location: /admin/liste-client");
        }
    }
}
