<?php


namespace App\Controller;
use App\Core\FormValidator;
use App\Models\User as UserModel;


use App\Core\View;
use PHPMailer\PHPMailer\PHPMailer;

class Security
{
    //Method : Action
    public function registerInstallAction(){


        //Affiche la vue home intégrée dans le template du front
        $view = new View("installRegister", "install");




    }

    public function installAction(){
        $view = new View("install", "install");
        $view->assign("title", "Intallation");
    }

    public function startInstall(){


    }
    public function logoutAction(){
        session_start();
        unset($_SESSION['user']);
        session_destroy();
        header('location:/');
        exit();
    }

    public function pwdPerduAction(){

        $view = new View("mdpOublie");
        $view->assign("title", "test php Mailer");
        $user = new UserModel();

        $form = $user->formBuilderpwdOublie();
        $view->assign("form", $form);

        $errors = [];

        if (!empty($_POST)){
            $email = $_POST['email'];

            if(!$user->select('email', 'token')->where('email=:email')->setParams(["email" => htmlspecialchars($_POST['email'])])->get()){
                array_push($errors, "L'email n'est pas connu de notre base de données, vous pouvez créer un nouveau compte");
            }
            $user = $user->select('email', 'token')->where('email=:email')->setParams(["email" => htmlspecialchars($_POST['email'])])->get();

            if (empty($errors)) {

                // on crée une nouvelle instance de la classe
                $mail = new PHPMailer(true);

                // puis on l’exécute avec un 'try/catch' qui teste les erreurs d'envoi
                try {
                    /* DONNEES SERVEUR */
                    #####################
                    $mail->setLanguage('fr', '../PHPMailer/language/');   // pour avoir les messages d'erreur en FR
                    //$mail->SMTPDebug = 0;            // en production (sinon "2")
                    $mail->SMTPDebug = 2;            // décommenter en mode débug
                    $mail->isSMTP();                                                            // envoi avec le SMTP du serveur
                    $mail->Host = 'smtp.gmail.com';                            // serveur SMTP
                    $mail->SMTPAuth = true;                                            // le serveur SMTP nécessite une authentification ("false" sinon)
                    $mail->Username = 'click.create.collect@gmail.com';     // login SMTP
                    $mail->Password = 'gezukstsbsuveyxy';                                                // Mot de passe SMTP
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // encodage des données TLS (ou juste 'tls') > "Aucun chiffrement des données"; sinon PHPMailer::ENCRYPTION_SMTPS (ou juste 'ssl')
                    $mail->Port = 587;                                                               // port TCP (ou 25, ou 465...)

                    /* DONNEES DESTINATAIRES */
                    ##########################
                    $mail->setFrom('ne-pas-repondre@samy.com', 'No-Reply');  //adresse de l'expéditeur (pas d'accents)
                    $mail->addAddress($email, 'Clients de Mon_Domaine');        // Adresse du destinataire (le nom est facultatif)
                    // $mail->addReplyTo('moi@mon_domaine.fr', 'son nom');     // réponse à un autre que l'expéditeur (le nom est facultatif)
                    // $mail->addCC('cc@example.com');            // Cc (copie) : autant d'adresse que souhaité = Cc (le nom est facultatif)
                    // $mail->addBCC('bcc@example.com');          // Cci (Copie cachée) :  : autant d'adresse que souhaité = Cci (le nom est facultatif)

                    /* PIECES JOINTES */
                    ##########################
                    // $mail->addAttachment('../dossier/fichier.zip');         // Pièces jointes en gardant le nom du fichier sur le serveur
                    // $mail->addAttachment('../dossier/fichier.zip', 'nouveau_nom.zip');    // Ou : pièce jointe + nouveau nom

                    /* CONTENU DE L'EMAIL*/
                    ##########################
                    $mail->isHTML(true);                                      // email au format HTML
                    $mail->Subject = utf8_decode("C&C - Récupération de mot de passe");      // Objet du message (éviter les accents là, sauf si utf8_encode)
                    $mail->Body = "Bonjour, <br><br>Vous trouverez ci-dessous le lien vous permettant de modifier votre mot de passe. <br><br> Lien : http://localhost:8080/recuperation-mot-de-passe?tkn=".$user[0]['token'];          // corps du message en HTML - Mettre des slashes si apostrophes
                    //$mail->AltBody = 'Contenu au format texte pour les clients e-mails qiui ne le supportent pas'; // ajout facultatif de texte sans balises HTML (format texte)

                    $mail->send();

                    header('location:/connexion');

                } // si le try ne marche pas > exception ici
                catch (Exception $e) {
                    echo "Le Message n'a pas été envoyé. Mailer Error: {$mail->ErrorInfo}"; // Affiche l'erreur concernée le cas échéant
                }
            }else{
                $view->assign("errors", $errors);
            }

        }

    }

    public function recuperationpwdAction(){
        $view = new View("recuperationPwd");
        $view->assign("title", "C&C - Modification du mot de passe");

        $user = new UserModel();

        $form = $user->formBuildermodifyPwd();
        $view->assign("form", $form);

        $errors = FormValidator::check($form, $_POST);


        if (!empty($_POST)){

            $pwd = htmlspecialchars($_POST['pwd']);
            $pwdConfirm = htmlspecialchars(($_POST['pwdConfirm']));
            $token = htmlspecialchars($_GET['tkn']);


            if ($pwd != $pwdConfirm){
                array_push($errors, 'Les mot de passe ne correspondent pas');
            }
            if (!$user->select('id')->where('token=:token')->setParams(['token' => $token])->get()){
                array_push($errors, "ALERTE : modification du token dans le GET");
            }

            if (empty($errors)){

                $userSelect = $user->select('*')->where('token=:token')->setParams(['token' => $token])->get();

                //Generate a random string.
                $newToken = openssl_random_pseudo_bytes(32);
                //Convert the binary data into hexadecimal representation.
                $newToken = bin2hex($newToken);

                $user->populate($userSelect[0]);
                $user->setId($userSelect[0]['id']);
                $pwdHash = password_hash($pwd, PASSWORD_BCRYPT);
                $user->setPwd($pwdHash);
                $user->setToken($newToken);
                $user->save();
                echo '<pre>';

                header('location:/connexion');

            }else{
                $view->assign("errors", $errors);
            }
        }

    }
}