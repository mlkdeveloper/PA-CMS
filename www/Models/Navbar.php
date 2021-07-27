<?php


namespace App\Models;

use App\Core\Database;

class Navbar extends Database
{

    private $id;
    protected $name;
    protected $sort;
    protected $status;
    protected $page;
    protected $category;

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
    public function setId($id): void
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
    public function setName($name): void
    {
        $this->name = htmlspecialchars(trim($name));
    }

    /**
     * @return mixed
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param mixed $sort
     */
    public function setSort($sort): void
    {
        $this->sort = $sort;
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
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page): void
    {
        $this->page = $page;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }



    public function formBuilderRegister(){

        return [
            "inputs"=>[

                "name"=>[
                    "minLength"=>2,
                    "maxLength"=>50,
                    "errorLength"=>"Le nom de l'onglet doit être compris entre 2 et 50 caractères",
                    "errorBdd"=>"Un onglet avec ce nom existe déjà",
                    "uniq"=>true
                ]
            ]
        ];
    }
}