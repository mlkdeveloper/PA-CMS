<?php

namespace App\Controller;


use App\Core\View;

class Reviews
{
    public function showReviewsAction(){
        $view = new View("reviews.back", "back");
        $view->assign("title", "Avis");
    }

}