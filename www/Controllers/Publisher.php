<?php
namespace App\Controller;

use App\Core\View;

$myPublisher = new Publisher();

if (isset($_POST['dataHtml']) && isset($_POST['namePage'])){
    $myPublisher->savePublisher($_POST['dataHtml'], $_POST['namePage']);
}

if (isset($_POST['namePage'])){
    $myPublisher->readPublisher($_POST['namePage']);
}

if (isset($_POST['listImages'])){
    $myPublisher->listImages();
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
        if (!file_exists("./publisher/templatesPublisher/".$_GET["name"].".json")){
            header("Location: /admin/display-pages");
            exit();
        }
        $view = new View("publisher.back", "publisher");
        $view->assign("title", "Editeur");
    }

    public function savePublisher($dataHtml, $namePage){
        file_put_contents("../publisher/templatesPublisher/".$namePage.".json", $dataHtml);
    }

    public function readPublisher($namePage){

        if (file_exists("../publisher/templatesPublisher/".$namePage.".json")){
            echo  file_get_contents("../publisher/templatesPublisher/".$namePage.".json");
        }else {
            echo null;
        }
    }

    public function listImages(){
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

    public function deleteImage($srcImage){
        unlink($srcImage);
    }

    public function uploadImage(){

        if(isset($_FILES['file']['name'])){

            $filename = $_FILES['file']['name'];

            $location = "../publisher/images/".$filename;

            $response = 0;

            if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                $response = $location;
            }

            echo $response;
            exit;
        }
    }
}