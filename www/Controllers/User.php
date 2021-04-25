<?php

namespace App\Controller;

use App\Core\Database;
use App\Core\Helpers;
use App\Core\View;
use App\Core\FormValidator;
use App\Models\User as UserModel;
use App\Models\Page;
use App\Models\Role;

class User extends Database
{
	public function loginAction(){

		$user = new UserModel();

		$monUser = new UserModel();
		$view = new View("login", "front");

		$form = $user->formBuilderLogin();

		if(!empty($_POST)){
			
			//$errors = FormValidator::check($form, $_POST);

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


	public function registerAction()
    {
        $user = new UserModel();

        $monUser = new UserModel();
        $view = new View("register");

        $form = $user->formBuilderRegister();
        $view->assign("form", $form);
        $view->assign("title", "C&C - Inscription");

        $errors = [];
        if (!empty($_POST)) {

            //$errors = FormValidator::check($form, $_POST);

            $lastname = $_POST["lastname"];
            $firstname = $_POST["firstname"];
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];
            $pwdConfirm = $_POST['pwdConfirm'];
            $country = $_POST['country'];

            if (empty($errors)) {

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
                } else {
                    array_push($errors, "Le mot de passe de confirmation ne correspond pas");
                    $view->assign("errors", $errors);
                }
            } else {
                $view->assign("errors", $errors);
            }
        }
	}


	// CLIENTS //

    public function displayClientAction(){
        $clients = new UserModel();
        $array = $clients->select()->where("status = 1","id_role = 2")->get();
        $view = new View("clientList.back", "back");
        $view->assign("title", "Admin - Client");
        $view->assign("array", $array);
    }

    public function newClientAction(){
        $client = new UserModel();
        $view = new View("createClient.back", "back");
        $view->assign("title", "Admin - Nouveau client");

        $formCreateClient = $client->formBuilderCreateClient();

        if (!empty($_POST)) {
            $this->saveForm($view, $client, $formCreateClient, false);
        }
    }

    public function saveForm($view, $client, $form, $isCreated, $formStatus = Database::NEW_OBJECT){

            $error = FormValidator::checkClient($form, $_POST, $isCreated);

            if (empty($error)) {

                if ($formStatus == Database::UPDATE_OBJECT) {
                    $client->setId($_GET['id']);
                    $pwd = $client->select('pwd')->where("id = :id ")->setParams(["id" => $_GET['id'] ])->get();
                    $client->setPwd( $pwd[0]['pwd']);
                }else{
                    $pwd = Helpers::pwdGenerator();
                    $client->setPwd(password_hash($pwd, PASSWORD_DEFAULT));
                }

                $client->populate($_POST);
                $client->setStatus(1);
                $client->setIdRole(2);

                $returnValue = $client->save();
                $message = $this->returnValue($returnValue,$formStatus);

                if ($message != false){
                    $view->assign("message", $message);
                }else{
                    http_response_code(400);
                }
            }else {
                $view->assign("errors", $error);
            }
    }


    function updateClientAction(){
        if (isset($_GET['id']) && !empty($_GET['id'])){

            $client = new UserModel();
            $verifyId = $client->select("id,email")->where("id = :id","id_role = 2","status = 1")->setParams(["id" => $_GET['id']])->get();

            if (empty($verifyId)) {
                header("Location: /admin/liste-client");
                exit();
            }

            $view = new View("updateClient.back", "back");

            $form = $client->formBuilderCreateClient();
            if (!empty($_POST)) {
                $this->saveForm($view, $client, $form, trim($_POST['email']) === $verifyId[0]["email"], Database::UPDATE_OBJECT);
            }

            $values = $client->select()->where("id = :id")->setParams(["id" => $_GET['id']])->get();
            $view->assign("values", ...$values);
            $view->assign("title", "Admin - Client");
        }else{
            header("Location: /admin/liste-client");
        }
    }

    function deleteClientAction()
    {

        if (isset($_GET['id']) && !empty($_GET['id'])){

            $client = new UserModel();
            $verifyId = $client->select("id")->where("id = :id", "id_role = 2","status = 1")->setParams(["id" => $_GET['id']])->get();

            if (empty($verifyId)) {
                header("Location: /admin/liste-client");
                exit();
            }

            $client->setId($_GET['id']);
            $client->setStatus(0);

            $returnValue = $client->deleteObject();
            $message = $this->returnValue($returnValue,3);

            if ($message != false) {
                session_start();
                $_SESSION['deleteClient'] = $message;
            }
            header("Location: /admin/liste-client");

        }else{

            header("Location: /admin/liste-client");
        }
    }

    public function returnValue($data, $statut){

	    $message = false;

	    if($data){
            if ($statut == 1 ){
                $message = "Utilisateur ajouté !";
            }
            if ($statut == 2){
                $message = "Utilisateur modifié !";
            }
            if ($statut == 3){
                $message = "Utilisateur supprimé !";
            }
        }
        return $message;
    }


    public function addUsersAction(){

        $user = new UserModel();
        $role = new Role();
        $view = new View("createUser.back", "back");
        $view->assign("title", "Admin - Utilisateur");

        $getRoles = $role->select("id,name")->where("id > 2")->get();
        $view->assign("roles", $getRoles);

        $form = $user->formUsers();

        if(!empty($_POST)) {

            $errors = FormValidator::checkClient($form, $_POST, false);

            if (empty($errors)) {
                $user->populate($_POST);
                $user->setPwd(password_hash($_POST['pwd'],PASSWORD_DEFAULT));
                $user->setStatus(1);
                $user->save();

                $view->assign("success", "L'utilisateur a bien été créé !");
            } else {
                $view->assign("errors", $errors);
            }
        }
    }

    public function displayUsersAction(){

        $user = new UserModel();
        $view = new View("usersList.back", "back");
        $view->assign("title", "Admin - Utilisateurs");

        $users = $user->select("cc_user.id,cc_user.lastname,cc_user.firstname,cc_user.email,cc_role.name")
            ->where("cc_user.id_role > 2")
            ->innerJoin("cc_role","cc_role.id","=","cc_user.id_role")
            ->get();

        $view->assign("users", $users);


    }

    public function deleteUserAction(){

        $user = new UserModel();
        $verifyId = $user->select("id")->where("id = :id", "id_role > 2")->setParams(["id" => $_GET['id']])->get();

        if (empty($verifyId)) {
            header("Location: /admin/liste-utilisateur");
            exit();
        }

        $user->setId($_GET['id']);
        $user->where("id= :id")->setParams(["id" => $_GET['id']])->delete();

        session_start();
        $_SESSION['deleteUser'] = "Utilisateur supprimé ! ";

        header("Location: /admin/liste-utilisateurs");

    }
}
