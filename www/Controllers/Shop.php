<?php


namespace App\Controller;


use App\Core\Security;
use App\Core\View;
use App\Core\FormValidator;
use App\Models\Shop as ShopModel;
use App\Models\Products as ProductsModel;
use App\Models\Products_model as ProductsMModel;

session_start();

class Shop
{

    /*
     * Affichage du seul magasin disponible
     */
    public function detailShopAction(){

        Security::auth("settingsSite");
        $shop = new ShopModel();

        $shopGet = $shop->select('*')->where('id = 1')->get();

        $view = new View("detailShop.back", "back");

        $formUpdateShop = $shop->formBuilderUpdateShop(...$shopGet);

        if(!empty($_POST)){

            $errors = FormValidator::check($formUpdateShop, $_POST);

            if(empty($errors)){

                $shop->setId(1);
                $shop->setName($_POST['nom']);
                $shop->setAddress($_POST['address']);
                $shop->setCity($_POST['ville']);
                $shop->setZipCode($_POST['zipCode']);
                $shop->setDescription($_POST['description']);
                $shop->setPhoneNumber($_POST['telephone']);
                $shop->save();

                header('location:/admin/detail-magasin');
            }else{
                $view->assign("errors", $errors);
            }
        }
        $view->assign("values", ...$shopGet);
        $view->assign("form", $formUpdateShop);
        $view->assign("title", "Admin - Detail du magasin");

    }

}