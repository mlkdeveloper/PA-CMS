<?php

namespace App;

use App\Core\MyException;
use App\Core\Router;
use App\Core\ConstantManager;

require "PHPMailer/src/SMTP.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/Exception.php";
require "Autoload.php";
Autoload::register();

new ConstantManager();

$slug = mb_strtolower($_SERVER["REQUEST_URI"]);
$slug = explode("?", $slug);

if ($slug[0] !== '/start-install' && $slug[0] !== '/'){
    header('Location: /');
    exit();
}

try {
    $route = new Router($slug[0]);
    $route->run();
}catch (MyException $e){
    echo $e->error();
}