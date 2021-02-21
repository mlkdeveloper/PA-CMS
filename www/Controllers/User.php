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
        $view = new View("clientList.back", "back");
        $view->assign("title", "Admin - Client");
    }
    public function newClientAction(){

        $client = new ClientModel();

        $view = new View("createClient.back", "back");
        $view->assign("title", "Admin - Nouveau client");

        $formCreateClient = $client->formBuilderCreateClient();

        if(!empty($_POST)){

            $error = FormValidator::check($formCreateClient, $_POST);

            if(empty($errors)){
                $client->setName($_POST['firstName']);
                $client->setFirstName($_POST['lastName']);
                $client->setAddress($_POST['address']);
                $client->setCity($_POST['city']);
                $client->setZipCode($_POST['zipCode']);
                $client->setEmail($_POST['email']);
                $client->setPhoneNumber($_POST['phoneNumber']);
                $client->setStatus(1);
                $client->setIsDeleted(0);
                $client->setPwd("okjghhghghgghghghghgh");
                $client->setCreatedAt(date());
                $client->setIdRole(1);
                throw new Exception(json_encode($client));
                $client->save();

            }else{
                $view->assign("errors", $errors);
            }
        }
        $view->assign("form", $formCreateClient);
    }

}
