<?php
namespace App\Core;

class FormValidator
{

	public static function check($config, $data)
	{
		$errors = [];


		if( count($data) != count($config["inputs"]) ){
			$errors[] = "Tentative de HACK - Faille XSS";

		}else{

			foreach ($config["inputs"] as $name => $configInputs) {
				
				if(	!empty($configInputs["minLength"]) 
					&& is_numeric($configInputs["minLength"]) 
					&& strlen($data[$name]) < $configInputs["minLength"]){

					$errors[] = $configInputs["error"];

				}


			}
	}

		return $errors; //[] vide si ok
	}

    public static function checkSlug($data){
	    $errorSlug = [];
        if (!preg_match("/^\/[a-zA-Z-_]+$/", $data)){
            $errorSlug[] = "Le slug doit commencer par un /. Les caractères autorisés sont: les
             lettres de l'alphabet en minuscules et/ou en minuscules ainsi que les caractères - et _";
        }
        return $errorSlug;
    }
}