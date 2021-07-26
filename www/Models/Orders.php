<?php


namespace App\Models;


use App\Core\Database;

class Orders extends Database
{
    private $id = null;
    protected $status;
    protected $User_id;
    protected $CreatedAt;
    protected $montant;
    protected $payment_intent;

    /**
     * @return mixed
     */
    public function getPaymentIntent()
    {
        return $this->payment_intent;
    }

    /**
     * @param mixed $payment_intent
     */
    public function setPaymentIntent($payment_intent)
    {
        $this->payment_intent = $payment_intent;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function setStatus($status)
    {
        $this->status = $status;
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
    public function getCreatedAt()
    {
        return $this->CreatedAt;
    }

    /**
     * @param mixed $CreatedAt
     */
    public function setCreatedAt($CreatedAt)
    {
        $this->CreatedAt = $CreatedAt;
    }

    /**
     * @return mixed
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * @param mixed $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }



}