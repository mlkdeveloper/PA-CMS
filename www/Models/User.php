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
	protected $role = 0;
	protected $status = 1;
	protected $isDeleted = 0;

	/*
		role
		status
		createdAt
		updatedAt
		isDeleted (hard delete du soft delete) attention au RGPD
	*/


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
	public function getFirstname()
	{
	    return $this->firstname;
	}
	/**
	 * @param mixed $firstname
	 */
	public function setFirstname($firstname)
	{
	    $this->firstname = $firstname;
	}

	/**
	 * @return mixed
	 */
	public function getLastname()
	{
	    return $this->lastname;
	}
	/**
	 * @param mixed $lastname
	 */
	public function setLastname($lastname)
	{
	    $this->lastname = $lastname;
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
	    $this->email = $email;
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
	    $this->pwd = $pwd;
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
	    $this->country = $country;
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
								"error"=>"Votre mot de passe doit faire au minimum 8 caractères"
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

}









