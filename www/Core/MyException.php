<?php


namespace App\Core;

use App\Core\View;

use Throwable;

class MyException extends \Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function error(){

        $view = new View('errors',"errors");
        $view->assign("message", $this->getMessage());
        $view->assign("status", $this->getCode());
        $view->assign("title", $this->getCode());

    }


}
