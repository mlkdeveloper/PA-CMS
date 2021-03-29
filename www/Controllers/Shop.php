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

    public function detailShopAction(){
        $shop = new ShopModel();

        $idShop = $_GET['id'];
        $shopGet = $shop->select('*')->where('id = :id')->setParams([":id" => $idShop])->get();

        $view = new View("detailShop.back", "back");

        $formUpdateShop = $shop->formBuilderUpdateShop(...$shopGet);

        if(!empty($_POST)){

            $errors = FormValidator::check($formUpdateShop, $_POST);

            if(empty($errors)){
                $shop->setId($_GET['id']);
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


        $view->assign("values", ...$shopGet);
        $view->assign("form", $formUpdateShop);
        $view->assign("title", "Admin - Detail du magasin");

    }
}