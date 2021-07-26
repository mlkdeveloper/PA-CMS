<?php
namespace App\Controller;

use App\Core\View;
use App\Core\Security;

session_start();

class Publisher
{
    public function publisherAction(){ //Affichage de l'éditeur
        Security::auth("pages");

        if (!file_exists("./publisher/templatesPublisher/".$_GET["name"].".json")){
            header("Location: /admin/pages");
            exit();
        }
        $view = new View("publisher.back", "publisher");
        $view->assign("title", "Editeur");
    }

    public function savePublisherAction(){ //Enregistrement de la page
        Security::auth("pages");

        $dataHtml = $_POST['dataHtml'];
        $namePage = $_POST['namePage'];

        file_put_contents("./publisher/templatesPublisher/".$namePage.".json", $dataHtml);
    }

    public function readPublisherAction(){ //Lecture du fichier JSON
        Security::auth("pages");

        $namePage = $_POST['namePage'];

        if (file_exists("./publisher/templatesPublisher/".$namePage.".json")){
            echo  file_get_contents("./publisher/templatesPublisher/".$namePage.".json");
        }else {
            echo null;
        }
    }

    public function listImagesAction(){ //Récupération de la liste des images
        Security::auth("pages");

        $images = "";
        $list =array_diff(scandir("./publisher/images"), array('.', '..'));
        foreach ($list as $image){
            $images .= $image."|";
        }

        if ($images){
            echo($images);
        }else {
            echo("undefined");
        }
    }

    public function checkDeleteImageAction(){ //Vérification de la suppression d'une image
        Security::auth("pages");

        $srcImage = $_POST['checkDeleteImage'];
        $namePage = $_POST['namePageDeleteImage'];

        $result = "false";

        $list =array_diff(scandir("./publisher/templatesPublisher"), array('.', '..'));
        foreach ($list as $template){
            if ($template !== $namePage.".json"){
                $content = file_get_contents("./publisher/templatesPublisher/".$template);

                if(strpos($content, $srcImage) !== false) {
                    $result = explode(".", $template)[0];
                    break;
                }
            }
        }
        echo $result;
    }

    public function deleteImageAction(){ //Suppression d'une image
        Security::auth("pages");

        $srcImage = substr($_POST['srcImage'], 1);
        unlink($srcImage);
    }

    public function uploadImageAction(){ //Transfère d'une image

        Security::auth("pages");

        if(isset($_FILES['file']['name'])){

            $filename = $_FILES['file']['name'];

            $location = "./publisher/images/".$filename;

            $regex = '/(jpg|png|jpeg)$/i';

            if (preg_match($regex, $filename) == 0) {
                $error = (json_encode(array("error" => "Ce type d'image n'est pas pris en charge")));
            }else{

                $list =array_diff(scandir("./publisher/images"), array('.', '..'));
                foreach ($list as $image){
                    if ($image === "$filename"){
                        $error = (json_encode(array("error" => "Une image avec ce nom existe déjà")));
                        break;
                    }
                }

                if ($_FILES['file']['size'] > 15000000) {
                    $error = (json_encode(array("error" => "Le poids de l'image doit être inférieure à 15 MO")));
                }
            }

            if (empty($error)){
                if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                    echo (json_encode(array("success" => $location)));
                }else{
                    echo (json_encode(array("error" => "Impossible d'enregistrer l'image")));
                }
            }else{
                echo $error;
            }
        }else {
            echo (json_encode(array("error" => "Impossible d'enregistrer l'image")));
        }
    }
}