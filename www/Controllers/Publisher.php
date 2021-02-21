<?php
namespace App\Controller;

use App\Core\View;

if (isset($_POST['dataHtml'])){
    $myPublisher = new Publisher();
    $myPublisher->savePublisher($_POST['dataHtml']);
}

if (isset($_POST['idPage'])){
    $myPublisher = new Publisher();
    $myPublisher->readPublisher($_POST['idPage']);
}


class Publisher
{


    public function publisherAction(){
        $view = new View("publisher.back", "publisher");
        $view->assign("title", "Editeur");
    }

    public function savePublisher($dataHtml){
        file_put_contents("../templatesPublisher/test.json", $dataHtml);
    }

    public function readPublisher($idPage){

        if (file_exists("../templatesPublisher/test.json")){
            echo  file_get_contents("../templatesPublisher/test.json");
        }else {
            echo null;
        }
    }
}