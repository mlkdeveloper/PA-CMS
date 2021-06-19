<?php

namespace App\Core;

class FormBuilder
{

    public function __construct(){

    }

    public static function render($config, $show=true){

        $html = "<form 
				method='".($config["config"]["method"]??"GET")."' 
				action='".($config["config"]["action"]??"")."'
				class='".($config["config"]["class"]??"")."'
				id='".($config["config"]["id"]??"")."'
				>";


        foreach ($config["inputs"] as $name => $configInput) {

            $html .= "<div class='".($configInput["divClass"]??"")."'>";

            $html .="<label for='".($configInput["id"]??$name)."'>".($configInput["label"]??"")." </label>";

            $html .="<input 
						type='".($configInput["type"]??"text")."'
						name='".$name."'
						placeholder='".($configInput["placeholder"]??"")."'
						data-format='".($configInput["data-format"]??"")."'
						class='".($configInput["class"]??"")."'
						id='".($configInput["id"]??$name)."'
						value='".($configInput["value"]??"")."'
						".(!empty($configInput["required"])?"required='required'":"")."
						 ><br>";

            $html .= "</div>";
        }




        $html .= "<input type='submit' class='".($config["config"]["classButton"]??"")."' value=\"".($config["config"]["submit"]??"Valider")."\">";
        $html .= "</form>";


        if($show){
            echo $html;
        }else{
            return $html;
        }

    }

}