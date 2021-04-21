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
            PHP_EOL."  controller: Pages".
            PHP_EOL."  action: displayFront"
            , FILE_APPEND);
    }

    public function updateRoute($oldSlug)
    {

        $ptr = fopen("$this->fileRoutes", "r");
        $contenu = fread($ptr, filesize($this->fileRoutes));

        fclose($ptr);
        $contenu = explode(PHP_EOL, $contenu);

        $line = false;

        foreach ($contenu as $index => $value) {
            if (strpos($value, "#FRONT_".$oldSlug) !== false) {
                $line = $index;
                break;
            }
        }

        if ($line !== false){

            $contenu[$line] = "#FRONT_".$this->slug;
            $contenu[$line+1] = "/".$this->slug.":";

            $contenu = array_values($contenu);

            $contenu = implode(PHP_EOL, $contenu);
            $ptr = fopen($this->fileRoutes, "w");
            fwrite($ptr, $contenu);
            fclose($ptr);
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
            fclose($ptr);
        }
    }
}