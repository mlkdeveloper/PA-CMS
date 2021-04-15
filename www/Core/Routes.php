<?php


namespace App\Core;


class Routes
{
    private $slug;
    private $fileRoutes = "./routes.yml";

    /**
     * Routes constructor.
     */
    public function __construct($slug)
    {
        $this->slug = $slug;
    }

    public function addRoute()
    {
        file_put_contents($this->fileRoutes,
            PHP_EOL.PHP_EOL."#FRONT_".$this->slug.
            PHP_EOL."/".$this->slug.":".
            PHP_EOL."  controller: Front".
            PHP_EOL."  action: display"
            , FILE_APPEND);
    }

    public function updateRoute()
    {

        $ptr = fopen("$this->fileRoutes", "r");
        $contenu = fread($ptr, filesize($this->fileRoutes));

        fclose($ptr);
        $contenu = explode(PHP_EOL, $contenu);

        $line = false;
        file_put_contents("./zrbhbfhbr", "");

        foreach ($contenu as $index => $value) {
            if (strpos($value, "#FRONT_".$this->slug) !== false) {
                $line = $index;
                break;
            }
        }

        if ($line !== false){
            file_put_contents("./test", $contenu[$line+1]);

            $contenu[$line+1] = "/".$this->slug;
            file_put_contents("./test2", $contenu[$line+1]);


//            $contenu = array_values($contenu);
//
//            $contenu = implode(PHP_EOL, $contenu);
//            $ptr = fopen($this->fileRoutes, "w");
//            fwrite($ptr, $contenu);
        }
    }

    public function deleteRoute()
    {
        $ptr = fopen($this->fileRoutes, "r");
        $contenu = fread($ptr, filesize($this->fileRoutes));

        fclose($ptr);
        $contenu = explode(PHP_EOL, $contenu);

        $line = false;

        foreach ($contenu as $index => $value) {
            if (strpos($value, "#FRONT_".$this->slug) !== false) {
                $line = $index;
                break;
            }
        }

        if ($line !== false){
            for ($i = -1; $i < 4; $i++){
                unset($contenu[$line+$i]);
            }

            $contenu = array_values($contenu);

            $contenu = implode(PHP_EOL, $contenu);
            $ptr = fopen($this->fileRoutes, "w");
            fwrite($ptr, $contenu);
        }
    }
}