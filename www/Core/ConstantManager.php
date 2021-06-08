<?php

namespace App\Core;

class ConstantManager {

	private $envFile = ".env";
	private $data = [];

	public function __construct(){
		if(!file_exists($this->envFile))
			die("Le fichier ".$this->envFile." n'existe pas");

		$this->parsingEnv($this->envFile);

		if(!empty($this->data["ENV"])){
            $config = "config".$this->envFile;

            if(!file_exists($config))
                die("Le fichier ".$config." n'existe pas");

			$this->parsingEnv($config);
		}


		$this->defineConstants();

	}

	private function defineConstants(){
		foreach ($this->data as $key => $value) {
			self::defineConstant($key, $value);
		}
	}


	public static function defineConstant($key, $value){
		if(!defined($key)){
			define($key, $value);
		}else{
			die("Attention vous avez utilisé une constante reservée à ce framework ".$key);
		}
	}


	public function parsingEnv($file){

		$handle = fopen($file, "r");
		$regex = "/([^=]*)=([^#]*)/";

		if(!empty($handle)){
			while (!feof($handle)) {
				
				$line = fgets($handle);
				preg_match($regex, $line, $results);
				if(!empty($results[1]) && !empty($results[2]))
					$this->data[mb_strtoupper($results[1])] = trim($results[2]);

			}
		}

	}

}