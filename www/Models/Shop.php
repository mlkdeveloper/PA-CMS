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




    public function formBuilderCreateShop(){
        return [

            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "class"=>"form_control",
                "id"=>"form_register",
                "submit"=>"Continuer",
                "classButton" => "button button--blue"
            ],
            "inputs"=>[

                "nom"=>[
                    "type"=>"text",
                    "placeholder"=>"",
                    "divClass"=> "form_align--top",
                    "value"=> "",
                    "label"=>"Nom",
                    "required"=>true,
                    "class"=>"input",
                    "minLength"=>2,
                    "maxLength"=>320,
                    "error"=>"Le nom doit faire entre 2 et 320 caractères"
                ],

                "address"=>[
                    "type"=>"text",
                    "value"=> "",
                    "label"=>"Adresse",
                    "divClass"=> "form_align--top",
                    "placeholder"=>"",
                    "required"=>true,
                    "class"=>"input",
                    "minLength"=>5,
                    "error"=>"L'adresse doit faire au minimum 5 caractères"
                ],
                "ville"=>[
                    "type"=>"text",
                    "label"=>"Ville",
                    "value"=> "",
                    "divClass"=> "form_align--top",
                    "placeholder"=>"",
                    "required"=>true,
                    "class"=>"input",
                    "minLength"=>2,
                    "error"=>"La ville doit faire au minimum 2 caractères"
                ],
                "zipCode"=>[
                    "type"=>"text",
                    "label"=>"Code postal",
                    "value"=> "",
                    "divClass"=> "form_align--top",
                    "placeholder"=>"",
                    "required"=>true,
                    "class"=>"input",
                    "minLength"=>2,
                    "error"=>"Le code postal doit faire au 5 caractères"
                ],
                "telephone"=>[
                    "type"=>"text",
                    "label"=>"N° Telephone",
                    "value"=> "",
                    "divClass"=> "form_align--top",
                    "placeholder"=>"",
                    "required"=>true,
                    "class"=>"input",
                    "data-format"=>"telephone",
                    "minLength"=>1,
                    "error"=>"le numero de telephone est obligatoire et doit être uniquement être composé de chiffres"
                ],
                "description"=>[
                    "type"=>"text",
                    "label"=>"Description",
                    "value"=> "",
                    "divClass"=> "form_align--top",
                    "placeholder"=>"",
                    "required"=>true,
                    "class"=>"input input--textarea",
                    "minLength"=>5,
                    "error"=>"La description doit faire au minimum 5 caractères"
                ],
            ]
        ];
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
                    "maxLength"=>320,
                    "error"=>"Le nom doit faire entre 2 et 320 caractères"
                ],

                "address"=>[
                    "type"=>"text",
                    "value"=>$values['address'],
                    "label"=>"Adresse",
                    "divClass"=> "form_align--top",
                    "placeholder"=>"ex : 29 rue de la liberte",
                    "required"=>true,
                    "class"=>"input",
                    "minLength"=>5,
                    "error"=>"L'adresse doit faire au minimum 5 caractères"
                ],
                "ville"=>[
                    "type"=>"text",
                    "label"=>"Ville",
                    "value"=>$values['city'],
                    "divClass"=> "form_align--top",
                    "placeholder"=>"ex : Paris",
                    "required"=>true,
                    "class"=>"input",
                    "minLength"=>2,
                    "error"=>"La ville doit faire au minimum 2 caractères"
                ],
                "zipCode"=>[
                    "type"=>"text",
                    "label"=>"Code postal",
                    "value"=>$values['zipCode'],
                    "divClass"=> "form_align--top",
                    "placeholder"=>"ex : 75015",
                    "required"=>true,
                    "class"=>"input",
                    "minLength"=>2,
                    "error"=>"Le code postal doit faire au 5 caractères"
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
                    "minLength"=>1,
                    "error"=>"le numero de telephone est obligatoire et doit être uniquement être composé de chiffres"
                ],
                "description"=>[
                    "type"=>"text",
                    "label"=>"Description",
                    "value"=>$values['description'],
                    "divClass"=> "form_align--top",
                    "placeholder"=>"Votre description",
                    "required"=>true,
                    "class"=>"input input--textarea",
                    "minLength"=>5,
                    "error"=>"La description doit faire au minimum 5 caractères"
                ],
            ]
        ];
    }
}