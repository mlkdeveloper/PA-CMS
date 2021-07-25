<?php


namespace App\Models;
use App\Core\Database;

class Category extends Database
{

    private $id = null;
    protected $name;
    protected $description;
    protected $status;



    public function __construct(){
        parent::__construct();
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
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
        $this->name = htmlspecialchars(trim($name));
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
        $this->description = htmlspecialchars(trim($description));
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }



    public function formBuilderRegister(){

        return [

            "inputs"=>[

                "name"=>[
                    "uniq"=>true,
                    "error"=>"Le nom de la catégorie doit être compris entre 2 et 50 caractères et ne doit pas comporter de caractères spéciaux.",
                    "errorUniq"=> "Cette catégorie existe déjà !",
                    "regex"=>"/^[A-Za-z-_]{2,50}$/",
                ],
                "description"=>[
                    "maxLength"=>255,
                    "error"=>"La description doit être inférieur à 255 caractères."
                ],

                "status"=>[
                    "status"=> [0,1],
                    "error"=>"Erreur sur le statut."
                ]
            ]

        ];

    }

}