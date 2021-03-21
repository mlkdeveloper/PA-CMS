<?php


namespace App\Controller;


use App\Core\View;
use App\Core\FormValidator;
use App\Models\Shop as ShopModel;
class Shop
{
    public function displayShopAction(){
        $view = new View("shopList.back", "back");
        $view->assign("title", "Admin - Magasin");

        $shop = new ShopModel();
        $listShop = $shop->select()->get();

        $view->assign("shop", $listShop);
    }

    public function newShopAction(){

        $shop = new ShopModel();

        $view = new View("createShop.back", "back");
        $view->assign("title", "Admin - Nouveau magasin");

        $formCreateShop = $shop->formBuilderCreateShop();

        if(!empty($_POST)){

            $errors = FormValidator::check($formCreateShop, $_POST);

            if(empty($errors)){
                $shop->setName($_POST['nom']);
                $shop->setAddress($_POST['address']);
                $shop->setCity($_POST['ville']);
                $shop->setZipCode($_POST['zipCode']);
                $shop->setDescription($_POST['description']);
                $shop->setPhoneNumber($_POST['telephone']);
                $shop->save();

                header('location:/admin/liste-magasin');
            }else{
                $view->assign("errors", $errors);
            }
        }
        $view->assign("form", $formCreateShop);
    }
}