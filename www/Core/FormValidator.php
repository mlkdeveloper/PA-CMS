<?php
namespace App\Core;

class FormValidator
{

    public static function check($config,$data)
    {
        $errors = [];
        $regex =  "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]){8,}/";
        if( count($data) != count($config["inputs"]) ){
            $errors[] = "Tentative de HACK - Faille XSS";

        }else{

            foreach ($config["inputs"] as $name => $configInputs) {


                if(!empty($configInputs["minLength"])
                    && is_numeric($configInputs["minLength"])
                    && strlen($data[$name]) < $configInputs["minLength"]){

                    $errors[] = $configInputs["error"];

                }

                if(!empty($configInputs["maxLength"])
                    && is_numeric($configInputs["maxLength"])
                    && strlen($data[$name]) > $configInputs["maxLength"]){

                    $errors[] = $configInputs["error"];

                }

                if($configInputs["type"] === "password"
                    && !preg_match($regex,$data[$name])
                ){

                    $errors[] = $configInputs["error"];
                }

                if(!empty($configInputs["confirm"])
                    && $data[$name] != $data[$configInputs["confirm"]]
                ){
                    $errors[] = $configInputs["error"];
                }

                if (!empty($configInputs["required"])
                    && $configInputs["required"] == true
                    && strlen($data[$name]) <= 0

                ){
                    $errors[] = $configInputs["error"];
                }

            }
        }

        return $errors; //[] vide si ok
    }

    public static function checkFormRole($config,$data){

        $errors = [];

        if( count($data) < 1 ){
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

                if (!empty($configInputs["value"]) &&
                    isset($data[$name]) &&
                    $data[$name] != $configInputs["value"]
                ){
                    $errors[] = $configInputs["error"];
                }

            }
        }
        return $errors;
    }


    public static function returnValue($data, $statut){

        $message = [];

        if ($data == true && $statut == 1){
            $message = "Utilisateur ajouté !";
        } else if ($data == true && $statut == 2){
            $message = "Utilisateur modifié !";
        } else {
            $message = "Utilisateur supprimé !";
        }


        return $message;
    }
}
