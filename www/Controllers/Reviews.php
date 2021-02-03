<?php

namespace App\Controller;


use App\Core\View;

class Reviews
{
    public function showReviewsAction(){
        $view = new View("reviews.admin", "back");
        $view->assign("title", "Avis");
    }

}