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

    /*
        - On passe le slug en attribut
        - Execution de la methode loadYaml
        - Vérifie si le slug existe dans nos routes -> SINON appel la methode exception4040
        - call setController et setAction
    */
    public function __construct($slug)
    {
        $this->slug = $slug;
        $this->loadYaml();

        if (empty($this->listOfRoutes[$this->slug])) $this->exception404();

        /*
            $this->listOfRoutes
                                ["/liste-des-utilisateurs"]
                                ["controller"]

        */
        $this->setController($this->listOfRoutes[$this->slug]["controller"]);
        $this->setAction($this->listOfRoutes[$this->slug]["action"]);
    }


    /*
        $this->routePath = "routes.yml";
        - On transforme le YAML en array que l'on stock dans listOfRoutes
        - On parcours toutes les routes
            - Si il n'y a pas de controller ou pas d'action -> die()
            - Sinon on alimente un nouveau tableau qui aura pour clé le controller et l'action
    */
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

            //include car on vérifie avant l'existance du fichier et surtout
            //le include est plus rapide à executer
            include "./Controllers/".$this->getController().".php";

            //Le fichie existe mais est-ce que la classe existe ?

            $c = "App\\Controller\\".$this->getController();
            if( class_exists($c)){

                // $c = UserController
                // Instance de la classe : la classe dépend du fichier routes.yml qui lui dépend  du slug
                //$c  =  User

                $cObject = new $c(); // new App\User
                //Est-ce que la méthode existe dans l'objet
                if(method_exists($cObject, $this->getAction())){

                    //$a => addAction
                    //Appel de la méthode dans l'objet, exemple UserController->addAction();
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

    //ucfirst = fonction upper case first : majuscule la première lettre
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

    public function exception404()
    {
        throw new MyException("Erreur 404 !",404);
    }

}