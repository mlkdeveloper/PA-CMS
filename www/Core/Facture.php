<?php


namespace App\Core;

use App\Core\FPDF;
use App\Models\Orders;
use App\Models\Products as ProductModel;
use App\Models\Shop as ShopModel;
use App\Models\User as UserModel;
use App\Models\Product_term;
use App\Core\MyException;

session_start();

class Facture
{

    public function test($idUser = 20, $ordre){


        require('fpdf/fpdf.php');

        // On active la classe une fois pour toutes les pages suivantes
        // Format portrait (>P) ou paysage (>L), en mm (ou en points > pts), A4 (ou A5, etc.)
        $pdf = new FPDF('P','mm','A4');

        // Nouvelle page A4 (incluant ici logo, titre et pied de page)
        $pdf->AddPage($ordre);
        // Polices par défaut : Helvetica taille 9
        $pdf->SetFont('Helvetica','',9);
        // Couleur par défaut : noir
        $pdf->SetTextColor(0);
        // Compteur de pages {nb}
        $pdf->AliasNbPages();

        // Sous-titre calées à gauche, texte gras (Bold), police de caractère 11
        $pdf->SetFont('Helvetica','B',11);
        // couleur de fond de la cellule : gris clair
        $pdf->setFillColor(230,230,230);

        // Informations du magasin
        $shop = new ShopModel();
        $shop_data = $shop->select()->get();
        $shop_data = $shop_data[0];

        $pdf->Cell(75,6,$shop_data['name'],0,1,'L',1);
        $pdf->Cell(75,6,strtoupper(utf8_decode($shop_data['address'])),0,1,'L',1);
        $pdf->Cell(75,6,strtoupper(utf8_decode($shop_data['zipCode'].' '.$shop_data['city'])),0,1,'L',1);

        $pdf->Ln(10); // saut de ligne 10mm

        // Informations de l'utilisateur

        $user = new UserModel();
        $user_data = $user->select()->where('id = :id')->setParams(['id' => $idUser])->get();
        $user_data = $user_data[0];
        $pdf->SetX(125);
        $pdf->Cell(75,6,$user_data['lastname'] . ' ' . $user_data['firstname'],0,1,'L',1);
        $pdf->SetX(125);
        $pdf->Cell(75,6,strtoupper(utf8_decode($user_data['address'])),0,1,'L',1);
        $pdf->SetX(125);
        $pdf->Cell(75,6,strtoupper(utf8_decode($user_data['zipcode'].' '.$user_data['city'])),0,1,'L',1);

        $pdf->Ln(10); // saut de ligne 10mm


        $position_entete = 100;
        // police des caractères
        $pdf->SetFont('Helvetica','',9);
        $pdf->SetTextColor(0);
        // on affiche les en-têtes du tableau
        $pdf->entete_table($position_entete);



        $position_detail = 108; // Position ordonnée = $position_entete+hauteur de la cellule d'en-tête (60+8)

        $products_model = new Orders();
        $products_data = $products_model->select(DBPREFIXE."product_order.id_group_variant, " .DBPREFIXE."orders.id, " .DBPREFIXE."orders.CreatedAt, " .DBPREFIXE."orders.status, " .DBPREFIXE."orders.montant, " .DBPREFIXE."user.firstname, " .DBPREFIXE."user.lastname, " .DBPREFIXE."user.email"  )
            ->innerJoin(DBPREFIXE."product_order",DBPREFIXE."orders.id","=",DBPREFIXE."product_order.id_order")
            ->innerJoin(DBPREFIXE."user",DBPREFIXE."orders.User_id","=",DBPREFIXE."user.id")
            ->where(DBPREFIXE."product_order.id_order = :id")->setParams(['id' => $_GET['id']])->get();

        $array = [];

        foreach ($products_data as $value){
            $productTerm = new Product_term();
            array_push($array,$productTerm->select(DBPREFIXE."terms.name AS nameTerm, ".DBPREFIXE."group_variant.id, ".DBPREFIXE."products.name, ".DBPREFIXE."group_variant.price ")
                ->innerJoin(DBPREFIXE."group_variant",DBPREFIXE."product_term.idGroup ","=",DBPREFIXE."group_variant.id")
                ->innerJoin(DBPREFIXE."products",DBPREFIXE."product_term.idProduct ","=",DBPREFIXE."products.id")
                ->innerJoin(DBPREFIXE."terms",DBPREFIXE."product_term.idTerm ","=",DBPREFIXE."terms.id")
                ->where(DBPREFIXE."product_term.idGroup = :idGroup")->setParams(["idGroup" => $value['id_group_variant']])->get());
        }

        foreach ($array as $product) {
            // position abcisse de la colonne 1 (10mm du bord)
            $pdf->SetY($position_detail);
            $pdf->SetX(10);
            $pdf->Cell(20,8,($product[0]['name']),1,'C');

            // position abcisse de la colonne 2 (70 = 10 + 60)
            $proprieties = 0;
            foreach (array_map("current", $product) as $value){
                $proprieties .= ' '. $value;
            }

            $pdf->SetY($position_detail);
            $pdf->SetX(30);
            $pdf->Cell(90,8,utf8_decode($product[0]['name'] . $proprieties),1,'C');

            // position abcisse de la colonne 3 (130 = 70+ 60)
            $pdf->SetY($position_detail);
            $pdf->SetX(120);
            $pdf->Cell(40,8, $_SESSION['panier'][$product[0]['id']],1,'C');

            $pdf->SetY($position_detail);
            $pdf->SetX(160);
            $pdf->Cell(40,8,$_SESSION['panier'][$product[0]['id']] *  $product[0]['price'] ,1,0,'C');

            // on incrémente la position ordonnée de la ligne suivante (+8mm = hauteur des cellules)
            $position_detail += 8;
        }

        // Nouvelle page PDF
        $pdf->AddPage($ordre);
        // Polices par défaut : Helvetica taille 9
        $pdf->SetFont('Helvetica','',11);
        // Couleur par défaut : noir
        $pdf->SetTextColor(0);
        // Compteur de pages {nb}
        $pdf->AliasNbPages();
        $pdf->Cell(500,20,utf8_decode('Plus rien à vous dire ;-)'));

        $pdf->Output('facture.pdf','I');

    }

}