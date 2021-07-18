<?php
namespace App\Core;
use App\Models\Category;

use App\Models\Attributes;
use App\Models\Products;
use App\Models\Role;
use App\Models\User;

class FormValidator
{


    public static function check($config,$data)
    {
        $errors = [];
        $regex =  "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]){7,}/";
        $regex_telephone = "/(0|\\+33|0033)[1-9][0-9]{8}/";
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

                if(!empty($configInputs["data-format"])
                    && $configInputs["data-format"] === "telephone"
                    && !preg_match($regex_telephone,$data[$name])
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

    public static function checkFormAttribute($config,$data,$class,$isCreated){

        $errors = [];

        if( count($data) < count($config["inputs"]) ){
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
                if (!$isCreated) {
                    if (!empty($configInputs["uniq"]) &&
                        $configInputs["uniq"] === true
                    ) {

                        if ($class->find_duplicates_sql($name, $data[$name]))
                            $errors[] = $configInputs["errorUniq"];


                    }
                }
            }
        }
        return $errors;
    }

    static function checkProduct1($class, $name, $category, $categories, $type, $fdq = true ){
        $errors = [];

        if ($class->find_duplicates_sql("name", $name) && $fdq) {
            $errors[] = "Le produit existe déjà"; 
        }

        if (
            strlen($name) < 2 ||
            strlen($name) > 50 
        ) {
            $errors[] = "Le produit doit avoir un nom entre 2 et 50 caractères, sans caractères spéciaux ni numérique";
        }

        if(!in_array($type, [0,1])) {
            $errors[] = "Le produit doit avoir un type connu";
        }

        if($type != 1){
            $errors[] = "Problème avec le type du produit";
        }

        if(!in_array($category, $categories)){
            $errors[] = "La catégorie n'existe pas";
        }

        if(isset($_GET["id"]))
            if (!$class->find_duplicates_sql_id("id", $_GET["id"], $name)) {
                $errors[] = "Le produit existe déjà";
            }


        return $errors;
    }


    public static function checkProduct2($products, $categories, $variants, $class, $terms)
    {
        $errors = self::checkProduct1($class, $products["name"], $products["idCategory"], $categories, $products["type"] );

        foreach($variants as $key => $value){
            $prix = $value[count($value)-1];
            $stock = $value[count($value)-2];
            
            if ( $prix <= 0 
                && empty($prix)
                && !is_float($prix)
            ){
                $errors[] = "Le prix de la variante #$key doit être saisi correctement"; 
            }
            
            if($stock <= 0 
                && empty($stock)
                && !is_int($stock) && is_numeric($stock)
            ){
                $errors[] = "Le stock de la variante #$key doit être saisi correctement";
            }   

            unset($value[count($value)-1], $value[count($value)-1]);

            foreach($value as $k => $v)
                if(!in_array($v, $terms)){
                        $errors[] = "Un problème est apparu dans la variante #$key du produit !";
                        break;
                }
        }
        

        return $errors; //[] vide si ok
    }


    public static function checkProductUpdate($products, $categories, $variants, $class, $terms)
    {    


        $errors = self::checkProduct1($class, $products["name"], $products["idCategory"], $categories, $products["type"], false);

        foreach($variants as $key => $value){
            $prix = $value[count($value)-1];
            $stock = $value[count($value)-2];
            
            if ( $prix <= 0 
                || empty($prix)
                && !is_numeric($prix)
            ){
                $errors[] = "Le prix de la variante #$key+1 doit être saisi correctement.";
            }
            
            if($stock <= 0 
                || empty($stock)
                && !is_numeric($stock)
            ){
                $errors[] = "Le stock de la variante #$key+1 doit être saisi.";
            }   

            unset($value[count($value)-1], $value[count($value)-1]);

            foreach($value as $k => $v)
                if(!in_array($v, $terms)){
                    $errors[] = "Un problème est apparu dans la variante #$key du produit !";
                    break;
                }
        }
        

        return $errors; //[] vide si ok
    }

    static function checkGroup($stock, $prix){
        $errors = [];
        if($stock < 0 
            || empty($stock)
            && !is_numeric($stock)
        ){
            $errors[] = "Le stock de la variante n'est pas correct";
        }

        if ( $prix <= 0 
                || empty($prix)
                && !is_numeric($prix)
            ){
            $errors[] = "Le prix de la variante n'est pas correct";
        }   
        return $errors;
    }

    static function checkId($id, $class){
        $check = $class
            ->select("id")
            ->where("id = :id", "status = 1")->setParams(["id" => $id])
            ->get();

        if (empty($check)) return false;
        else return true;
    }

}

