<?php
namespace App\Controller;

use App\Core\View;

$myPublisher = new Publisher();

if (isset($_POST['dataHtml'])){
    $myPublisher->savePublisher($_POST['dataHtml']);
}

if (isset($_POST['idPage'])){
    $myPublisher->readPublisher($_POST['idPage']);
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
        $view = new View("publisher.back", "publisher");
        $view->assign("title", "Editeur");
    }

    public function savePublisher($dataHtml){
        file_put_contents("../publisher/templatesPublisher/test.json", $dataHtml);
    }

    public function readPublisher($idPage){

        if (file_exists("../publisher/templatesPublisher/test.json")){
            echo  file_get_contents("../publisher/templatesPublisher/test.json");
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

            /* Getting file name */
            $filename = $_FILES['file']['name'];

            /* Location */
            $location = "../publisher/images/".$filename;
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);

            /* Valid extensions */
            $valid_extensions = array("jpg","jpeg","png");

            $response = 0;
            /* Check file extension */
            if(in_array(strtolower($imageFileType), $valid_extensions)) {
                /* Upload file */

                if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                    $response = $location;
                }
            }

            echo $response;
            exit;
        }
    }
}