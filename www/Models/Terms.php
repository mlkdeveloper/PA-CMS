<?php


namespace App\Models;


use App\Core\Database;

class Terms extends Database
{

    private $id;
    protected $name;
    protected $idAttributes;

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
    public function getIdAttributes()
    {
        return $this->idAttributes;
    }

    /**
     * @param mixed $idAttributes
     */
    public function setIdAttributes($idAttributes)
    {
        $this->idAttributes = $idAttributes;
    }




    public function formBuilderTerm(){

        return [

            "config"=>[
                "method"=>"POST",
                "action"=>"",
            ],
            "inputs"=>[

                "name"=>[
                    "type"=>"text",
                    "required"=>true,
                    "error"=>"Le nom doit faire entre 1 et 30 caractères et ne doit pas comporter de caractères spéciaux",
                    "regex"=>"/^[0-9A-Za-z-_]{1,30}$/",
                ]
            ]
        ];
    }


}