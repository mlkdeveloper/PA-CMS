<?php


namespace App\Models;


use App\Core\Database;

class Shop extends Database
{
    private $id = null;
    protected $name ;
    protected $address;
    protected $city;
    protected $zipCode;
    protected $phoneNumber;
    protected $description;


    public function __construct(){
        parent::__construct();
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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param mixed $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function formBuilderCreateShop(){
        return [

            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "class"=>"form_control",
                "id"=>"form_register",
                "submit"=>"Enregistrer"
            ],
            "inputs"=>[

                "nom"=>[
                    "type"=>"text",
                    "placeholder"=>"Chez Jacquie",
                    "label"=>"Nom",
                    "required"=>true,
                    "class"=>"form_input",
                    "minLength"=>2,
                    "maxLength"=>320,
                    "error"=>"Le nom doit faire entre 2 et 320 caractères"
                ],

                "address"=>[
                    "type"=>"text",
                    "label"=>"Adresse",
                    "placeholder"=>"ex : 29 rue de la liberte",
                    "required"=>true,
                    "class"=>"form_input",
                    "minLength"=>5,
                    "error"=>"L'adresse doit faire au minimum 5 caractères"
                ],
                "ville"=>[
                    "type"=>"text",
                    "label"=>"Ville",
                    "placeholder"=>"ex : Paris",
                    "required"=>true,
                    "class"=>"form_input",
                    "minLength"=>2,
                    "error"=>"La ville doit faire au minimum 2 caractères"
                ],
                "zipCode"=>[
                    "type"=>"text",
                    "label"=>"Code postal",
                    "placeholder"=>"ex : 75015",
                    "required"=>true,
                    "class"=>"form_input",
                    "minLength"=>2,
                    "error"=>"Le code postal doit faire au 5 caractères"
                ],
                "description"=>[
                    "type"=>"text",
                    "label"=>"Description",
                    "placeholder"=>"Votre description",
                    "required"=>true,
                    "class"=>"form_input",
                    "minLength"=>5,
                    "error"=>"La description doit faire au minimum 5 caractères"
                ],
                "telephone"=>[
                    "type"=>"text",
                    "label"=>"N° Telephone",
                    "placeholder"=>"Numero de telephone",
                    "required"=>true,
                    "class"=>"form_input",
                    "minLength"=>1,
                    "error"=>"le numero de telphone est obligatoire"
                ],
            ]
        ];
    }
}