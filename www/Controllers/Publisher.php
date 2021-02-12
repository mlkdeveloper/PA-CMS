<?php
namespace App\Controller;

use App\Core\View;


class Publisher
{


    public function publisherAction(){
        $view = new View("publisher.back", "publisher");
        $view->assign("title", "Editeur");
    }
}