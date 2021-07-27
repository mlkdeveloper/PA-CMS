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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = htmlspecialchars(trim($address));
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
        $this->city = htmlspecialchars(trim($city));
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


    public function formBuilderUpdateShop($values){
        return [

            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "class"=>"form_control",
                "id"=>"form_register",
                "submit"=>"Enregistrer",
                "classButton" => "button button--blue"
            ],
            "inputs"=>[

                "nom"=>[
                    "type"=>"text",
                    "placeholder"=>"Chez Jacquie",
                    "divClass"=> "form_align--top",
                    "value"=>$values['name'],
                    "label"=>"Nom",
                    "required"=>true,
                    "class"=>"input",
                    "minLength"=>2,
                    "maxLength"=>255,
                    "error"=>"Le nom du magasin doit faire entre 2 et 255 caractères"
                ],

                "address"=>[
                    "type"=>"text",
                    "value"=>$values['address'],
                    "label"=>"Adresse",
                    "divClass"=> "form_align--top",
                    "placeholder"=>"ex : 29 rue de la liberte",
                    "required"=>true,
                    "class"=>"input",
                    "regex" => "/^[0-9a-zA-Z-\séèàêïî]{2,150}$/",
                    "error"=>"L'adresse doit faire entre 2 et 150 caractères. Attention aux caractères spéciaux !"
                ],
                "ville"=>[
                    "type"=>"text",
                    "label"=>"Ville",
                    "value"=>$values['city'],
                    "divClass"=> "form_align--top",
                    "placeholder"=>"ex : Paris",
                    "required"=>true,
                    "class"=>"input",
                    "regex" => "/^[a-zA-Z-\séèàêïî]{2,80}$/",
                    "error"=>"La ville doit faire entre 2 et 80 caractères"
                ],
                "zipCode"=>[
                    "type"=>"text",
                    "label"=>"Code postal",
                    "value"=>$values['zipCode'],
                    "divClass"=> "form_align--top",
                    "placeholder"=>"ex : 75015",
                    "required"=>true,
                    "class"=>"input",
                    "regex" => "/^[0-9]{5}$/",
                    "error" => "Code postal invalide !"
                ],
                "telephone"=>[
                    "type"=>"text",
                    "label"=>"N° Telephone",
                    "value"=>$values['phoneNumber'],
                    "divClass"=> "form_align--top",
                    "placeholder"=>"Numero de telephone",
                    "required"=>true,
                    "class"=>"input",
                    "data-format"=>"telephone",
                    "regex" => "/^0[0-9]{9}$/",
                    "error" => "Numéro de téléphone invalide !"
                ],
                "description"=>[
                    "type"=>"text",
                    "label"=>"Description",
                    "value"=>$values['description'],
                    "divClass"=> "form_align--top",
                    "placeholder"=>"Votre description",
                    "required"=>true,
                    "class"=>"input input--textarea",
                    "maxLength"=>255,
                    "error"=>"La description doit être inférieur à 255 caractères."
                ],
            ]
        ];
    }


}