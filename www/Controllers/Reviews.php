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
        $datas = $review
            ->select("cc_products.id as id, cc_review.commentary as commentary, cc_user.email as email, cc_review.status as rs")
            ->innerJoin("cc_products", "Products_id", "=", "cc_products.id")
            ->innerJoin("cc_user", "User_id", "=", "cc_user.id")
            ->where("cc_review.status <> 1")
            ->get();
        $view->assign("datas", $datas);
    }

    public function checkReviewsAction()
    {
        $review = new Review();

        if (isset($_GET["id"]) && !empty($_GET["id"])) {
            $review_datas = $review
                ->select()
                ->where("id= :id")
                ->setParams(["id" => $_GET["id"]])
                ->get();

            $review->populate($review_datas[0]);
            $review->setStatus(1);
            $review->save();
            header("Location: /admin/reviews");
        }
    }

    public function deleteReviewsAction()
    {
        $review = new Review();

        if (isset($_GET["id"]) && !empty($_GET["id"])) {
            $review_datas = $review
                ->select()
                ->where("id= :id")
                ->setParams(["id" => $_GET["id"]])
                ->get();

            $review->populate($review_datas[0]);
            $review->setStatus(-1);
            $review->save();
            header("Location: /admin/reviews");
        }

    }

}