<?php


namespace App\Controller;

class Auth
{
    //method de connexion
    public function isConnected(){
        if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            $connected = true;
        }else {
            $connected = false;
        }
        return $connected;
    }
}