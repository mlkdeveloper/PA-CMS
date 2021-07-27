<?php

namespace App\Models;

use App\Core\Database;

class User extends Database
{

	private $id = null;
	protected $firstname;
	protected $lastname;
	protected $email;
	protected $pwd;
	protected $country;
	protected $id_role = 1;
	protected $status = 1;
	protected $address;
	protected $city;
	protected $zipcode;
	protected $phoneNumber;
	protected $token;
	protected $isConfirmed = 0;

    /**
     * @return int
     */
    public function getIsConfirmed(): int
    {
        return $this->isConfirmed;
    }

    /**
     * @param int $isConfirmed
     */
    public function setIsConfirmed(int $isConfirmed)
    {
        $this->isConfirmed = $isConfirmed;
    }

    /**
     * @return int
     */
    public function getIdRole(): int
    {
        return $this->id_role;
    }

    /**
     * @param int $id_role
     */
    public function setIdRole(int $id_role)
    {
        $this->id_role = $id_role;
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
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param mixed $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
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
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

	/*
		status
		createdAt
		updatedAt
		isDeleted (hard delete du soft delete) attention au RGPD
	*/


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
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = htmlspecialchars(trim($firstname));
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
								"class"=>"input",
								"error"=>"Votre email doit faire entre 8 et 320 caractères"
							],

				"pwd"=>[
								"type"=>"password",
                                "divClass"=> "form_align--top",
                                "placeholder"=>"Saisir votre mot de passe",
								"label"=>"Votre mot de passe",
								"required"=>true,
								"class"=>"input",
								"error"=>"Votre mot de passe doit faire au minimum 7 caractères"
							]
			]

		];
	}

	public function formBuilderRegister(){

		return [

			"config"=>[
				"method"=>"POST",
				"action"=>"",
                "class"=>"form_control col col-md-6 container",
				"id"=>"form_register",
				"submit"=>"S'inscrire",
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
                                "regex" => "/^[a-zA-Z-\séèàêïî]{2,50}$/",
								"error"=>"Votre prénom doit faire entre 2 et 50 caractères"
							],
				"lastname"=>[
								"type"=>"text",
                                "divClass"=> "form_align--top",
								"placeholder"=>"Exemple : Skrzypczyk",
								"label"=>"Votre Nom",
								"required"=>true,
								"class"=>"input",
                                "regex" => "/^[a-zA-Z-\séèàêïî]{2,100}$/",
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
                                "regex"=>"/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]){8,}/",
								"error"=>"Votre mot de passe doit faire au minimum 8 caractères, contenir une majuscule et un chiffre."
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
			]

		];

	}

    public function formBuilderpwdOublie(){

        return [

            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "class"=>"form_control col col-md-10 container",
                "id"=>"form_register",
                "submit"=>"Envoyer",
                "classButton" => "button button--blue"
            ],
            "inputs"=>[
                "email"=>[
                    "type"=>"text",
                    "placeholder"=>"ex : example@gmail.com",
                    "divClass"=> "form_align--top",
                    "label"=>"Votre email",
                    "required"=>true,
                    "class"=>"input",
                    "minLength"=>8,
                    "maxLength"=>320,
                    "error"=>"Votre email doit faire entre 8 et 320 caractères"
                ],
            ]

        ];

    }

    public function formBuildermodifyPwd(){

        return [

            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "class"=>"form_control col col-md-10 container",
                "id"=>"form_register",
                "submit"=>"Envoyer",
                "classButton" => "button button--blue"
            ],
            "inputs"=>[
                "pwd"=>[
                    "type"=>"password",
                    "divClass"=> "form_align--top",
                    "label"=>"Votre mot de passe",
                    "required"=>true,
                    "class"=>"input",
                    "regex"=>"/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]){8,}/",
                    "error"=>"Votre mot de passe doit faire au minimum 8 caractères, contenir une majuscule et un chiffre."
                ],

                "pwdConfirm"=>[
                    "type"=>"password",
                    "divClass"=> "form_align--top",
                    "label"=>"Confirmation",
                    "required"=>true,
                    "data-format"=> "confirmPwd",
                    "class"=>"input",
                    "confirm"=>"pwd",
                    "error"=>"Mots de passe différents"
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
                    "class"=>"input",
                    "regex" => "/^[a-zA-Z-\séèàêïî]{2,100}$/",
                    "error"=>"Le nom doit faire entre 2 et 100 caractères."
                ],
                "firstName"=>[
                    "type"=>"text",
                    "placeholder"=>"Prénom",
                    "label"=>"Prénom",
                    "required"=>true,
                    "class"=>"input",
                    "regex" => "/^[a-zA-Z-\séèàêïî]{2,50}$/",
                    "error"=>"Le prénom doit faire entre 2 et 50 caractères."
                ],

                "address"=>[
                    "type"=>"text",
                    "label"=>"Adresse",
                    "placeholder"=>"ex : 29 rue de la liberte",
                    "required"=>true,
                    "class"=>"input",
                    "regex" => "/^[0-9a-zA-Z-\séèàêïî]{2,150}$/",
                    "error"=>"L'adresse doit faire entre 5 et 150 caractères."
                ],
                "city"=>[
                    "type"=>"text",
                    "label"=>"Ville",
                    "placeholder"=>"ex : Paris",
                    "required"=>true,
                    "class"=>"input",
                    "regex" => "/^[a-zA-Z-\séèàêïî]{2,80}$/",
                    "error"=>"La ville doit faire entre 2 et 80 caractères"
                ],
                "zipCode"=>[
                    "type"=>"text",
                    "label"=>"Code postal",
                    "placeholder"=>"ex : 75015",
                    "required"=>true,
                    "class"=>"input",
                    "regex" => "/^[0-9]{5}$/",
                    "error" => "Code postal invalide !"
                ],
                "country"=>[
                    "type"=>"text",
                    "label"=>"Pays",
                    "placeholder"=>"ex : fr",
                    "required"=>true,
                    "class"=>"input",
                    "regex" => "/^[a-zA-Z]{2,2}$/",
                    "error"=>"Le pays doit faire 2 caractères"
                ],
                "email"=>[
                    "type"=>"email",
                    "label"=>"Email",
                    "placeholder"=>"Email",
                    "required"=>true,
                    "class"=>"input",
                    "minLength"=>8,
                    "maxLenght"=>320,
                    "error"=>"L'email doit contenir entre 8 et 320 caractères"
                ],
                "phoneNumber"=>[
                    "type"=>"text",
                    "label"=>"N° Telephone",
                    "placeholder"=>"0122334455",
                    "required"=>true,
                    "class"=>"input",
                    "regex" => "/^0[0-9]{9}$/",
                    "error" => "Numéro de téléphone invalide !"
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
                    "regex" => "/^[a-zA-Z-\séèàêïî]{2,100}$/",
                    "error"=>"Le nom doit faire entre 2 et 100 caractères."
                ],
                "firstName"=>[
                    "type"=>"text",
                    "required"=>true,
                    "regex" => "/^[a-zA-Z-\séèàêïî]{2,50}$/",
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
                    "error"=>"Votre mot de passe doit faire au minimum 8 caractères, contenir une majuscule et un chiffre."
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
                    "regex" => "/^[a-zA-Z-\séèàêïî]{2,100}$/",
                    "error"=>"Le nom doit faire entre 2 et 100 caractères."
                ],
                "firstName"=>[
                    "type"=>"text",
                    "required"=>true,
                    "regex" => "/^[a-zA-Z-\séèàêïî]{2,50}$/",
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

    public function formBuilderInstallRegister(){

        return [

            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "class"=>"form_control",
                "id"=>"form_register",
                "submit"=>"Terminer l'installation",
                "classButton" => "button button--blue"
            ],
            "inputs"=>[
                "firstname"=>[
                    "type"=>"text",
                    "divClass"=> "form_align--top",
                    "placeholder"=>"Exemple : Yves",
                    "label"=>"Prénom",
                    "required"=>true,
                    "class"=>"input",
                    "value"=>"Yves",
                    "regex" => "/^[a-zA-Z-\séèàêïî]{2,50}$/",
                    "error"=>"Votre prénom doit faire entre 2 et 50 caractères"
                ],
                "lastname"=>[
                    "type"=>"text",
                    "divClass"=> "form_align--top",
                    "placeholder"=>"Exemple : Skrzypczyk",
                    "value"=>"Skrzypczyk",
                    "label"=>"Nom",
                    "required"=>true,
                    "class"=>"input",
                    "regex" => "/^[a-zA-Z-\séèàêïî]{2,100}$/",
                    "error"=>"Votre nom doit faire entre 2 et 100 caractères"
                ],

                "email"=>[
                    "type"=>"email",
                    "divClass"=> "form_align--top",
                    "placeholder"=>"Exemple : nom@gmail.com",
                    "label"=>"Email",
                    "value"=>"admin@gmail.com",
                    "required"=>true,
                    "class"=>"input",
                    "minLength"=>8,
                    "maxLength"=>320,
                    "error"=>"Votre email doit faire entre 8 et 320 caractères"
                ],

                "pwd"=>[
                    "type"=>"password",
                    "divClass"=> "form_align--top",
                    "label"=>"Mot de passe",
                    "required"=>true,
                    "class"=>"input",
                    "value"=>"Waseem6",
                    "regex"=>"/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]){8,}/",
                    "error"=>"Votre mot de passe doit faire au minimum 8 caractères, contenir une majuscule et un chiffre."
                ],
                "pwdConfirm"=>[
                    "type"=>"password",
                    "divClass"=> "form_align--top",
                    "label"=>"Confirmation",
                    "required"=>true,
                    "class"=>"input",
                    "value"=>"Waseem6",
                    "confirm"=>"pwd",
                    "error"=>"Votre mot de passe de confirmation ne correspond pas"
                ],
            ]

        ];

    }

}









