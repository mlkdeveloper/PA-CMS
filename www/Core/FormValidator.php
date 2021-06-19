<?php
namespace App\Core;
use App\Models\Category;

class FormValidator
{

	public static function check($config,$data)
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


	public static function checkFormCategory($config,$data,$isUpdated){

        $errors = [];

        if( count($data) != count($config["inputs"]) ){
            $errors[] = "Tentative de HACK - Faille XSS";
        }else {


            foreach ($config["inputs"] as $name => $configInputs) {

                if (!empty($configInputs["minLength"])
                    && is_numeric($configInputs["minLength"])
                    && strlen(trim($data[$name])) < $configInputs["minLength"]) {

                    $errors[] = $configInputs["error"];
                }

                if (!empty($configInputs["maxLength"])
                    && is_numeric($configInputs["maxLength"])
                    && strlen(trim($data[$name])) > $configInputs["maxLength"]) {

                    $errors[] = $configInputs["error"];
                }

                if (!$isUpdated) {
                    if (!empty($configInputs["uniq"]) &&
                        $configInputs["uniq"] === true
                    ) {
                        $category = new Category();
                        if ($category->find_duplicates_sql($name, $data[$name]))
                            $errors[] = $configInputs["errorUniq"];
                    }
                }

                if (!empty($configInputs["status"])
                    && !in_array($data[$name], $configInputs["status"])) {

                    $errors[] = $configInputs["error"];
                }
            }
        }
        return $errors;
    }




}