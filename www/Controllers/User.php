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
use App\Core\Security;

session_start();

class User extends Database
{
    /*
     * méthode de connexion user et admin
     */
	public function loginAction(){

		$user = new UserModel();

		$view = new View("login", "front");

		$form = $user->formBuilderLogin();

		if(!empty($_POST)){

		    $errors = [];

			if(!empty($_POST['email'] &&
            !empty($_POST['pwd'] &&
            !empty($_POST['captcha']) &&
            count($_POST) == 3))) {

                if (strtoupper($_POST['captcha']) == $_SESSION['captcha']) {

                    if ($user->select('*')->where('email=:email')->setParams([":email" => $_POST['email']])->get()) {
                        $pwdGet = $user->select('pwd')->where('email=:email')->setParams([":email" => $_POST['email']])->get();

                        $isConfirmed = $user->select('isConfirmed')->where('email=:email')->setParams([":email" => $_POST['email']])->get();

                        if (password_verify($_POST["pwd"], $pwdGet[0]["pwd"])) {

                            if ($isConfirmed[0]["isConfirmed"] == "1") {


                                $monUser = $user->select('*')->where('email=:email', 'pwd=:pwd')->setParams([":email" => $_POST['email'], ":pwd" => $pwdGet[0]["pwd"],])->get();
                                $_SESSION['user'] = $monUser[0];

                                if (isset($_GET['reason']) && !empty($_GET['reason'])) {
                                    if ($_GET['reason'] == 'stripe') {
                                        header('location:/panier');
                                        exit();
                                    }
                                }

                                if ($_SESSION['user']['id_role'] != 2) {
                                    header('location: /admin/dashboard');
                                } else {
                                    header('location: /');
                                }

                            } else {
                                array_push($errors, "Vous devez d'abord confimer votre compte");
                                $view->assign("errors", $errors);
                            }
                        } else {
                            array_push($errors, "L'email et le mot de passe ne correspondent pas");
                            $view->assign("errors", $errors);

                        }
                    } else {
                        array_push($errors, "L'email inconnu");
                        $view->assign("errors", $errors);
                    }
                }else{
                    array_push($errors, 'Captcha incorrect');
                    $view->assign("errors", $errors);
                }
            } else {
                array_push($errors, 'Veuillez remplir tous les champs');
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
        $view = new View("register");

        $form = $user->formBuilderRegister();
        $view->assign("form", $form);
        $view->assign("title", "C&C - Inscription");

        if(!empty($_POST)){

            $errors = FormValidator::checkClient($form, $_POST,false, true);
            if(empty($errors)) {

                    $token = openssl_random_pseudo_bytes(32);
                    $token = bin2hex($token);
                    $pwdHash = password_hash($_POST['pwd'], PASSWORD_BCRYPT);
                    $user->populate($_POST);
                    $user->setPwd($pwdHash);
                    $user->setStatus(1);
                    $user->setIdRole(2);
                    $user->setToken($token);

                    $user->save();

                    Email::sendEmail("C&C - Confirmation du compte", $_POST['email'], "Veuillez confirmer votre compte", "http://".$_SERVER['SERVER_NAME']."/confirmation-inscription?tkn=".$token,"Confimer mon compte", "/");
                    $_SESSION['successRegister'] = "Merci pour votre inscription. Un email vous a été envoyé";
                    header('location:/connexion');
            }else{
                    $view->assign("errors", $errors);
            }
        }
	}

	// CLIENTS //

    public function displayClientAction(){

	    Security::auth("customers");

        $clients = new UserModel();
        $array = $clients->select()->where("status = 1","id_role = 2")->get();
        $view = new View("clientList.back", "back");
        $view->assign("title", "Admin - Client");
        $view->assign("array", $array);
    }

    public function newClientAction(){

        Security::auth("customers");

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
                        Email::sendEmail("C&C - Creation de votre compte",$client->getEmail(), "Votre mot de passe : " . $pwd, "http://".$_SERVER['SERVER_NAME']."/confirmation-inscription?tkn=".$token,"Confirmer votre compte", "/admin/liste-client");
                    }
                }else{
                    http_response_code(400);
                }
            }else {
                $view->assign("errors", $error);
            }
    }


    function updateClientAction(){

        Security::auth("customers");
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

        Security::auth("customers");

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

        Security::auth("users");

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

                Email::sendEmail("C&C - Creation de votre compte",$user->getEmail(), "Votre mot de passe : " . $_POST['pwd'], "http://".$_SERVER['SERVER_NAME']."/confirmation-inscription?tkn=".$token,"Confirmer mon compte", "/admin/liste-utilisateurs");

                $view->assign("success", "L'utilisateur a bien été créé !");
            } else {
                $view->assign("errors", $errors);
            }
        }
    }

    public function displayUsersAction(){

        Security::auth("users");

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

        Security::auth("users");

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

        Security::auth("users");

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

        Security::auth("users");

        if (isset($_GET['id']) && !empty($_GET['id'])) {

            $user = new UserModel();
            $verifyId = $user->select()->where("id = :id", "id_role > 2")->setParams(["id" => $_GET['id']])->get();

            if (empty($verifyId)) {
                header("Location: /admin/liste-utilisateurs");
                exit();
            }

            $user->populate($verifyId[0]);
            $user->setId($_GET['id']);
            $user->setIdRole($verifyId[0]['id_role']);
            $user->setToken($verifyId[0]["token"]);
            $user->setIsConfirmed($verifyId[0]["isConfirmed"]);
            $pwd = Helpers::pwdGenerator();
            $user->setPwd(password_hash($pwd, PASSWORD_DEFAULT));
            $user->save();

            $_SESSION['successChangePwd'] = "Mot de passe modifié !";

            Email::sendEmail("C&C - Changement de mot de passe",$user->getEmail(), "Votre nouveau mot de passe : " . $pwd, "http://".$_SERVER['SERVER_NAME']."/admin/dashboard","Dashboard", "/admin/modification-utilisateur?id=" . $_GET['id']);

        }else{
            header("Location: /admin/liste-utilisateurs");
        }
    }


    public function displayProfileAction(){

        if (!Security::isConnected()){
            header('Location: /');
            exit();
        }

        $view = new View("myProfile.front");
        $view->assign("title", "Mon profil");
        $user = new UserModel();

        $form = $user->formBuilderCreateClient();

        $getInfo = $user->select('email,pwd,token,isConfirmed,id_role')->where("id = :id ")->setParams(["id" => $_SESSION['user']['id']])->get();

        if(!empty($_POST)) {


            $error = FormValidator::checkClient($form, $_POST, trim($_POST['email']) === $getInfo[0]['email']);

            if (empty($error)) {
                $user->populate($_POST);
                $user->setId($_SESSION['user']['id']);
                $user->setPwd($getInfo[0]['pwd']);
                $user->setToken($getInfo[0]['token']);
                $user->setIsConfirmed($getInfo[0]['isConfirmed']);
                $user->setStatus(1);
                $user->setIdRole($getInfo[0]['id_role']);
                $user->save();

                $view->assign("message", "Votre profil a bien été modifié !");
            }else{

                $view->assign("errors", $error);
            }
        }
        $getInfos = $user->select()->where("id = :id")->setParams(['id' => $_SESSION['user']['id']])->get();
        $view->assign("user", $getInfos[0]);
    }

    public function updateUserPasswordAction(){

        if (!Security::isConnected()){
            header('Location: /');
            exit();
        }

        if (!empty($_POST)) {
            $user = new UserModel();

            if (count($_POST) != 3) {
                $this->errorRedirection('Formulaire non conforme', 'error');
            } else {

                $oldPwd = htmlspecialchars($_POST['old_pwd']);
                $newPwd = htmlspecialchars($_POST['pwd']);
                $newPwdConfirm = htmlspecialchars($_POST['new_pwd_confirm']);

                if (empty($oldPwd) ||
                    empty($newPwd) ||
                    empty($newPwdConfirm)) {
                    $this->errorRedirection('Veuillez remplir tous les champs', 'error');
                }


                $dataUser = $user->select()->where("id = :id")->setParams(["id" => $_SESSION['user']['id']])->get();

                if (!password_verify($oldPwd, $dataUser[0]['pwd'])) {
                    $this->errorRedirection('Le mot de passe est incorrect', 'error');
                }

                if( !preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]){8,}/",$newPwd)){
                    $this->errorRedirection('Votre mot de passe doit faire au minimum 8 caractères, contenir une majuscule et un chiffre.', 'error');
                }

                if ($newPwd !== $newPwdConfirm) {
                    $this->errorRedirection('Les deux mots de passe sont différents', 'error');
                }

                $pwdHash = password_hash($newPwd, PASSWORD_BCRYPT);

                $user->populate($dataUser[0]);
                $user->setPwd($pwdHash);
                $user->save();
                $this->errorRedirection('Modification réussie', 'success');
            }
        }else{
            header('Location: /mon-profil');
        }
    }

    private function errorRedirection($msg, $type){

        if ($type === 'error'){
            $_SESSION['errors'] = $msg;
        }else{
            $_SESSION['success'] = $msg;
        }
        header('Location: /mon-profil');
        exit();
    }

}
