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
            ->select("cc_products.id as id_products, cc_review.id as id_review, cc_review.commentary as commentary, cc_user.email as email, cc_review.status as rs")
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

    public function showReviewsFromProductsAction(){
        $view = new View("reviewsProducts.back", "back");
        $view->assign("title", "Liste des produits");
        $review = new Review();
        $datas = $review
            ->select("cc_products.id as id_product, Products_id, commentary, AVG(mark) as mark, 
            (SELECT COUNT(*) as nb FROM cc_review WHERE status = 1 GROUP BY commentary) as nb_check_commentary, COUNT(commentary) as nb_commentary")
            ->innerJoin("cc_products", "cc_products.id", "=", "Products_id")
            ->groupBy("Products_id")
            ->get();
        $view->assign("datas", $datas);

    }

}