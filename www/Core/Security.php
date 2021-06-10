<?php


namespace App\Core;


class Security
{
    public static function changeFile($file, $type){
        $ptr = fopen("$file", "r");
        $contenu = fread($ptr, filesize($file));

        fclose($ptr);
        $contenu = explode(PHP_EOL, $contenu);

        $line = false;
        $searchValue = '';

        switch ($type){
            case 'changeRoute':
            case 'finalChangeRoute':
                $searchValue = '/:';
                break;
            case 'changeConstantManager':
                $searchValue = 'config-sample.env';
                break;
            case 'deleteStartInstallation':
                $searchValue = '/start-install:';
                break;
            case 'removeRedirection':
                $searchValue = '$slug[0]';
                break;
        }

        foreach ($contenu as $index => $value) {
            if (strpos($value, $searchValue) !== false) {
                $line = $index;
                break;
            }
        }

        if ($line !== false){


            switch ($type){
                case 'changeRoute':
                    $contenu[$line+1] = "  controller: Security";
                    $contenu[$line+2] = "  action: registerInstall";
                    break;
                case 'finalChangeRoute':
                    $contenu[$line+1] = "  controller: Pages";
                    $contenu[$line+2] = "  action: displayFront";
                    break;
                case 'changeConstantManager':
                    $contenu[$line] = '    private $envFile = "config.env";';
                    break;
                case 'deleteStartInstallation':
                    for ($i = -1; $i < 4; $i++){
                        unset($contenu[$line+$i]);
                    }
                    break;
                case 'removeRedirection':

                    unset($contenu[$line]);
                    unset($contenu[$line+1]);
                    unset($contenu[$line+2]);
                    unset($contenu[$line+3]);
                    break;
            }

            $contenu = array_values($contenu);

            $contenu = implode(PHP_EOL, $contenu);

            $ptr = fopen($file, "w");
            fwrite($ptr, $contenu);
            fclose($ptr);
        }
    }
}