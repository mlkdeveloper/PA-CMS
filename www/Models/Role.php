<?php


namespace App\Models;

use App\Core\Database;

class Role extends Database
{

    private $id;
    protected $name;
    protected $roles = 0;
    protected $users = 0;
    protected $customers = 0;
    protected $products = 0;
    protected $categories = 0;
    protected $orders = 0;
    protected $opinions = 0;
    protected $pages = 0;
    protected $settingsCms = 0;
    protected $settingsSite = 0;

    /**
     * @return int
     */
    public function getSettingsCms()
    {
        return $this->settingsCms;
    }

    /**
     * @param int $settingsCms
     */
    public function setSettingsCms($settingsCms)
    {
        $this->settingsCms = $settingsCms;
    }

    /**
     * @return int
     */
    public function getSettingsSite()
    {
        return $this->settingsSite;
    }

    /**
     * @param int $settingsSite
     */
    public function setSettingsSite($settingsSite)
    {
        $this->settingsSite = $settingsSite;
    }


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
        $this->name = htmlspecialchars(trim($name));
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return mixed
     */
    public function getCustomers()
    {
        return $this->customers;
    }

    /**
     * @param mixed $customers
     */
    public function setCustomers($customers)
    {
        $this->customers = $customers;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return mixed
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param mixed $orders
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
    }

    /**
     * @return mixed
     */
    public function getOpinions()
    {
        return $this->opinions;
    }

    /**
     * @param mixed $opinions
     */
    public function setOpinions($opinions)
    {
        $this->opinions = $opinions;
    }

    /**
     * @return mixed
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param mixed $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }


    public function formBuilderRegister(){

        return [

            "inputs"=>[

                "name"=>[
                    "minLength"=>2,
                    "maxLength"=>50,
                    "uniq" => true,
                    "error"=>"Le nom du rôle doit être compris entre 2 et 50 caractères.",
                    "errorUniq"=>"Le nom existe déjà."
                ],
                "role"=>[
                    "value" => 1,
                    "error"=> "Erreur au niveau de la valeur !"
                ],
                "user"=>[
                    "value" => 1,
                    "error"=> "Erreur au niveau de la valeur !"
                ],
                "customer"=>[
                    "value" => 1,
                    "error"=> "Erreur au niveau de la valeur !"
                ],
                "product"=>[
                    "value" => 1,
                    "error"=> "Erreur au niveau de la valeur !"
                ],
                "category"=>[
                    "value" => 1,
                    "error"=> "Erreur au niveau de la valeur !"
                ],
                "order"=>[
                    "value" => 1,
                    "error"=> "Erreur au niveau de la valeur !"
                ],
                "opinion"=>[
                    "value" => 1,
                    "error"=> "Erreur au niveau de la valeur !"
                ],
                "page"=>[
                    "value" => 1,
                    "error"=> "Erreur au niveau de la valeur !"
                ],

                "settingsCms"=>[
                    "value" => 1,
                    "error"=> "Erreur au niveau de la valeur !"
                ],
                "settingsSite"=>[
                    "value" => 1,
                    "error"=> "Erreur au niveau de la valeur !"
                ]
            ]

        ];

    }



}