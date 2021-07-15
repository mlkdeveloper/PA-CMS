<?php


namespace App\Controller;

use App\Core\Facture;
use App\Models\Orders as OrderModel;
use App\Models\Shop as ShopModel;

class Test
{
// Fonction ajouter lorsqu'on a besoin d'afficher la facture d'une commande
    public function testAction(){

        $shop = new OrderModel();
        $shop_data = $shop->select()->get();
        $shop_data = $shop_data[0];

        // ENvoyer en paramètre l'id de l'user et les informations d'une commande (au moins l'id)
        Facture::test(20, $shop_data);


    }

}