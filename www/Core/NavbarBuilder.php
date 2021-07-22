<?php


namespace App\Core;


use App\Models\Pages as modelPages;
use App\Models\Navbar as modelNavbar;
use App\Models\Tab_navbar as modelTab_navbar;
use App\Models\Category as modelCategory;


class NavbarBuilder
{
    public static function navbar(){
        $category = new modelCategory();
        $pages = new modelPages();
        $navbar = new modelNavbar();
        $tabNavbar = new modelTab_navbar();


        $arrayNavbar = $navbar->select()->orderBy('sort', 'ASC')->get();
        $arrayTabNavbar = $tabNavbar->select()->get();
        $arrayPages = $pages->select()->get();
        $arrayCategory = $category->select()->get();

        $html = '';

        foreach ($arrayNavbar as $value):
            if ($value['status'] == 0){
                $html .= '<li><a href="';
                if (isset($value['page'])){
                    foreach ($arrayPages as $valuePage):
                        if ($value["page"] == $valuePage['id']){
                            $html .= $valuePage['slug'];
                        }
                    endforeach;
                }else{
                    foreach ($arrayCategory as $valueCategory):
                        if ($value["category"] == $valueCategory['id']){
                            $html .= '/collections?name='.$valueCategory['name'];
                        }
                    endforeach;
                }
                $html .= '">'.$value["name"].'</a></li>';
            }else {
                $html .= '<li class="dropdownMenuFront"><a>'.$value["name"].'&nbsp<i class="fa fa-caret-down"></i></a>';
                $html .= '<ul class="submenu">';
                foreach ($arrayTabNavbar as $valueTab):
                    if ($valueTab['navbar'] == $value['id']){
                        $html .= '<li><a href="';
                        if (isset($valueTab['page'])){
                            foreach ($arrayPages as $valuePage):
                                if ($valueTab["page"] == $valuePage['id']){
                                    $html .= $valuePage['slug'];
                                }
                            endforeach;
                        }else{
                            foreach ($arrayCategory as $valueCategory):
                                if ($valueTab["category"] == $valueCategory['id']){
                                    $html .= '/collections?name='.$valueCategory['name'];
                                }
                            endforeach;
                        }
                        $html .= '">'.$valueTab["name"].'</a></li>';
                    }
                endforeach;
                $html .= '</ul></li>';
            }
        endforeach;


        return $html;
    }
}