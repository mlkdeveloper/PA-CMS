<?php


namespace App\Controller;


use App\Core\View;
use App\Core\FormValidator;
use App\Models\Shop as ShopModel;
use App\Models\Products as ProductsModel;
use App\Models\Products_model as ProductsMModel;

class Shop
{

    public function detailShopAction(){
        $shop = new ShopModel();
        $product = new ProductsModel();
        $productModel = new ProductsMModel();


        $idShop = $_GET['id'];
        $shopGet = $shop->select('*')->where('id = 1')->get();

        $view = new View("detailShop.back", "back");

        $formUpdateShop = $shop->formBuilderUpdateShop(...$shopGet);

        if(!empty($_POST)){

            $errors = FormValidator::check($formUpdateShop, $_POST);
            if (!is_numeric($_POST['zipCode'])){
                array_push($errors,"Le code postale doit etre composé uniquement de chiffres");
            }

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