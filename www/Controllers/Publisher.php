<?php
namespace App\Controller;

use App\Core\View;
use App\Core\Security;

session_start();

$myPublisher = new Publisher();

if (isset($_POST['dataHtml']) && isset($_POST['namePage'])){
    $myPublisher->savePublisher($_POST['dataHtml'], $_POST['namePage']);
}

if (isset($_POST['listImages'])){
    $myPublisher->listImages();
}

if (isset($_POST['checkDeleteImage']) && isset($_POST['namePageDeleteImage'])){
    $myPublisher->checkDeleteImage($_POST['checkDeleteImage'], $_POST['namePageDeleteImage']);
}

if (isset($_POST['srcImage'])){
    $myPublisher->deleteImage($_POST['srcImage']);
}

if (isset($_FILES['file'])){

    $myPublisher->uploadImage();
}

class Publisher
{
    public function publisherAction(){

        Security::auth("pages");

        if (!file_exists("./publisher/templatesPublisher/".$_GET["name"].".json")){
            header("Location: /admin/pages");
            exit();
        }
        $view = new View("publisher.back", "publisher");
        $view->assign("title", "Editeur");
    }

    public function savePublisher($dataHtml, $namePage){
        Security::auth("pages");
        file_put_contents("../publisher/templatesPublisher/".$namePage.".json", $dataHtml);
    }

    public function readPublisherAction(){
        $namePage = $_POST['namePage'];

        Security::auth("pages");
        if (file_exists("../publisher/templatesPublisher/".$namePage.".json")){
            echo  file_get_contents("../publisher/templatesPublisher/".$namePage.".json");
        }else {
            echo null;
        }
    }

    public function listImages(){

        Security::auth("pages");
        $images = "";
        $list =array_diff(scandir("../publisher/images"), array('.', '..'));
        foreach ($list as $image){
            $images .= $image."|";
        }

        if ($images){
            echo($images);
        }else {
            echo("undefined");
        }
    }

    public function checkDeleteImage($srcImage, $namePage){

        Security::auth("pages");
        $result = "false";

        $list =array_diff(scandir("../publisher/templatesPublisher"), array('.', '..'));
        foreach ($list as $template){
            if ($template !== $namePage.".json"){
                $content = file_get_contents("../publisher/templatesPublisher/".$template);

                if(strpos($content, $srcImage) !== false) {
                    $result = explode(".", $template)[0];
                    break;
                }
            }
        }
        echo $result;
    }

    public function deleteImage($srcImage){
        Security::auth("pages");
        unlink($srcImage);
    }

    public function uploadImage(){

        Security::auth("pages");

        if(isset($_FILES['file']['name'])){

            $filename = $_FILES['file']['name'];

            $location = "../publisher/images/".$filename;


            $regex = '/(jpg|png|jpeg)$/i';

            if (preg_match($regex, $filename) == 0) {
                $error = (json_encode(array("error" => "Ce type d'image n'est pas pris en charge")));
            }else{

                $list =array_diff(scandir("../publisher/images"), array('.', '..'));
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
        }
    }
}