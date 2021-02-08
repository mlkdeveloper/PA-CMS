<?php

namespace App\Controller;


use App\Core\View;
use App\Models\Review;

class Reviews
{
    public function showReviewsAction()
    {
        $view = new View("reviews.back", "back");
        $view->assign("title", "Avis");
        $review = new Review();
        $datas = $review->select("*")->get();
        $view->assign("datas", $datas);
    }

    public function checkReviewsAction()
    {
        $review = new Review();
        $review->setId($_GET["id"]);
        $review->setStatus("1");
        header("Location: /admin/reviews");
    }

    public function deleteReviewsAction()
    {

    }

}