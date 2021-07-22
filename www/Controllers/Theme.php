<?php


namespace App\Controller;


use App\Models\Themes;

class Theme
{

    public function enableThemeAction(){

        $theme = new Themes();
        $enableTheme = new Themes();
        $getTheme = $theme->select()->where("id = :id")->setParams(["id" => $_GET['id']])->get();

        if (empty($getTheme)){
            header("Location : /admin/parametres-site");
            exit();
        }

        $getEnableTheme = $enableTheme->select()->where("status = 1")->get();
        $enableTheme->populate($getEnableTheme[0]);
        $enableTheme->setStatus(0);
        $enableTheme->save();

        $enableTheme->populate($getTheme[0]);
        $enableTheme->setStatus(1);
        $enableTheme->save();

        header("Location: /admin/parametres-site");
    }

}