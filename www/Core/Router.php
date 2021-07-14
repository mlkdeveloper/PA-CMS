<?php

namespace App\Core;

class Router
{

    private $slug;
    private $action;
    private $controller;
    private $routePath = "routes.yml";
    private $listOfRoutes = [];
    private $listOfSlugs = [];


    public function __construct($slug)
    {
        $this->slug = $slug;
        $this->loadYaml();

        if (empty($this->listOfRoutes[$this->slug])) $this->exception404(" Slug invalide");


        $this->setController($this->listOfRoutes[$this->slug]["controller"]);
        $this->setAction($this->listOfRoutes[$this->slug]["action"]);
    }

    public function loadYaml()
    {
        $this->listOfRoutes = yaml_parse_file($this->routePath);
        foreach ($this->listOfRoutes as $slug => $route) {
            if (empty($route["controller"]) || empty($route["action"]))
                die("Parse YAML ERROR");
            $this->listOfSlugs[$route["controller"]][$route["action"]] = $slug;
        }
    }

    public function run(){

        $a = $this->getAction();
        if( file_exists("./Controllers/".$this->getController().".php") ){

            include "./Controllers/".$this->getController().".php";

            $c = "App\\Controller\\".$this->getController();
            if( class_exists($c)){


                $cObject = new $c();

                if(method_exists($cObject, $this->getAction())){

                    $cObject->$a();

                }else{
                    throw new MyException("Error la methode n'existe pas !!!");
                }

            }else{
                throw new MyException("Error la classe n'existe pas!!!");
            }


        }else{
            throw new MyException("Error le fichier controller n'existe pas !!!");
        }
    }


    public function getSlug($controller = "Main", $action = "default")
    {
        return $this->listOfSlugs[$controller][$action];
    }

    public function setController($controller)
    {
        $this->controller = ucfirst($controller);
    }

    public function setAction($action)
    {
        $this->action = $action . "Action";
    }


    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function exception404($motif = "")
    {
        throw new MyException("Erreur 404 ! ". $motif,404);
    }
}