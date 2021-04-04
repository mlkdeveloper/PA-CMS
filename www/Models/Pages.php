<?php

namespace App\Models;

use App\Core\Database;

class Pages extends Database
{

	private $id = null;
	protected $name;
	protected $createdAt;
	protected $slug;
	protected $User_id;

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
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->User_id;
    }

    /**
     * @param mixed $User_id
     */
    public function setUserId($User_id)
    {
        $this->User_id = $User_id;
    }



    public function formBuilderRegister(){

        return [
            "inputs"=>[

                "name"=>[
                    "minLength"=>2,
                    "maxLength"=>50,
                    "errorLength"=>"Le nom de la page doit être compris entre 2 et 50 caractères."
                ],
                "slug"=>[
                    "errorRegex"=>"Le slug doit être compris entre 2 et 50 caractères et il doit commencer par un /. Les caractères autorisés sont: les lettres de l'alphabet en minuscules et/ou en minuscules ainsi que les caractères - et _",
                    "regex"=>"/^\/[a-zA-Z-_]{2,50}$/"
                ]
            ]
        ];
    }
}