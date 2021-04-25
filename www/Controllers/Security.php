<?php


namespace App\Controller;
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

        if (!empty($_POST)){

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
                $mail->Host       = 'smtp.gmail.com';                            // serveur SMTP
                $mail->SMTPAuth   = true;                                            // le serveur SMTP nécessite une authentification ("false" sinon)
                $mail->Username   = 'click.create.collect@gmail.com';     // login SMTP
                $mail->Password   = 'Th4@W4U9ndAo';                                                // Mot de passe SMTP
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // encodage des données TLS (ou juste 'tls') > "Aucun chiffrement des données"; sinon PHPMailer::ENCRYPTION_SMTPS (ou juste 'ssl')
                $mail->Port       = 587;                                                               // port TCP (ou 25, ou 465...)

                /* DONNEES DESTINATAIRES */
                ##########################
                $mail->setFrom('ne-pas-repondre@samy.com', 'No-Reply');  //adresse de l'expéditeur (pas d'accents)
                $mail->addAddress("samy.sab92@gmail.com", 'Clients de Mon_Domaine');        // Adresse du destinataire (le nom est facultatif)
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
                $mail->Subject = utf8_decode("JE SUIS UN TEST");      // Objet du message (éviter les accents là, sauf si utf8_encode)
                $mail->Body    = "JE SUIS LE CORP DU MAIL";          // corps du message en HTML - Mettre des slashes si apostrophes
                //$mail->AltBody = 'Contenu au format texte pour les clients e-mails qiui ne le supportent pas'; // ajout facultatif de texte sans balises HTML (format texte)



                $mail->send();
                echo 'Message envoyé.';

                header('location:/recuperation-mot-de-passe');

            }
                // si le try ne marche pas > exception ici
            catch (Exception $e) {
                echo "Le Message n'a pas été envoyé. Mailer Error: {$mail->ErrorInfo}"; // Affiche l'erreur concernée le cas échéant
                var_dump($e);
                exit();
            }

        }

    }

    public function recuperationpwdAction(){

        //je suis sur la page avec ? tkn
    }

}