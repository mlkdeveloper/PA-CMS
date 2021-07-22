<?php

namespace App\Models;

use App\Core\Database;

class Product_term extends Database
{
    private $id;
    protected $idProduct;
    protected $idTerm;
    protected $idGroup;
    protected $status;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * @param mixed $idProduct
     *
     * @return self
     */
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdTerm()
    {
        return $this->idTerm;
    }

    /**
     * @param mixed $idTerm
     *
     * @return self
     */
    public function setIdTerm($idTerm)
    {
        $this->idTerm = $idTerm;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdGroup()
    {
        return $this->idGroup;
    }

    /**
     * @param mixed $idGroup
     *
     * @return self
     */
    public function setIdGroup($idGroup)
    {
        $this->idGroup = $idGroup;

        return $this;
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
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}