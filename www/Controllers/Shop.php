<?php


namespace App\Controller;


use App\Core\View;
use App\Core\FormValidator;
use App\Models\Shop as ShopModel;
use App\Models\Products as ProductsModel;
use App\Models\Products_model as ProductsMModel;

class Shop
{
    public function displayShopAction(){
        $view = new View("shopList.back", "back");
        $view->assign("title", "Admin - Magasin");

        $shop = new ShopModel();
        $listShop = $shop->select('*')->get();

        $view->assign("shop", $listShop);
    }

    public function newShopAction(){

        $shop = new ShopModel();

        $view = new View("createShop.back", "back");
        $view->assign("title", "Admin - Nouveau magasin");

        $formCreateShop = $shop->formBuilderCreateShop();

        if(!empty($_POST)){

            $errors = FormValidator::check($formCreateShop, $_POST);

            if (!is_numeric($_POST['zipCode'])){
                array_push($errors,"Le code postale doit etre composé uniquement de chiffres");
            }
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
        $product = new ProductsModel();
        $productModel = new ProductsMModel();

        if (empty($_GET['id'])){
            header('location:/admin/liste-magasin');
        }

        $idShop = $_GET['id'];
        $shopGet = $shop->select('*')->where('id = :id')->setParams([":id" => $idShop])->get();
        $productsGet = $product->select('*')->where('id = :id')->setParams([":id" => $idShop])->get();

        $view = new View("detailShop.back", "back");
        $view->assign("products", $productsGet);

        $formUpdateShop = $shop->formBuilderUpdateShop(...$shopGet);

        if(!empty($_POST)){

            $errors = FormValidator::check($formUpdateShop, $_POST);
            if (!is_numeric($_POST['zipCode'])){
                array_push($errors,"Le code postale doit etre composé uniquement de chiffres");
            }

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

    function deleteShopAction(){
        $shop = new ShopModel();
        $shopTemp = new ShopModel();
        if (empty($_GET['id']) && !is_numeric($_GET['id'])){
            header('location:/admin/liste-magasin');
        }
        $shop =$shopTemp->select('*')->where('id=:id')->setParams(["id" => $_GET['id']])->get();

        $shopTemp->populate($shop[0]);

        $shopTemp->delete();




        header('location:/admin/liste-magasin?deleteShop=done');

    }
}