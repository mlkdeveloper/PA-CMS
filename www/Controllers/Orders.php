<?php


namespace App\Controller;


use App\Models\Order;
use App\Core\View;

class Orders
{
    public function showOrdersAction(){
        $view = new View("orders.back", "back");
        $view->assign("title", "Commandes");
        $view->assign("file_stylesheet", "../../public/css/orders.css");
    }

    public function infoOrderAction(){
        $view = new View("info-order.back", "back");
        $view->assign("title", "Infos sur la commande");
        $view->assign("file_stylesheet", "../../public/css/orders.css");
    }

}