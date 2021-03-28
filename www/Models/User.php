<?php

namespace App\Models;

use App\Core\Database;

class User extends Database
{

    private $id = null;
    protected $firstName;
    protected $lastname;
    protected $email;
    protected $pwd;
    protected $country;
    protected $address;
    protected $city;
    protected $zipCode;
    protected $phoneNumber;
    protected $createdAt;
    protected $id_role;
    protected $status;
    protected $isDeleted = 0;


	public function __construct(){
		parent::__construct();
	}

	//Parse error: syntax error, unexpected 'return' (T_RETURN) in /var/www/html/Models/User.php on line 41

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

	    //ON doit peupler (populate) l'objet avec les valeurs de la bdd ...

	}

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = htmlspecialchars(trim($firstName));
    }


	/**
	 * @param mixed $lastname
	 */
	public function setLastname($lastname)
	{
	    $this->lastname = htmlspecialchars(trim($lastname));
	}
	/**
	 * @return mixed
	 */
	public function getEmail()
	{
	    return $this->email;
	}
	/**
	 * @param mixed $email
	 */
	public function setEmail($email)
	{
	    $this->email = htmlspecialchars(trim($email));
	}
	/**
	 * @return mixed
	 */
	public function getPwd()
	{
	    return $this->pwd;
	}
	/**
	 * @param mixed $pwd
	 */
	public function setPwd($pwd)
	{
	    $this->pwd = htmlspecialchars(trim($pwd));
	}
	/**
	 * @return mixed
	 */
	public function getCountry()
	{
	    return $this->country;
	}
	/**
	 * @param mixed $country
	 */
	public function setCountry($country)
	{
	    $this->country = htmlspecialchars(trim($country));
	}
	/**
	 * @return int
	 */
	public function getRole()
	{
	    return $this->role;
	}
	/**
	 * @param int $role
	 */
	public function setRole(int $role)
	{
	    $this->role = $role;
	}
	/**
	 * @return int
	 */
	public function getStatus()
	{
	    return $this->status;
	}
	/**
	 * @param int $status
	 */
	public function setStatus(int $status)
	{
	    $this->status = $status;
	}
	/**
	 * @return int
	 */
	public function getIsDeleted()
	{
	    return $this->isDeleted;
	}
	/**
	 * @param int $isDeleted
	 */
	public function setIsDeleted(int $isDeleted)
	{
	    $this->isDeleted = $isDeleted;
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
    public function setAddress($address): void
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
    public function setCity($city): void
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
    public function setZipCode($zipCode): void
    {
        $this->zipCode = htmlspecialchars(trim($zipCode));
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
    public function setPhoneNumber($phoneNumber): void
    {
        $this->phoneNumber = htmlspecialchars(trim($phoneNumber));
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
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getIdRole()
    {
        return $this->id_role;
    }

    /**
     * @param mixed $id_role
     */
    public function setIdRole($id_role): void
    {
        $this->id_role = $id_role;
    }


	public function formBuilderLogin(){
		return [

			"config"=>[
				"method"=>"POST",
				"action"=>"",
				"class"=>"form_control",
				"id"=>"form_register",
				"submit"=>"S'inscrire"
			],
			"inputs"=>[

				"email"=>[
								"type"=>"email",
								"placeholder"=>"Exemple : nom@gmail.com",
								"label"=>"Votre Email",
								"required"=>true,
								"class"=>"form_input",
								"minLength"=>8,
								"maxLength"=>320,
								"error"=>"Votre email doit faire entre 8 et 320 caractères"
							],

				"pwd"=>[
								"type"=>"password",
								"label"=>"Votre mot de passe",
								"required"=>true,
								"class"=>"form_input",
								"minLength"=>8,
								"error"=>"Votre mot de passe doit faire au minimum 8 caractères"
							]
			]

		];
	}

	public function formBuilderRegister(){

		return [

			"config"=>[
				"method"=>"POST",
				"action"=>"",
				"class"=>"form_control",
				"id"=>"form_register",
				"submit"=>"S'inscrire"
			],
			"inputs"=>[
				"firstname"=>[
								"type"=>"text",
								"placeholder"=>"Exemple : Yves",
								"label"=>"Votre Prénom",
								"required"=>true,
								"class"=>"form_input",
								"minLength"=>2,
								"maxLength"=>50,
								"error"=>"Votre prénom doit faire entre 2 et 50 caractères"
							],
				"lastname"=>[
								"type"=>"text",
								"placeholder"=>"Exemple : Skrzypczyk",
								"label"=>"Votre Nom",
								"required"=>true,
								"class"=>"form_input",
								"minLength"=>2,
								"maxLength"=>100,
								"error"=>"Votre nom doit faire entre 2 et 100 caractères"
							],

				"email"=>[
								"type"=>"email",
								"placeholder"=>"Exemple : nom@gmail.com",
								"label"=>"Votre Email",
								"required"=>true,
								"class"=>"form_input",
								"minLength"=>8,
								"maxLength"=>320,
								"error"=>"Votre email doit faire entre 8 et 320 caractères"
							],

				"pwd"=>[
								"type"=>"password",
								"label"=>"Votre mot de passe",
								"required"=>true,
								"class"=>"form_input",
								"minLength"=>8,
								"error"=>"Votre mot de passe doit faire au minimum 8 caractères et une maj avec un nbr numérique"
							],

				"pwdConfirm"=>[
								"type"=>"password",
								"label"=>"Confirmation",
								"required"=>true,
								"class"=>"form_input",
								"confirm"=>"pwd",
								"error"=>"Votre mot de passe de confirmation ne correspond pas"
							],

				"country"=>[
								"type"=>"text",
								"placeholder"=>"Exemple : fr",
								"label"=>"Votre Pays",
								"required"=>true,
								"class"=>"form_input",
								"minLength"=>2,
								"maxLength"=>2,
								"error"=>"Votre pays doit faire 2 caractères"
							],
			]

		];

	}

    public function formBuilderCreateClient(){
        return [

            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "class"=>"",
                "id"=>"form_create_client",
                "submit"=>"Créer"
            ],
            "inputs"=>[
                "lastName"=>[
                    "type"=>"text",
                    "placeholder"=>"Nom",
                    "label"=>"Nom",
                    "required"=>true,
                    "class"=>"form_input",
                    "minLength"=>2,
                    "maxLength"=>320,
                    "error"=>"Le nom doit faire entre 2 et 320 caractères"
                ],
                "firstName"=>[
                    "type"=>"text",
                    "placeholder"=>"Prénom",
                    "label"=>"Prénom",
                    "required"=>true,
                    "class"=>"form_input",
                    "minLength"=>2,
                    "maxLength"=>320,
                    "error"=>"Le prénom doit faire entre 2 et 320 caractères"
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
                "city"=>[
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
                "country"=>[
                    "type"=>"text",
                    "label"=>"Pays",
                    "placeholder"=>"ex : France",
                    "required"=>true,
                    "class"=>"form_input",
                    "minLength"=> 2,
                    "error"=>"Le code postal doit faire au 2 caractères"
                ],
                "email"=>[
                    "type"=>"text",
                    "label"=>"Email",
                    "placeholder"=>"Email",
                    "required"=>true,
                    "class"=>"form_input",
                    "minLength"=>5,
                    "maxLenght"=>254,
                    "error"=>"L'adresse mail doit contenir entre 5 et 254 caractères"
                ],
                "phoneNumber"=>[
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









