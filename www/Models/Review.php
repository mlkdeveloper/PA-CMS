<?php


namespace App\Models;

use App\Core\Database;

class Review extends Database
{
    private $id;
    protected $commentary;
    protected $mark;
    protected $status;
    protected $Products_id;
    protected $User_id;

    /**
     * @return mixed
     */
    public function getProductsId()
    {
        return $this->Products_id;
    }

    /**
     * @param mixed $Products_id
     */
    public function setProductsId($Products_id)
    {
        $this->Products_id = $Products_id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->User_id;
    }

    /**
     * @param mixed $User_id
     */
    public function setUserId($User_id)
    {
        $this->User_id = $User_id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = intval($id);
    }

    /**
     * @return mixed
     */
    public function getCommentary()
    {
        return $this->commentary;
    }

    /**
     * @param mixed $commentary
     */
    public function setCommentary($commentary): void
    {
        $this->commentary = htmlspecialchars(trim($commentary));
    }

    /**
     * @return mixed
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * @param mixed $mark
     */
    public function setMark($mark): void
    {
        $this->mark = intval($mark);
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = intval($status);
    }


    public function formBuilderRegister(){

        return [

            "inputs"=>[

                "commentary"=>[
                    "maxLength"=>500,
                    "minLength"=>2,
                    "error"=>"Votre commentaire doit être compris entre 2 et 500 caractères !"
                ],

                "mark"=>[
                    "status"=> [1,2,3,4,5],
                    "error"=>"Erreur sur la note."
                ]
            ]

        ];

    }


}