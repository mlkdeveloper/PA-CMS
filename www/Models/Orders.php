<?php


namespace App\Models;


use App\Core\Database;

class Orders extends Database
{
    private $id;
    protected $status;
    protected $Products_id;
    protected $User_id;
    protected $CreatedAt;

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
    public function setStatus($status): void
    {
        $this->status = $status;
    }

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
    public function setProductsId($Products_id): void
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
    public function setUserId($User_id): void
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
    public function setCreatedAt($CreatedAt): void
    {
        $this->CreatedAt = $CreatedAt;
    }



}