<?php


namespace App\Models;

use App\Core\Database;


class Product_order extends Database
{
    protected $id;
    protected $product_id;
    protected $op_date;

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
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param mixed $product_id
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @return mixed
     */
    public function getOpDate()
    {
        return $this->op_date;
    }

    /**
     * @param mixed $op_date
     */
    public function setOpDate($op_date)
    {
        $this->op_date = $op_date;
    }


}