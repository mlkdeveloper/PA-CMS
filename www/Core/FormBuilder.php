<?php

namespace App\Core;

class FormBuilder
{

    public function __construct(){

    }

    public static function render($config, $show=true, $captcha=false){

        $html = "<form 
				method='".($config["config"]["method"]??"GET")."' 
				action='".($config["config"]["action"]??"")."'
				class='".($config["config"]["class"]??"")."'
				id='".($config["config"]["id"]??"")."'
				>";


        foreach ($config["inputs"] as $name => $configInput) {

            $html .= "<div class='".($configInput["divClass"]??"")."'>";

            $html .="<label for='".($configInput["id"]??$name)."'>".($configInput["label"]??"")."</label>";

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

        if ($captcha){
            $html .= "<div class='centered'>";
            $html .= "<img src='../captcha/captcha.php' class='mb-2 mt-1'><br>";
            $html .= "</div>";

            $html .= "<div class='form_align--top'>";
            $html .= "<label for='captcha'>Captcha</label>";
            $html .= "<input 
						type='text'
						name='captcha'
						placeholder=''
						data-format=''
						class='input'
						id='captcha'
						value=''
						required='required'
						 ><br>";
            $html .= "</div>";
        }


        $html .= "<input type='submit' class='".($config["config"]["classButton"]??"")." mt-2' value=\"".($config["config"]["submit"]??"Valider")."\">";
		$html .= "</form>";


		if($show){
			echo $html;
		}else{
			return $html;
		}

	}

}