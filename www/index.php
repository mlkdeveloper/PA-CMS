<?php

namespace App;

use App\Core\MyException;
use App\Core\Router;
use App\Core\ConstantManager;

require "Autoload.php";
require "Controllers/Auth.php";
Autoload::register();

new ConstantManager();

$slug = mb_strtolower($_SERVER["REQUEST_URI"]);
$slug = explode("?", $slug);

if ($slug[0] !== '/start-install'){
    $slug[0] = '/';
}

try {
    $route = new Router($slug[0]);
    $route->run();
}catch (MyException $e){
    echo $e->error();
}