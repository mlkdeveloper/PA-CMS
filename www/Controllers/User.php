<?php

namespace App\Controller;

use App\Core\Email;
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
            $errors = [];
			if(empty($errors)){


			    if ($user->select('*')->where('email=:email')->setParams([":email" => $_POST['email']])->get()){
                    $pwdGet = $user->select('pwd')->where('email=:email')->setParams([":email" => $_POST['email']])->get();

                    $isConfirmed = $user->select('isConfirmed')->where('email=:email')->setParams([":email" => $_POST['email']])->get();

                    if(password_verify($_POST["pwd"], $pwdGet[0]["pwd"])) {

                        if ($isConfirmed[0]["isConfirmed"] == "1") {


                            session_start();
                            $monUser = $user->select('*')->where('email=:email', 'pwd=:pwd')->setParams([":email" => $_POST['email'], ":pwd" => $pwdGet[0]["pwd"],])->get();
                            $_SESSION['user'] = $monUser;
                            var_dump($_SESSION["user"]);
                            header('location:/');
                        }else{
                            array_push($errors,"Vous devez d'abord confimer votre compte");
                            $view->assign("errors", $errors);
                        }
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


	public function registerAction()
    {
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
                    $user->setFirstName($firstname);
                    $user->setEmail($email);
                    $user->setPwd($pwdHash);
                    $user->setStatus(1);
                    $user->setIdRole(2);
                    $user->setToken($token);

                    $user->save();

                    Email::sendEmail($email, "Veuillez confirmer votre compte", "http://localhost:8080/confirmation-inscription?tkn=".$token,"Confimer mon compte", "/");


                    header('location:/connexion');
                }else{
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
        session_start();
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
                    $getInfo = $client->select('pwd,token,isConfirmed')->where("id = :id ")->setParams(["id" => $_GET['id'] ])->get();
                    $client->setPwd( $getInfo[0]['pwd']);
                    $client->setToken($getInfo[0]['token']);
                    $client->setIsConfirmed($getInfo[0]['isConfirmed']);

                }else{
                    $pwd = Helpers::pwdGenerator();
                    $client->setPwd(password_hash($pwd, PASSWORD_DEFAULT));

                    $token = openssl_random_pseudo_bytes(32);
                    $token = bin2hex($token);
                    $client->setToken($token);
                }

                $client->populate($_POST);
                $client->setStatus(1);
                $client->setIdRole(2);

                $returnValue = $client->save();
                $message = $this->returnValue($returnValue,$formStatus);

                if ($message != false){
                    $view->assign("message", $message);

                    if($formStatus == Database::NEW_OBJECT){
                        Email::sendEmail($client->getEmail(), "Veuillez confirmer votre compte", "http://localhost:8082/confirmation-inscription?tkn=".$token,"Confirmer mon compte", "/admin/liste-client");
                    }
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
                $token = openssl_random_pseudo_bytes(32);
                $token = bin2hex($token);
                $user->setToken($token);
                $user->save();

                Email::sendEmail($user->getEmail(), "Veuillez confirmer votre compte", "http://localhost:8082/confirmation-inscription?tkn=".$token,"Confirmer mon compte", "/admin/dashboard");

                $view->assign("success", "L'utilisateur a bien été créé !");
            } else {
                $view->assign("errors", $errors);
            }
        }
    }

    public function displayUsersAction(){
        session_start();
        $user = new UserModel();
        $view = new View("usersList.back", "back");
        $view->assign("title", "Admin - Utilisateurs");

        $users = $user->select(DBPREFIXE."user.id, ".DBPREFIXE."user.lastname, ".DBPREFIXE."user.firstname, ".DBPREFIXE."user.email, ".DBPREFIXE."role.name")
            ->where(DBPREFIXE."user.id_role > 2")
            ->innerJoin(DBPREFIXE."role",DBPREFIXE."role.id","=",DBPREFIXE."user.id_role")
            ->get();

        $view->assign("users", $users);


    }

    public function deleteUserAction(){

        if (isset($_GET['id']) && !empty($_GET['id'])) {

            $user = new UserModel();
            $verifyId = $user->select("id")->where("id = :id", "id_role > 2")->setParams(["id" => $_GET['id']])->get();

            if (empty($verifyId)) {
                header("Location: /admin/liste-utilisateur");
                exit();
            }

            $user->setId($_GET['id']);
            $user->where("id= :id")->setParams(["id" => $_GET['id']])->delete();

            $_SESSION['deleteUser'] = "Utilisateur supprimé ! ";

            header("Location: /admin/liste-utilisateurs");
        }

    }

    public function updateUserAction(){

        if (isset($_GET['id']) && !empty($_GET['id'])) {

            $userId = new UserModel();
            $verifyId = $userId->select("id, email,pwd,token,isConfirmed")->where("id = :id", "id_role > 2")->setParams(["id" => $_GET['id']])->get();

            if (empty($verifyId)) {
                header("Location: /admin/liste-utilisateurs");
                exit();
            }

            $role = new Role();
            $getRoles = $role->select("id,name")->where("id > 2")->get();

            $view = new View("updateUser.back", "back");
            $view->assign("roles", $getRoles);
            $view->assign("title", "Admin - Utilisateur");

            $form = $userId->formUpdateUsers();

            if(!empty($_POST)) {

                $errors = FormValidator::checkClient($form, $_POST, trim($_POST['email']) === $verifyId[0]["email"]);

                if (empty($errors)) {
                    $userId->populate($_POST);
                    $userId->setId($_GET['id']);
                    $userId->setPwd($verifyId[0]["pwd"]);
                    $userId->setToken($verifyId[0]["token"]);
                    $userId->setIsConfirmed($verifyId[0]["isConfirmed"]);
                    $userId->setStatus(1);
                    $userId->save();

                    $view->assign("success", "L'utilisateur a bien été modifié !");
                } else {
                    $view->assign("errors", $errors);
                }
            }

            $users = $userId->select(DBPREFIXE."user.pwd, ".DBPREFIXE."user.id, ".DBPREFIXE."user.lastname, ".DBPREFIXE."user.firstname, ".DBPREFIXE."user.email, ".DBPREFIXE."role.name")
                ->where(DBPREFIXE."user.id = :id",DBPREFIXE."user.id_role > 2")
                ->setParams(['id' => $_GET['id']])
                ->innerJoin(DBPREFIXE."role",DBPREFIXE."role.id","=",DBPREFIXE."user.id_role")
                ->get();

            $view->assign("users", $users[0]);

        }else{
            header("Location: /admin/liste-utilisateurs");
        }
    }


    public function changeUserPwdAction(){

        if (isset($_GET['id']) && !empty($_GET['id'])) {

            $user = new UserModel();
            $verifyId = $user->select()->where("id = :id", "id_role > 2")->setParams(["id" => $_GET['id']])->get();

            if (empty($verifyId)) {
                header("Location: /admin/liste-utilisateurs");
                exit();
            }
            $form = $user->formPwdUsers();

            if(!empty($_POST)) {

                $errors = FormValidator::checkClient($form, $_POST, false);
                session_start();
                if (empty($errors)) {
                    $user->populate($verifyId[0]);
                    $user->setId($_GET['id']);
                    $user->setIdRole($verifyId[0]['id_role']);
                    $user->setToken($verifyId[0]["token"]);
                    $user->setIsConfirmed($verifyId[0]["isConfirmed"]);
                    $user->setPwd(password_hash($_POST['pwd'], PASSWORD_DEFAULT));
                    $user->save();

                    $_SESSION['successChangePwd'] = "Mot de passe modifié !";

                } else {
                    $_SESSION['errorChangePwd'] = "Votre mot de passe doit faire au minimum 8 caractères, contenir une majuscule et un chiffre.";
                }
                header("Location: /admin/modification-utilisateur?id=" . $_GET['id']);
            }else{
                header("Location: /admin/liste-utilisateurs");
            }
        }else{
            header("Location: /admin/liste-utilisateurs");
        }
    }

}
