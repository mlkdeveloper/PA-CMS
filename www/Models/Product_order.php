<?php


namespace App\Models;

use App\Core\Database;


class Product_order extends Database
{
    protected $id = null;
    protected $id_product_term;
    protected $id_order;
    protected $createdAt;

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
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdProductTerm()
    {
        return $this->id_product_term;
    }

    /**
     * @param mixed $id_product_term
     */
    public function setIdProductTerm($id_product_term)
    {
        $this->id_product_term = $id_product_term;
    }

    /**
     * @return mixed
     */
    public function getIdOrder()
    {
        return $this->id_order;
    }

    /**
     * @param mixed $id_order
     */
    public function setIdOrder($id_order)
    {
        $this->id_order = $id_order;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }


}