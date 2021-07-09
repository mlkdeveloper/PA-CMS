<?php

namespace App\Core;


class Uploader{


    private $name;
    private $destination;

    public function __construct($name)
    {
        $this->name = $name;
    }

}
