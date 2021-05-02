<?php


namespace App\Controller;

use App\Core\View;
use App\Models\Pages as modelPages;


class Dashboard
{


    public function dashboardAction(){
        $view = new View("dashboard.back", "back");
        $view->assign("title", "Dashboard");
    }

    public function getDataAction(){

        $pages = new modelPages();

        $arrayTest = $pages->select("createdAt")->get();


        switch ($_POST['type']){
            case 'month':
                $arrayData = $this->month($arrayTest);
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

    public function month($data){

        for ($p = 1; $p <= date("t", date("m")); $p++){
            $arrayData[$p-1] = [
                'name'=> $p,
                'value'=> 0
            ];
        }

        switch ($_POST['chart']){
            case 'sales':
                foreach ($data as $value){
                    $tmpSale = explode("-", $value["createdAt"])[2];
                    $tmpSale = explode(" ", $tmpSale)[0];//LIGNE A SUPPRIMER
                    $arrayData[$tmpSale-1]['value'] = $arrayData[$tmpSale-1]['value']+1;
                }
                break;
            case 'turnover':
                break;
            default:
                echo 'error';
                exit();
        }


        return $arrayData;
    }

    public function months(){
        $newMonths = [];
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
            }
        }
        return array_reverse($newMonths);
    }

    public function year(){

        for ($j = 0; $j < 12; $j++){
            $arrayData[$j] = [
                'name'=> $this->monthsFR($j+1).' '.date("Y"),
                'value'=> 0
            ];
        }

        return $arrayData;
    }

    public function all(){

    }

    public function monthsFR($oldMonth){
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

    public function getSql(){

    }
}