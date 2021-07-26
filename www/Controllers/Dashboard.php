<?php


namespace App\Controller;

use App\Core\View;
use App\Models\Orders as modelOrders;
use App\Models\Review as modelReview;
use App\Models\Products as modelProduct;


use App\Core\Security;

session_start();

class Dashboard
{


    public function dashboardAction(){

        Security::isEmployee();
        $amountTotal = 0;

        //Orders
        $orderModel = new modelOrders();
        $orderTotal = $orderModel->select('montant')->where('status >= 1')->get();

        //Price
        foreach ($orderTotal as $amount){
            $amountTotal += $amount['montant'];
        }

        //Review
        $reviewModel = new modelReview();
        $reviewTotal = $reviewModel->select()->where('status = 1')->get();

        //Products
        $productModel = new modelProduct();
        $productTotal = $productModel->select()->where('status = 1')->get();


        $view = new View("dashboard.back", "back");
        $view->assign('totalOrder', count($orderTotal));
        $view->assign('totalAmount', $amountTotal);
        $view->assign('totalReview', count($reviewTotal));
        $view->assign('totalProduct', count($productTotal));
        $view->assign("title", "Dashboard");
    }

    public function getDataAction(){ //Récupération des données en fonction de la date

        switch ($_POST['type']){
            case 'month':
                $arrayData = $this->month();
                break;
            case 'months':
                $arrayData = $this->months();
                break;
            case 'year':
                $arrayData = $this->year();
                break;
            case 'all':
                $arrayData = $this->all();
                break;
            default:
                echo 'error';
                exit();
        }

        echo json_encode($arrayData);
    }

    public function month(){ //Récupération des données du mois

        $data = $this->getSql("01-".date("m-Y"), date("t", date("m")).date("-m-Y"), true);

        for ($p = 1; $p <= date("t", date("m")); $p++){
            $arrayData[$p-1] = [
                'name'=> $p,
                'value'=> 0
            ];
        }

        switch ($_POST['chart']){
            case 'sales':
                foreach ($data as $value){
                    $tmpSale = explode("-", $value["CreatedAt"])[2];
                    $tmpSale = explode(" ", $tmpSale)[0];
                    $arrayData[$tmpSale-1]['value'] = $arrayData[$tmpSale-1]['value']+1;
                }
                break;
            case 'turnover':
                foreach ($data as $value){
                    $tmpSale = explode("-", $value["CreatedAt"])[2];
                    $tmpSale = explode(" ", $tmpSale)[0];
                    $arrayData[$tmpSale-1]['value'] = $arrayData[$tmpSale-1]['value']+$value["montant"];
                }
                break;
            default:
                echo 'error';
                exit();
        }


        return $arrayData;
    }

    public function months(){ //Récupération des données depuis 6 mois

        $newMonths = [];
        $dateForSql = "";
        $date_now = date("Y-n-d");
        $tmpYear = date("Y");

        for($i = 0; $i < 6; $i++){
            if($i === 0){
                $newMonths[$i] = [
                    'name'=> $this->monthsFR(date("n")).' '.date('Y'),
                    'value'=> 0
                ];
            }else{
                $tmpMonth = date("n", strtotime("-1 month", strtotime($date_now)));

                if($tmpMonth == '12')
                {
                    $tmpYear = date("Y", strtotime("-1 year", strtotime($date_now)));
                }

                $newMonths[$i] = [
                    'name'=> $this->monthsFR($tmpMonth).' '.$tmpYear,
                    'value'=> 0
                ];
                $date_now = date($tmpYear."-".$tmpMonth."-d");

                if ($i === 5){
                    if ((int)$tmpMonth < 10){
                        $tmpMonth = "0".$tmpMonth;
                    }
                   $dateForSql = "01-".$tmpMonth."-".$tmpYear;
                }
            }
        }

        $data = $this->getSql($dateForSql, date("t", date("m")).date("-m-Y"), true);

        switch ($_POST['chart']){
            case 'sales':
                foreach ($data as $value){
                    $tmpSale = explode("-", $value["CreatedAt"])[1];
                    $tmpSale = explode(" ", $tmpSale)[0];
                    if ((int)$tmpSale < 10){
                        $tmpSale = substr($tmpSale, -1);
                    }

                    for ($i = 0; $i < count($newMonths); $i++){
                        if (explode(" ",$newMonths[$i]['name'])[0] === $this->monthsFR($tmpSale)){
                            $newMonths[$i]['value'] = $newMonths[$i]['value']+1;
                        }
                    }
                }
                break;
            case 'turnover':
                foreach ($data as $value){
                    $tmpSale = explode("-", $value["CreatedAt"])[1];
                    $tmpSale = explode(" ", $tmpSale)[0];
                    if ((int)$tmpSale < 10){
                        $tmpSale = substr($tmpSale, -1);
                    }

                    for ($i = 0; $i < count($newMonths); $i++){
                        if (explode(" ",$newMonths[$i]['name'])[0] === $this->monthsFR($tmpSale)){
                            $newMonths[$i]['value'] = $newMonths[$i]['value']+$value["montant"];
                        }
                    }
                }
                break;
            default:
                echo 'error';
                exit();
        }

        return array_reverse($newMonths);
    }

    public function year(){ //Récupération des données de l'année

        $data = $this->getSql("01-01-".date("Y"), "31-12-".date("Y"), true);

        for ($j = 0; $j < 12; $j++){
            $arrayData[$j] = [
                'name'=> $this->monthsFR($j+1).' '.date("Y"),
                'value'=> 0
            ];
        }

        switch ($_POST['chart']){
            case 'sales':
                foreach ($data as $value){
                    $tmpSale = explode("-", $value["CreatedAt"])[1];
                    $tmpSale = explode(" ", $tmpSale)[0];
                    if ((int)$tmpSale < 10){
                        $tmpSale = substr($tmpSale, -1);
                    }

                    for ($i = 0; $i < count($arrayData); $i++){
                        if (explode(" ",$arrayData[$i]['name'])[0] === $this->monthsFR($tmpSale)){
                            $arrayData[$i]['value'] = $arrayData[$i]['value']+1;
                        }
                    }
                }
                break;
            case 'turnover':
                foreach ($data as $value){
                    $tmpSale = explode("-", $value["CreatedAt"])[1];
                    $tmpSale = explode(" ", $tmpSale)[0];
                    if ((int)$tmpSale < 10){
                        $tmpSale = substr($tmpSale, -1);
                    }

                    for ($i = 0; $i < count($arrayData); $i++){
                        if (explode(" ",$arrayData[$i]['name'])[0] === $this->monthsFR($tmpSale)){
                            $arrayData[$i]['value'] = $arrayData[$i]['value']+$value["montant"];
                        }
                    }
                }
                break;
            default:
                echo 'error';
                exit();
        }

        return $arrayData;
    }

    public function all(){ //Récupération des données depuis le début
        $countAll = 0;

        $data = $this->getSql("","",false);
        if (!empty($data)){
            $firstDate = explode("-", $data[0]["CreatedAt"])[0];
        }else {
            $firstDate = date("Y");
        }

        for ($p = $firstDate; $p <= date("Y"); $p++){
            $arrayData[$countAll] = [
                'name'=> strval($p),
                'value'=> 0
            ];
            $countAll++;
        }
        switch ($_POST['chart']){
            case 'sales':
                foreach ($data as $value){
                    $tmpAll = explode("-", $value["CreatedAt"])[0];

                    for ($i = 0; $i < count($arrayData); $i++){
                        if ($arrayData[$i]['name'] === $tmpAll){
                            $arrayData[$i]['value'] = $arrayData[$i]['value']+1;
                        }
                    }
                }
                break;
            case 'turnover':
                foreach ($data as $value){
                    $tmpAll = explode("-", $value["CreatedAt"])[0];

                    for ($i = 0; $i < count($arrayData); $i++){
                        if ($arrayData[$i]['name'] === $tmpAll){
                            $arrayData[$i]['value'] = $arrayData[$i]['value']+$value["montant"];
                        }
                    }
                }
                break;
            default:
                echo 'error';
                exit();
        }

        return $arrayData;
    }

    public function monthsFR($oldMonth){ //Transformation du numéro du mois en texte
        switch ($oldMonth){
            case '1':
                return 'Janvier';
            case '2':
                return 'Février';
            case '3':
                return 'Mars';
            case '4':
                return 'Avril';
            case '5':
                return 'Mai';
            case '6':
                return 'Juin';
            case '7':
                return 'Juillet';
            case '8':
                return 'Août';
            case '9':
                return 'Septembre';
            case '10':
                return 'Octobre';
            case '11':
                return 'Novembre';
            case '12':
                return 'Décembre';
        }
        return false;
    }

    public function getSql($dateStart, $dateEnd, $withDate){ //Récupération des données depuis la BDD
        $orders = new modelOrders();
        if ($withDate === true){
            $dataSQL = $orders->select("CreatedAt, montant")->where("CreatedAt BETWEEN STR_TO_DATE(:dateStart, '%d-%m-%Y') AND STR_TO_DATE(:dateEnd, '%d-%m-%Y') AND status >= 1")->setParams(["dateStart" => $dateStart, "dateEnd" => $dateEnd])->get();
        }else{
            $dataSQL = $orders->select("CreatedAt, montant")->orderBy("CreatedAt", "ASC")->where("status >=1")->get();
        }
        return $dataSQL;
    }
}