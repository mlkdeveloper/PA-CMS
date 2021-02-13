<?php


namespace App\Models;
use App\Core\Database;

class Category extends Database
{

    private $id = null;
    protected $name;
    protected $description;
    protected $status;
    protected $picPath;



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
        $this->name = $name;
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
        $this->description = $description;
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

    /**
     * @return mixed
     */
    public function getPicPath()
    {
        return $this->picPath;
    }

    /**
     * @param mixed $picPath
     */
    public function setPicPath($picPath)
    {
        $this->picPath = $picPath;
    }





    public function formBuilderRegister(){

        return [

            "inputs"=>[

                "name"=>[
                    "minLength"=>2,
                    "maxLength"=>50,
                    "error"=>"Le nom de la catégorie doit être compris entre 2 et 50 caractères."
                ],
                "description"=>[
                    "minLength"=>0,
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