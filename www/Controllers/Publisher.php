<?php
namespace App\Controller;

use App\Core\View;

if (isset($_POST['dataHtml'])){
    $myPublisher = new Publisher();
    $myPublisher->savePublisher($_POST['dataHtml']);
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
}