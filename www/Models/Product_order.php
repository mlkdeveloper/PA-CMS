<?php


namespace App\Models;

use App\Core\Database;


class Product_order extends Database
{
    protected $id = null;
    protected $id_group_variant;
    protected $id_order;

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
    public function getIdGroupVariant()
    {
        return $this->id_group_variant;
    }

    /**
     * @param mixed $id_group_variant
     */
    public function setIdGroupVariant($id_group_variant)
    {
        $this->id_group_variant = $id_group_variant;
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



}