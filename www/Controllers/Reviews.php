<?php

namespace App\Controller;


use App\Core\FormValidator;
use App\Core\MyException;
use App\Core\View;
use App\Models\Products;
use App\Models\Review;

use App\Core\Security;

session_start();

class Reviews
{
    public function showReviewsAction()
    {

        Security::auth("opinions");

        $view = new View("reviews.back", "back");
        $view->assign("title", "Avis");
        $review = new Review();
        $datas = $review
            ->select(DBPREFIXE."products.id as id_products, name," . DBPREFIXE . "review.id as id_review," . DBPREFIXE . "review.commentary as commentary, ". DBPREFIXE ."user.email as email, ". DBPREFIXE . "review.status as rs")
            ->innerJoin(DBPREFIXE."products", "Products_id", "=", DBPREFIXE."products.id")
            ->innerJoin(DBPREFIXE."user", "User_id", "=", DBPREFIXE."user.id")
            ->get();
        $view->assign("datas", $datas);
    }

    public function checkReviewsAction()
    {

        Security::auth("opinions");

        $review = new Review();

        if (isset($_GET["id"]) && !empty($_GET["id"])) {
            $review_datas = $review
                ->select()
                ->where("id= :id")
                ->setParams(["id" => $_GET["id"]])
                ->get();

            $review->populate($review_datas[0]);
            $review->setStatus(1);
            $review->setProductsId($review_datas[0]["Products_id"]);
            $review->setUserId($review_datas[0]["User_id"]);
            $review->save();
        }
        header("Location: /admin/reviews");
    }

    public function deleteReviewsAction()
    {

        Security::auth("opinions");
        $review = new Review();

        if (isset($_GET["id"]) && !empty($_GET["id"])) {
            $review_datas = $review
                ->select()
                ->where("id= :id")
                ->setParams(["id" => $_GET["id"]])
                ->get();

            $review->populate($review_datas[0]);
            $review->setStatus(-1);
            $review->setProductsId($review_datas[0]["Products_id"]);
            $review->setUserId($review_datas[0]["User_id"]);
            $review->save();
            header("Location: /admin/reviews");
        }
    }

    public function showReviewsFromProductsAction()
    {

        Security::auth("opinions");

        $view = new View("reviewsProducts.back", "back");
        $view->assign("title", "Liste des produits");
        $review = new Review();
        $datas = $review
            ->select(DBPREFIXE."products.id as id_product, Products_id, commentary, AVG(mark) as mark, COUNT(commentary) as nb_commentary, name")
            ->innerJoin(DBPREFIXE."products", DBPREFIXE."products.id", "=", "Products_id")
            ->groupBy("Products_id")
            ->get();
        $nb_commentary_check = $review
            ->select("count(*) as nb_commentary_check")
            ->where(DBPREFIXE."review.status = 1")
            ->groupBy("Products_id")
            ->get();

        foreach ($datas as $key => $v) {
            array_push($datas[$key], $nb_commentary_check[$key]??"");
        }

        $view->assign("datas", $datas);
    }

    public function showProductsAction()
    {

        Security::auth("opinions");
        if (isset($_GET["id"]) && !empty($_GET["id"]) && is_numeric($_GET["id"])) {
            $pid = new Products();
            $check_id = FormValidator::checkId($_GET["id"], $pid, false);
            if(!empty($check_id)){
                $view = new View("infoProducts.back", "back");
                $view->assign("title", "Liste des produits");
                $review = new Review();
                $datas = $review
                    ->select("*, ". DBPREFIXE . "products.id as id_p, ". DBPREFIXE . "review.id as id_r")
                    ->innerJoin(DBPREFIXE. "products", DBPREFIXE. "products.id", "=", "Products_id")
                    ->innerJoin(DBPREFIXE. "user", "User_id", "=", DBPREFIXE."user.id")
                    ->where(DBPREFIXE. "products.id = :id")
                    ->setParams(["id" => $_GET["id"]])
                    ->get();
                $view->assign("datas", $datas);
                $view->assign("product", $datas[0]["Products_id"]);
                $view->assign("product_name", $datas[0]["name"]);
            }else{
                throw new MyException("Produit introuvable", 404);
            }

        } else {
            throw new MyException("Problème avec le produit", 403);
        }
    }


}