<?php


namespace App\Models;

use App\Core\Database;

class Products extends Database
{
    private $id = null;
    protected $name ;
    protected $description;
    protected $status;
    protected $Category_id;
}