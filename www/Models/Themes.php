<?php


namespace App\Models;


use App\Core\Database;

class Themes extends Database
{

    protected $id = null;
    protected $name;
    protected $file;
    protected $status;
    protected $admin = 1;

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
        $this->name = htmlspecialchars($name);
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = htmlspecialchars($file);
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
     * @return int
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param int $admin
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    public function formBuilderRegister(){

        return [

            "inputs"=>[

                "name"=>[
                    "minLength"=>2,
                    "maxLength"=>50,
                    "uniq"=>true,
                    "error"=>"Le nom doit être compris entre 2 et 50 caractères.",
                    "errorUniq"=> "Le nom du thème doit être unique !"
                ],
                "file"=>[

                ],

                "status"=>[
                    "status"=> [0,1],
                    "error"=>"Erreur sur le statut."
                ]
            ]

        ];

    }



}