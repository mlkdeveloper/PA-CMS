<?php


namespace App\Controller;

use App\Core\Email;
use App\Core\Database;
use App\Core\Helpers;
use App\Core\View;
use App\Core\FormValidator;

class Commande extends Database
{

    public function listeCommandeAction(){
        $view = new View("commandeList.back", "back");

        $view->assign("title", "Liste des commandes");
    }
}