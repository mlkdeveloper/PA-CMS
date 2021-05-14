<?php

namespace App\Core;

class ConstantManager {

    private $envFile = "config-sample.env";
	private $data = [];

	public function __construct(){

        if(!file_exists($this->envFile))
			die("Le fichier ".$this->envFile." n'existe pas");

        if ($this->envFile === "config.env"){
            $this->parsingEnv($this->envFile);
            $this->defineConstants();
        }
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

    /**
     * @param string $envFile
     */
    public function setEnvFile(string $envFile): void
    {
        $this->envFile = $envFile;
    }
}