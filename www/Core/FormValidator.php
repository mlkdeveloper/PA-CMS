<?php
namespace App\Core;

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


	public static function checkFormCategory($config,$data,$files){

        $errors = [];


        if( count($data) != count($config["inputs"]) ){
            $errors[] = "Tentative de HACK - Faille XSS";

        }else {

            if($files["categoryImage"]["error"] === 0 ){
                $errors = self::checkImage($files);
            }

            foreach ($config["inputs"] as $name => $configInputs) {

                if (!empty($configInputs["minLength"])
                    && is_numeric($configInputs["minLength"])
                    && strlen($data[$name]) < $configInputs["minLength"]) {

                    $errors[] = $configInputs["error"];

                }
                if (!empty($configInputs["maxLength"])
                    && is_numeric($configInputs["maxLength"])
                    && strlen($data[$name]) > $configInputs["maxLength"]) {

                    $errors[] = $configInputs["error"];

                }

                if (!empty($configInputs["status"])
                    && !in_array($data[$name], $configInputs["status"])) {

                    $errors[] = $configInputs["error"];

                }

            }
        }
        return $errors;
    }

    public static function checkImage($files){

        $errors = [];
        $acceptedImage = ["png", "jpeg","jpg"];
        $fileName = $files['categoryImage']['name'];
        $fileSize = $files['categoryImage']['size'];
        $fileExtExploded = explode('.', $fileName);
        $fileExt = strtolower(end($fileExtExploded));

        if(!in_array($fileExt,$acceptedImage)){
            $errors[] = "Extensions .png, .jpeg, .jpg seulement autorisées.";
        }

        if ($fileSize > 15000000) {
            $errors[] = "Le poids de l'image doit être inférieure à 15 MO.";
        }


	    return $errors;
    }


}