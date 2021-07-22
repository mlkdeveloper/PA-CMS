<?php
namespace App\Core;


class Helpers{

	public static function cleanFirstname($firstname){
		return ucwords(mb_strtolower(trim($firstname)));
	}

    public static function pwdGenerator()
    {
        // Liste des caractères possibles
        $char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVW0123456789!<>/=:?";
        $mdp = '';
        $long = strlen($char);

        //Nombre aléatoire
        srand((double)microtime() * 1000000);
        for ($i = 0; $i < 10; $i++){
            $mdp = $mdp . substr($char, rand(0, $long - 1), 1);
        }
        return $mdp;
    }

    public static function dateFr($data){

	    $timestamp = strtotime($data);
	    $newDate = date("d/m/Y H:i",$timestamp);

	    return $newDate;
    }

    public static function filter_by_value($array, $index, $value){
        $newarray = null;
	    if(is_array($array) && count($array)>0)
        {
            foreach(array_keys($array) as $key){
                $temp[$key] = $array[$key][$index];

                if ($temp[$key] == $value){
                    $newarray[$key] = $array[$key];
                }
            }
        }
        return $newarray;
    }

    public static function checkStock(){
	    echo 'ok';
    }
}