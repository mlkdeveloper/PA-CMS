<?php


namespace App\Models;

use App\Core\Database;

class Tab_navbar extends Database
{

    private $id;
    protected $name;
    protected $page;
    protected $category;
    protected $navbar;

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

    /**
     * @return mixed
     */
    public function getNavbar()
    {
        return $this->navbar;
    }

    /**
     * @param mixed $navbar
     */
    public function setNavbar($navbar): void
    {
        $this->navbar = $navbar;
    }


    public function formBuilderRegister(){

        return [
            "inputs"=>[

                "name"=>[
                    "minLength"=>2,
                    "maxLength"=>50,
                    "errorLength"=>"Le nom du sous onglet doit être compris entre 2 et 50 caractères",
                    "errorBdd"=>"Un sous onglet avec ce nom existe déjà",
                    "uniq"=>true
                ]
            ]
        ];
    }
}