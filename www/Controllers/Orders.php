<?php


namespace App\Controller;


use App\Models\Order;
use App\Core\View;

class Orders
{
    public function showOrdersAction(){
        $view = new View("orders.back", "back");
        $view->assign("title", "Commandes");

    }

    public function infoOrderAction(){
        $view = new View("info-order.back", "back");
        $view->assign("title", "Infos sur la commande");
    }

}