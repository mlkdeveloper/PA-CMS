<?php
namespace App\Core;

use App\Models\Pages;

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

    public static function checkPage($config, $data){

        $errors = [];


        if( count($data) != count($config["inputs"]) ){
            $errors[] = "Tentative de HACK - Faille XSS";
        }else{

            foreach ($config["inputs"] as $name => $configInputs) {

                if (!empty($configInputs["uniq"]) && $configInputs["uniq"] === true){
                    $page = new Pages();
                    if ($page->find_duplicates_sql($name, $data[$name])){
                        $errors[] = $configInputs["errorBdd"];
                    }
                }

                if(	!empty($configInputs["minLength"])
                    && is_numeric($configInputs["minLength"])
                    && strlen($data[$name]) < $configInputs["minLength"]){

                    $errors[] = $configInputs["errorLength"];
                }

                if(	!empty($configInputs["maxLength"])
                    && is_numeric($configInputs["maxLength"])
                    && strlen($data[$name]) > $configInputs["maxLength"]){

                    $errors[] = $configInputs["errorLength"];
                }

                if (!empty($configInputs["regex"])
                    && !preg_match($configInputs["regex"], $data[$name])){
                    $errors[] = $configInputs["errorRegex"];
                }
            }
        }
        return $errors;
    }
}