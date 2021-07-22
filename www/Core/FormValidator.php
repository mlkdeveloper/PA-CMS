<?php
namespace App\Core;


use App\Models\Category as modelCategory;
use App\Models\Navbar;
use App\Models\Pages as modelPages;
use App\Models\Role;
use App\Models\User;
use App\Models\Pages;

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

    public static function checkPage($config, $data, $isUpdated){

        $errors = [];


        if( count($data) != count($config["inputs"]) ){
            $errors[] = "Tentative de HACK - Faille XSS";
        }else{

            foreach ($config["inputs"] as $name => $configInputs) {


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

                if (!$isUpdated) {
                    if (!empty($configInputs["uniq"]) &&
                        $configInputs["uniq"] === true
                    ) {
                        $category = new Pages();
                        if ($category->find_duplicates_sql($name, $data[$name]))
                            $errors[] = $configInputs["errorBdd"];
                    }
                }
            }
        }
        return $errors;
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

    public static function checkFormReview($config,$data){

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

                if (!empty($configInputs["status"])
                    && !in_array($data[$name], $configInputs["status"])) {

                    $errors[] = $configInputs["error"];
                }

            }
        }
        return $errors;

    }

    public static function checkFormNavbar($config, $data){

        $errors = [];


        if( count($data) < count($config["inputs"]) ){
            $errors[] = "Tentative de HACK - Faille XSS";
        }else{

            foreach ($config["inputs"] as $name => $configInputs) {

                if (!empty($configInputs["uniq"]) && $configInputs["uniq"] === true){
                    $page = new Navbar();
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
            }

            if(	empty($data['typeNavbar'])) {
                $errors[] = 'Veuillez remplir tous les champs';
            }else{
                if (empty($data['selectType'])){
                    $errors[] = 'Veuillez remplir tous les champs';
                }else{
                    switch ($data['typeNavbar']){
                        case 'page':
                            $page = new modelPages();
                            $verifSelect = $page->select()->where("id = :id")->setParams(["id" => $data['selectType']])->get();
                            break;
                        case 'category':
                            $category = new modelCategory();
                            $verifSelect = $category->select()->where("id = :id")->setParams(["id" => $data['selectType']])->get();
                            break;
                    }

                    if (!isset($verifSelect) || empty($verifSelect)){
                        $errors[] = 'Tentative de hack';
                    }
                }
            }
        }
        return $errors;
    }

    public static function checkFormTabNavbar($config, $data, $countInputs){

        $errors = [];


        if( count($data) < count($config["inputs"]) ){
            $errors[] = "Tentative de HACK - Faille XSS";
        }else{

            foreach ($config["inputs"] as $name => $configInputs) {

                if (!empty($configInputs["uniq"]) && $configInputs["uniq"] === true){
                    $page = new Navbar();
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
            }


            for ($i = 1; $i <= $countInputs; $i++){
                if(	empty($data['typeDropdown'.$i])) {
                    $errors[] = 'Veuillez remplir tous les champs';
                }else{
                    if (empty($data['selectTypeDropdown'.$i])){
                        $errors[] = 'Veuillez remplir tous les champs';
                    }else{
                        switch ($data['typeDropdown'.$i]){
                            case 'page':
                                $page = new modelPages();
                                $verifSelect = $page->select()->where("id = :id")->setParams(["id" => $data['selectTypeDropdown'.$i]])->get();
                                break;
                            case 'category':
                                $category = new modelCategory();
                                $verifSelect = $category->select()->where("id = :id")->setParams(["id" => $data['selectTypeDropdown'.$i]])->get();
                                break;
                        }

                        if (!isset($verifSelect) || empty($verifSelect)){
                            $errors[] = 'Tentative de hack';
                        }
                    }
                }
            }
        }
        return $errors;
    }
}