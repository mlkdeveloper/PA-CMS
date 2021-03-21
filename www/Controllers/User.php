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



        //$user->selectAll(2);
        /*
        $user->setFirstname("Toto");
        $user->save();
        */
	}


	//Method : Action
	public function registerAction(){

		$user = new UserModel();
		$view = new View("register"); 

		$form = $user->formBuilderRegister();

		if(!empty($_POST)){
			
			$errors = FormValidator::check($form, $_POST);

			if(empty($errors)){
				$user->setFirstname($_POST["firstname"]);
				$user->setLastname($_POST["lastname"]);
				$user->setEmail($_POST["email"]);
				$user->setPwd($_POST["pwd"]);
				$user->setCountry($_POST["country"]);

				$user->save();
			}else{
				$view->assign("errors", $errors);
			}
		}

		$view->assign("form", $form);
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


    public function displayClientAction(){
        $clients = new UserModel();
        $array = $clients->select()->get();

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

    public function saveForm($view, $client, $form){
        if(!empty($_POST)){
            $error = FormValidator::check($form, $_POST);
        }
        if(empty($errors)){

            $pwd = $this->pwdGenerator();

            $client->setFirstName(htmlspecialchars($_POST['firstName']));
            $client->setLastname(htmlspecialchars($_POST['lastName']));
            $client->setEmail(htmlspecialchars($_POST['email']));
            $client->setPhoneNumber(htmlspecialchars($_POST['phoneNumber']));
            $client->setAddress(htmlspecialchars($_POST['address']));
            $client->setCity(htmlspecialchars($_POST['city']));
            $client->setZipCode(htmlspecialchars($_POST['zipCode']));
            $client->setCountry(htmlspecialchars($_POST['country']));
            $client->setStatus(1);
            $client->setIsDeleted(0);
            $client->setPwd(hash('sha256', $pwd));
            $client->setCreatedAt(date("Y-m-d H:i:s"));
            $client->setIdRole(1);
            $client->save();

        }else{
            $view->assign("errors", $errors);
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

}
