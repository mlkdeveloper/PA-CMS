<?php

namespace App\Models;

use App\Core\Database;

class Pages extends Database
{

	private $id = null;
	protected $name;
	protected $createdAt;
	protected $slug;
	protected $publication;
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
        $this->name = htmlspecialchars(trim($name));
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
        $this->slug = htmlspecialchars(trim($slug));
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

    /**
     * @return mixed
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * @param mixed $publication
     */
    public function setPublication($publication): void
    {
        $this->publication = $publication;
    }




    public function formBuilderRegister(){

        return [
            "inputs"=>[

                "name"=>[
                    "regex"=>"/^[a-z-_]{2,50}$/",
                    "errorRegex"=>"Le nom de la page doit être compris entre 2 et 50 caractères"
                ],
                "slug"=>[
                    "errorRegex"=>"Le slug doit être compris entre 2 et 50 caractères et il doit commencer par un /. Les caractères autorisés sont: les lettres de l'alphabet en minuscules ainsi que les caractères - et _",
                    "regex"=>"/^\/[a-z-_]{2,50}$/"
                ]
            ]
        ];
    }
}