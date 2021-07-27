<?php

namespace App\Core;


class Uploader{

    private $file = [];
    private $name;
    private $directory = "";
    private $size = 1000000;
    private $error = [];
    private $isLogo = false;
    private $extensions = ["png","jpeg","svg","jpg"];

    public function __construct($file, $isLogo = false)
    {
        if ($isLogo)
            $this->isLogo = true;

        (is_array($file)) ? $this->file = $file : $this->error = "Erreur !";
    }

    public function setName($name){

        $this->name = $name;
        return $this;
    }

    public function setSize($size){

        (is_int($size) && $size > 0) ? $this->size = $size * 1024 * 1024 : $this->error = "Erreur !";
        return $this;
    }

    public function setDirectory($d){

        $this->directory = $d;
        return $this;
    }

    public function getExtension(){

        $explode = explode(".",$this->file['name']);
        return end($explode);
    }

    private function checkSizeFile(){

        if ($this->file['size'] > $this->size)
            $this->error[] = "Taille de l'image trop grande !";
    }

    private function checkExtension(){

        $getExtension = $this->getExtension();

        if (!in_array($getExtension,$this->extensions))
            $this->error[] = "Erreur au niveau de l'extension !";

    }

    public function destination(){

        $destination = $this->directory . DIRECTORY_SEPARATOR;
        $destination .= $this->name;
        $destination .= "." . $this->getExtension();


        return $destination;
    }


    public function upload(){

        $this->checkSizeFile();
        $this->checkExtension();

        if (empty($this->error)){

            if ($this->isLogo){

                if (is_uploaded_file($this->file['tmp_name'])){
                    $file = scandir("./images/logo/",1);
                    unlink("./images/logo/". $file[0]);
                }else{
                    $this->error[] = "Un problème est survenue lors de l'upload de l'image !";
                }
            }
            return move_uploaded_file($this->file['tmp_name'], $this->destination());
        }else{
            return false;
        }

    }

    public function errorsFile(){
        return $this->error;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

}
