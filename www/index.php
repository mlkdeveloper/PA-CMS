<?php

namespace App;

use App\Core\MyException;
use App\Core\Router;
use App\Core\ConstantManager;

require "Autoload.php";
require "Controllers/Auth.php";
Autoload::register();

new ConstantManager();


//require "Core/Router.php";

//On récupère le slug dans la super globale SERVER
//On le transforme en minuscule
$slug = mb_strtolower($_SERVER["REQUEST_URI"]);
$slug = explode("?", $slug);

try {
    $route = new Router($slug[0]);
    $route->run();
}catch (MyException $e){
    echo $e->error();
}

