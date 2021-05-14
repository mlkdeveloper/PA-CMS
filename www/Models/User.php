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
    protected $country = null;
    protected $address = null;
    protected $city = null;
    protected $zipCode = null;
    protected $phoneNumber = null;
    protected $id_role;
    protected $status;

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
    public function setFirstName($firstName)
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
	    $this->pwd = htmlspecialchars($pwd);
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
				"class"=>"form_control col col-md-6 container",
				"id"=>"form_register",
				"submit"=>"Connexion",
                "classButton" => "button button--blue"
			],
			"inputs"=>[

				"email"=>[
								"type"=>"email",
                                "divClass"=> "form_align--top",
								"placeholder"=>"Exemple : nom@gmail.com",
								"label"=>"Votre Email",
								"required"=>true,
								"class"=>"form_input",
								"error"=>"Votre email doit faire entre 8 et 320 caractères"
							],

				"pwd"=>[
								"type"=>"password",
                                "divClass"=> "form_align--top",
                                "placeholder"=>"Saisir votre mot de passe",
								"label"=>"Votre mot de passe",
								"required"=>true,
								"class"=>"form_input",
								"error"=>"Votre mot de passe doit faire au minimum 8 caractères"
							]
			]

		];
	}

	public function formBuilderInstallRegister(){

		return [

			"config"=>[
				"method"=>"POST",
				"action"=>"",
                "class"=>"form_control col col-md-10 container",
				"id"=>"form_register",
				"submit"=>"Terminer l'installation",
                "classButton" => "button button--blue"
			],
			"inputs"=>[
				"firstname"=>[
								"type"=>"text",
								"placeholder"=>"Exemple : Yves",
                                "divClass"=> "form_align--top",
								"label"=>"Votre Prénom",
								"required"=>true,
								"class"=>"input",
								"minLength"=>2,
								"maxLength"=>50,
								"error"=>"Votre prénom doit faire entre 2 et 50 caractères"
							],
				"lastname"=>[
								"type"=>"text",
                                "divClass"=> "form_align--top",
								"placeholder"=>"Exemple : Skrzypczyk",
								"label"=>"Votre Nom",
								"required"=>true,
								"class"=>"input",
								"minLength"=>2,
								"maxLength"=>100,
								"error"=>"Votre nom doit faire entre 2 et 100 caractères"
							],

				"email"=>[
								"type"=>"email",
                                "divClass"=> "form_align--top",
								"placeholder"=>"Exemple : nom@gmail.com",
								"label"=>"Votre Email",
								"required"=>true,
								"class"=>"input",
								"minLength"=>8,
								"maxLength"=>320,
								"error"=>"Votre email doit faire entre 8 et 320 caractères"
							],

				"pwd"=>[
								"type"=>"password",
                                "divClass"=> "form_align--top",
								"label"=>"Votre mot de passe",
								"required"=>true,
								"class"=>"input",
								"minLength"=>8,
								"error"=>"Votre mot de passe doit faire au minimum 8 caractères et il doit contenir une majuscule et un chiffre"
							],

				"pwdConfirm"=>[
								"type"=>"password",
                                "divClass"=> "form_align--top",
								"label"=>"Confirmation",
								"required"=>true,
								"class"=>"input",
								"confirm"=>"pwd",
								"error"=>"Votre mot de passe de confirmation ne correspond pas"
							],

				"country"=>[
								"type"=>"text",
                                "divClass"=> "form_align--top",
								"placeholder"=>"Exemple : fr",
								"label"=>"Votre Pays",
								"required"=>true,
								"class"=>"input",
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
                    "maxLength"=>100,
                    "error"=>"Le nom doit faire entre 2 et 100 caractères."
                ],
                "firstName"=>[
                    "type"=>"text",
                    "placeholder"=>"Prénom",
                    "label"=>"Prénom",
                    "required"=>true,
                    "class"=>"form_input",
                    "minLength"=>2,
                    "maxLength"=>50,
                    "error"=>"Le prénom doit faire entre 2 et 50 caractères."
                ],

                "address"=>[
                    "type"=>"text",
                    "label"=>"Adresse",
                    "placeholder"=>"ex : 29 rue de la liberte",
                    "required"=>true,
                    "class"=>"form_input",
                    "minLength"=>5,
                    "maxLength"=>255,
                    "error"=>"L'adresse doit faire entre 5 et 254 caractères."
                ],
                "city"=>[
                    "type"=>"text",
                    "label"=>"Ville",
                    "placeholder"=>"ex : Paris",
                    "required"=>true,
                    "class"=>"form_input",
                    "minLength"=>2,
                    "maxLength"=>20,
                    "error"=>"La ville doit faire entre 2 et 20 caractères"
                ],
                "zipCode"=>[
                    "type"=>"text",
                    "label"=>"Code postal",
                    "placeholder"=>"ex : 75015",
                    "required"=>true,
                    "class"=>"form_input",
                    "regex" => "/^[0-9]{5}/",
                    "errorRegex" => "Code postal invalide !"
                ],
                "country"=>[
                    "type"=>"text",
                    "label"=>"Pays",
                    "placeholder"=>"ex : fr",
                    "required"=>true,
                    "class"=>"form_input",
                    "minLength"=> 2,
                    "maxLength"=> 2,
                    "error"=>"Le pays doit faire 2 caractères"
                ],
                "email"=>[
                    "type"=>"email",
                    "label"=>"Email",
                    "placeholder"=>"Email",
                    "required"=>true,
                    "class"=>"form_input",
                    "minLength"=>8,
                    "maxLenght"=>320,
                    "error"=>"L'email doit contenir entre 8 et 320 caractères"
                ],
                "phoneNumber"=>[
                    "type"=>"text",
                    "label"=>"N° Telephone",
                    "placeholder"=>"0122334455",
                    "required"=>true,
                    "class"=>"form_input",
                    "regex" => "/^[0-9]{10}/",
                    "errorRegex" => "Numéro de téléphone invalide !"
                ],
            ]

        ];
    }



    public function formUsers(){
        return [

            "config"=>[
                "method"=>"POST",
                "action"=>"",
            ],
            "inputs"=>[

                "lastname"=>[
                    "type"=>"text",
                    "required"=>true,
                    "minLength"=>2,
                    "maxLength"=>100,
                    "error"=>"Le nom doit faire entre 2 et 100 caractères."
                ],
                "firstName"=>[
                    "type"=>"text",
                    "required"=>true,
                    "minLength"=>2,
                    "maxLength"=>50,
                    "error"=>"Le prénom doit faire entre 2 et 50 caractères."
                ],

                "email"=>[
                    "type"=>"email",
                    "required"=>true,
                    "minLength"=>8,
                    "maxLenght"=>320,
                    "error"=>"Votre email doit faire entre 8 et 320 caractères"
                ],

                "pwd"=>[
                    "type"=>"password",
                    "required"=>true,
                    "regex"=>"/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]){8,}/",
                    "errorRegex"=>"Votre mot de passe doit faire au minimum 8 caractères, contenir une majuscule et un chiffre."
                ],

                "idRole"=>[
                    "type"=>"text",
                    "statusRole" => [1,2],
                    "required"=>true,
                    "error"=>"Erreur au niveau du rôle !"
                ]
            ]

        ];
    }

    public function formPwdUsers(){

        return [

            "config"=>[
                "method"=>"POST",
                "action"=>"",
            ],
            "inputs"=>[

                "pwd"=>[
                    "type"=>"password",
                    "required"=>true,
                    "regex"=>"/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]){8,}/",
                    "errorRegex"=>"Votre mot de passe doit faire au minimum 8 caractères, contenir une majuscule et un chiffre."
                ]
            ]
        ];
    }


    public function formUpdateUsers(){

        return [

            "config"=>[
                "method"=>"POST",
                "action"=>"",
            ],
            "inputs"=>[

                "lastname"=>[
                    "type"=>"text",
                    "required"=>true,
                    "minLength"=>2,
                    "maxLength"=>100,
                    "error"=>"Le nom doit faire entre 2 et 100 caractères."
                ],
                "firstName"=>[
                    "type"=>"text",
                    "required"=>true,
                    "minLength"=>2,
                    "maxLength"=>50,
                    "error"=>"Le prénom doit faire entre 2 et 50 caractères."
                ],

                "email"=>[
                    "type"=>"email",
                    "required"=>true,
                    "minLength"=>8,
                    "maxLenght"=>320,
                    "error"=>"Votre email doit faire entre 8 et 320 caractères"
                ],

                "idRole"=>[
                    "type"=>"text",
                    "statusRole" => [1,2],
                    "required"=>true,
                    "error"=>"Erreur au niveau du rôle !"
                ]
            ]

        ];
    }



}









