<?php


namespace App\Core;

use App\Core\FPDF;

class Facture
{

    public function test(){


        require('fpdf/fpdf.php');

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Hello World !');
        $pdf->Output();


    }

}