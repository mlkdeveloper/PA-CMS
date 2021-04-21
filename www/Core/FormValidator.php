<?php
namespace App\Core;

use App\Models\Role;
use App\Models\User;

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



    public static function checkClient($config,$data,$isCreated)
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

                if ($configInputs["type"] === "email"){

                    if(!filter_var($data[$name], FILTER_VALIDATE_EMAIL )){
                        $errors[] = "Email invalide !";
                    }else {
                        if (!$isCreated) {
                            $user = new User();

                            if ($user->find_duplicates_sql($name, $data[$name])){
                                $errors[] = "L'email existe déjà  !";
                            }

                        }
                    }
                }

                if(!empty($configInputs["regex"])
                    && !preg_match($configInputs["regex"],$data[$name])){
                    $errors[] = $configInputs["errorRegex"];
                }

                if(!empty($configInputs["confirm"])
                    && $data[$name] != $data[$configInputs["confirm"]]
                ){
                    $errors[] = $configInputs["error"];
                }

                if (!empty($configInputs["required"])
                    && $configInputs["required"] == true
                    && strlen(trim($data[$name])) <= 0

                ){
                    $errors[] = $configInputs["error"];
                }

            }
        }

        return $errors; //[] vide si ok
    }

    public static function checkFormRole($config,$data,$isCreated){

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

                if (!$isCreated) {
                    if (!empty($configInputs["uniq"]) &&
                        $configInputs["uniq"] === true
                    ) {
                        $role = new Role();
                        if ($role->find_duplicates_sql($name, $data[$name]))
                            $errors[] = $configInputs["errorUniq"];
                    }
                }


            }
        }
        return $errors;
    }

}
