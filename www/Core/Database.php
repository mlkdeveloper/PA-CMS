<?php
namespace App\Core;


class Database extends QueryBuilder
{
    protected $table;

//    Global variables

    const NEW_OBJECT = 1;
    const UPDATE_OBJECT = 2;
    const DELETE_OBJECT = 3;

    const USER_TABLE = DBPREFIXE.'user';


    public function __construct()
    {


        parent::__construct();


        //  jclm_   App\Models\User -> jclm_User
        $classExploded = explode("\\", get_called_class());
        $this->table = strtolower(DBPREFIXE . end($classExploded)); //jclm_User

    }

    public function save()
    {
        //INSERT OU UPDATE
        //Array ( [firstname] => Yves [lastname] => SKRZYPCZYK [email] => y.skrzypczyk@gmail.com [pwd] => Test1234 [country] => fr [role] => 0 [status] => 1 [isDeleted] => 0)
        $column = array_diff_key(get_object_vars($this), get_class_vars(get_class()));

        if (is_null($this->getId())) {

            $query = $this->pdo->prepare("INSERT INTO " . $this->table . " (" . implode(',', array_keys($column)) . ") VALUES (:" . implode(',:', array_keys($column)) . ") "); //1


        } else {

            foreach($column as $key => $value){
                $sqlColumn[] = $key . "=:". $key;
            }
            $column["id"] = $this->getId();

            $query = $this->pdo->prepare("UPDATE " . $this->table . " SET " . implode(',', $sqlColumn) . " WHERE id = :id");
        }

        $value = $query->execute($column);
        return $value;
    }

    public function deleteObject()
    {
        $column["id"] = $this->getId();
        $column["status"] = $this->getStatus();

        $query = $this->pdo->prepare("UPDATE " . $this->table  . " SET status = :status" . " WHERE id = :id");

        $value = $query->execute($column);
        return $value;
      


    }


    public function populate($data){

        foreach ($data as $key => $value){

            $method = 'set'.ucfirst($key);

            if (method_exists($this,$method)){
                $this->$method($value);
            }
        }
        return $this;
    }


    public function find_duplicates_sql($col, $value, $status = false): bool
    {
        if($status){
            $datas = $this
                ->select("$col")
                ->where("$col = :$col, status = 1")
                ->setParams(["$col" => $value])
                ->get();

            if (empty($datas)) return false;
            else return true;
        }else{
            $datas = $this
                ->select("$col")
                ->where("$col = :$col")
                ->setParams(["$col" => $value])
                ->get();

            if (empty($datas)) return false;
            else return true;
        }
    }

    public function find_duplicates_sql_id($col, $id, $value, $status = false): bool
    {
        if(!$status){
            $datas = $this
                ->select("name")
                ->where("$col <> :$col")
                ->setParams(["$col" => $id])
                ->get();

            $array = [];
            foreach($datas as $data)
                array_push($array, $data["name"]);

            if(in_array($value, $array)) return false;
            else return true;
        }else{
            $datas = $this
                ->select("name")
                ->where("$col <> :$col", "status = 1")
                ->setParams(["$col" => $id])
                ->get();

            $array = [];
            foreach($datas as $data)
                array_push($array, $data["name"]);

            if(in_array($value, $array)) return false;
            else return true;

        }
    }

}