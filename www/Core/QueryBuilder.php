<?php


namespace App\Core;

class QueryBuilder
{

    private $request;
    private $params;
    private $select;
    private $where = [];
    private $order = [];
    private $limit;
    private $join = [];


    protected $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new \PDO(DBDRIVER . ":host=" . DBHOST . ";dbname=" . DBNAME . ";port=" . DBPORT, DBUSER, DBPWD);
        } catch (\Exception $e) {
            die("Erreur SQL : " . $e->getMessage());
        }
    }

    public function innerJoin($table,$column1,$operator,$column2){

        $this->join[] = " INNER JOIN " . $table . " ON " . $column1 . $operator . $column2;
        return $this;

    }

    public function select(...$columns){

        $this->select = $columns;
        return $this;
    }

    public function where(...$condition){

        $this->where = array_merge($condition);
        return $this;
    }

    public function setParams(array $params){

        $this->params = $params;
        return $this;
    }

    public function limit($nb){

        $this->limit = $nb;
        return $this;
    }

    public function orderBy($column,$direction){

        $this->order[] = "$column $direction";
        return $this;

    }


    public function get(){

        $this->request = "SELECT ";
        $this->select ? $this->request.= implode(',',$this->select) : $this->request.= "*";
        $this->request.= " FROM " . $this->table;

        if (!empty($this->join)){
            $this->request.= implode(' ',$this->join);
        }

        if (!empty($this->where)){
            $this->request.= " WHERE ( ";
            $this->request.= implode(' ) AND ( ',$this->where);
            $this->request.= " )";
        }

        if (!empty($this->order)){
            $this->request.= " ORDER BY " . implode(', ',$this->order);

        }

        if ($this->limit){
            $this->request.= " LIMIT " . $this->limit;
        }


        return $this->execute();

    }

    public function delete(){

        $this->request = "DELETE FROM " .$this->table;

        if (!empty($this->where)){
            $this->request.= " WHERE ( ";
            $this->request.= implode(' ) AND ( ',$this->where);
            $this->request.= " )";
        }

        if ($this->params) {
            $query = $this->pdo->prepare($this->request);
           $response = $query->execute($this->params);
        }else {
            $response = $this->pdo->query($this->request);
        }

        return $response;
    }
    public function execute(){

        if ($this->params) {
            $query = $this->pdo->prepare($this->request);
            $query->execute($this->params);
        }else {
            $query = $this->pdo->query($this->request);
        }
        return $query->fetchAll(\PDO::FETCH_ASSOC);

    }

}