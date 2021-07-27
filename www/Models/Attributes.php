<?php


namespace App\Models;


use App\Core\Database;

class Attributes extends Database
{

    private $id;
    protected $name;
    protected $description;

    public function __construct(){
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = trim(htmlspecialchars($name));
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = trim(htmlspecialchars($description));
    }


    public function formBuilderAttribute(){

        return [

            "config"=>[
                "method"=>"POST",
                "action"=>"",
            ],
            "inputs"=>[

                "name"=>[
                    "type"=>"text",
                    "required"=>true,
                    "uniq"=> true,
                    "errorUniq" => "Cet attribut existe déjà !",
                    "error"=>"Le nom doit faire entre 2 et 50 caractères et ne doit pas comporter de caractères spéciaux",
                    "regex"=>"/^[A-Za-z-_]{2,50}$/",
                ],

                "description" => [
                    "type"=>"text",
                    "maxLength"=>255,
                    "error"=>"La description doit être inférieur à 255 caractères."
                ]
            ]
        ];
    }




}