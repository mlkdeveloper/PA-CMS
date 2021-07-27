<?php
namespace App\Core;

use App\Models\Attributes;
use App\Models\Products;
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
        if( count($data) != count($config["inputs"]) ){
            $errors[] = "Tentative de HACK - Faille XSS";

        }else{

            foreach ($config["inputs"] as $name => $configInputs) {


                if(!empty($configInputs["minLength"])
                    && is_numeric($configInputs["minLength"])
                    && strlen(trim($data[$name])) < $configInputs["minLength"]){

                    $errors[] = $configInputs["error"];

                }

                if(!empty($configInputs["maxLength"])
                    && is_numeric($configInputs["maxLength"])
                    && strlen(trim($data[$name])) > $configInputs["maxLength"]){

                    $errors[] = $configInputs["error"];

                }

                if(!empty($configInputs["regex"])
                    && !preg_match($configInputs["regex"],$data[$name])){

                    $errors[] = $configInputs["error"];
                }


                if(!empty($configInputs["confirm"])
                    && $data[$name] != $data[$configInputs["confirm"]]
                ){
                    $errors[] = $configInputs["error"];
                }


            }
        }

        return $errors;
    }

    public static function checkPage($config, $data, $isUpdatedName, $isUpdatedSlug){

        $errors = [];


        if( count($data) != count($config["inputs"]) ){
            $errors[] = "Tentative de HACK - Faille XSS";
        }else{

            foreach ($config["inputs"] as $name => $configInputs) {

                if(	!empty($configInputs["minLength"])
                    && is_numeric($configInputs["minLength"])
                    && strlen(trim($data[$name])) < $configInputs["minLength"]){

                    $errors[] = $configInputs["errorLength"];
                }

                if(	!empty($configInputs["maxLength"])
                    && is_numeric($configInputs["maxLength"])
                    && strlen(trim($data[$name])) > $configInputs["maxLength"]){

                    $errors[] = $configInputs["errorLength"];
                }

                if (!empty($configInputs["regex"])
                    && !preg_match($configInputs["regex"], $data[$name])){
                    $errors[] = $configInputs["errorRegex"];
                }
            }

            if (!$isUpdatedName) {
                $pages = new Pages();
                if ($pages->find_duplicates_sql("name", $data["name"]))
                    $errors[] = 'Une page avec ce nom existe déjà';
            }

            if (!$isUpdatedSlug) {
                $pages = new Pages();
                if ($pages->find_duplicates_sql("slug", $data["slug"]))
                    $errors[] = 'Ce slug existe déjà';
            }


            $file = './routes.yml';

            $ptr = fopen("$file", "r");
            $contenu = fread($ptr, filesize($file));

            fclose($ptr);
            $contenu = explode(PHP_EOL, $contenu);

            foreach ($contenu as $index => $value) {
                if (preg_match('/^\/.+$/', $value)) {
                    if (!$isUpdatedSlug){
                        if ($contenu[$index] == $data["slug"].':'){
                            $errors[] = "Ce slug est déjà utilisé par le CMS";
                            break;
                        }
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


    public static function checkClient($config,$data,$isCreated, $captcha=false)
    {
        $errors = [];
        $count = 0;

        if ($captcha){
            $count = 1;
        }

        if( count($data)-$count != count($config["inputs"]) ){
            $errors[] = "Tentative de HACK - Faille XSS";

        }else{

            if ($captcha){
                if (empty($data['captcha'])){
                    $errors[] = "Veuillez remplir tous les champs";

                    return  $errors;
                }
            }

            foreach ($config["inputs"] as $name => $configInputs) {

                if (!empty($data[$name])) {

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

                    if ($configInputs["type"] === "email") {

                        if (!filter_var(trim($data[$name]), FILTER_VALIDATE_EMAIL)) {
                            $errors[] = "Email invalide !";
                        } else {
                            if (!$isCreated) {
                                $user = new User();

                                if ($user->find_duplicates_sql($name, trim($data[$name]))) {
                                    $errors[] = "L'email existe déjà  !";
                                }
                            }
                        }
                    }

                    if (!empty($configInputs["regex"])
                        && !preg_match($configInputs["regex"], $data[$name])) {

                        $errors[] = $configInputs["error"];
                    }

                    if (!empty($configInputs["confirm"])
                        && $data[$name] != $data[$configInputs["confirm"]]
                    ) {

                        $errors[] = $configInputs["error"];
                    }
                }else{
                    $errors[] = "Veuillez remplir tous les champs";

                    return  $errors;
                }
            }
            if ($captcha){
                if (strtoupper($data['captcha']) != $_SESSION['captcha']) {
                    $errors[] = "Captcha incorrect";
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
                        $category = new modelCategory();
                        if ($category->find_duplicates_sql($name, trim($data[$name])))
                            $errors[] = $configInputs["errorUniq"];
                    }
                }

                if (!empty($configInputs["status"])
                    && !in_array($data[$name], $configInputs["status"])) {

                    $errors[] = $configInputs["error"];
                }


                if (!empty($configInputs["regex"])
                    && !preg_match($configInputs["regex"], $data[$name])){
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

                if (!$isCreated) {
                    if (!empty($configInputs["uniq"]) &&
                        $configInputs["uniq"] === true
                    ) {
                        if ($class->find_duplicates_sql($name, $data[$name]))
                            $errors[] = $configInputs["errorUniq"];
                    }
                }

                if (!empty($configInputs["regex"])
                    && !preg_match($configInputs["regex"], $data[$name])){
                    $errors[] = $configInputs["error"];
                }

                if (!empty($configInputs["maxLength"])
                    && is_numeric($configInputs["maxLength"])
                    && strlen(trim($data[$name])) > $configInputs["maxLength"]) {

                    $errors[] = $configInputs["error"];
                }
            }
        }
        return $errors;
    }

    static function checkProduct1($class, $name, $category, $categories, $type, $fdq = true, $hasVariant=true ){
        $errors = [];

        if ($class->find_duplicates_sql("name", trim($name)) && $fdq) {
            $errors[] = "Le produit existe déjà"; 
        }

        if (
            strlen(trim($name)) < 2 ||
            strlen(trim($name)) > 50
        ) {
            $errors[] = "Le produit doit avoir un nom entre 2 et 50 caractères, sans caractères spéciaux ni numérique";
        }

        if(!in_array($type, [0,1])) {
            $errors[] = "Le produit doit avoir un type connu";
        }

        if($type == 1 && !$hasVariant || $type == 0 && $hasVariant){
            $errors[] = "Problème avec le type du produit";
        }

        if(!in_array($category, $categories)){
            $errors[] = "La catégorie n'existe pas";
        }

        if(isset($_GET["id"]))
            if (!$class->find_duplicates_sql_id("id", $_GET["id"], $name, false)) {
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
            
            if($stock < 0
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
                $errors[] = "Le prix de la variante #".$key+1 ." doit être saisi correctement.";
            }
            
            if($stock < 0
                || empty($stock)
                && !is_numeric($stock)
            ){
                $errors[] = "Le stock de la variante #".$key + 1 . "doit être saisi.";
            }   

            unset($value[count($value)-1], $value[count($value)-1]);

            foreach($value as $k => $v)
                if(!in_array($v, $terms)){
                    $errors[] = "Un problème est apparu dans la variante #". $key+1 ." du produit !";
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

    static function checkId($id, $class, $status = true){
        if($status){
            $check = $class
                ->select("id")
                ->where("id = :id", "status = 1")->setParams(["id" => $id])
                ->get();

            if (empty($check)) return false;
            else return true;
        }else{
            $check = $class
                ->select("id")
                ->where("id = :id")->setParams(["id" => $id])
                ->get();

            if (empty($check)) return false;
            else return true; 
        }
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
                    && strlen(trim($data[$name])) < $configInputs["minLength"]){

                    $errors[] = $configInputs["errorLength"];
                }

                if(	!empty($configInputs["maxLength"])
                    && is_numeric($configInputs["maxLength"])
                    && strlen(trim($data[$name])) > $configInputs["maxLength"]){

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
                    && strlen(trim($data[$name])) < $configInputs["minLength"]){

                    $errors[] = $configInputs["errorLength"];
                }

                if(	!empty($configInputs["maxLength"])
                    && is_numeric($configInputs["maxLength"])
                    && strlen(trim($data[$name])) > $configInputs["maxLength"]){

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