<?php


namespace App\Controller;

use App\Core\FPDF;
use App\Core\ShoppingCart as Panier;
use App\Models\Orders;
use App\Models\Orders as OrderModel;
use App\Models\Product_order;
use App\Models\Products as ProductModel;
use App\Models\Shop as ShopModel;
use App\Models\User as UserModel;
use App\Models\Product_term;
use App\Core\MyException;
require('fpdf/fpdf.php');


class Facture
{
    public function factureAction(){

        session_start();

        if (isset($_GET['id']) && !empty($_GET['id'])) {

            $order = new Orders();
            $checkId = $order->select('id')->where("id = :id")->setParams(['id' => $_GET['id']])->get();

            if (empty($checkId)){
                if($_SESSION['user']['id_role'] == 2){
                    header("Location: /mes-commandes");
                    exit();
                } else if($_SESSION['user']['id_role'] == 1){
                    header("Location: /admin/liste-commande");
                    exit();
                }
            }

            $orderModel = new OrderModel();
            $ordre = $orderModel->select()->where('id = :id')->setParams([':id' => $_GET['id']])->get();
            $ordre = $ordre[0];


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

            $pdf->Cell(75,6,$shop_data['name'],0,1,'L');
            $pdf->Cell(75,6,utf8_decode($shop_data['address']),0,1,'L');
            $pdf->Cell(75,6,strtoupper(utf8_decode($shop_data['zipCode'].' '.$shop_data['city'])),0,1,'L');

            $pdf->Ln(10); // saut de ligne 10mm

            // Informations de l'utilisateur

            $user = new UserModel();
            $user_data = $user->select()->where('id = :id')->setParams(['id' => $_SESSION['user']['id']])->get();
            $user_data = $user_data[0];
            $pdf->SetX(125);
            $pdf->Cell(75,6,$user_data['lastname'] . ' ' . $user_data['firstname'],0,1,'L');
            $pdf->SetX(125);
            $pdf->Cell(75,6,utf8_decode($user_data['address']),0,1,'L');
            $pdf->SetX(125);
            $pdf->Cell(75,6,strtoupper(utf8_decode($user_data['zipcode'].' '.$user_data['city'])),0,1,'L');

            $pdf->Ln(10); // saut de ligne 10mm


            $position_entete = 100;
            // police des caractères
            $pdf->SetFont('Helvetica','',9);
            $pdf->SetTextColor(0);
            // on affiche les en-têtes du tableau
            $pdf->entete_table($position_entete);



            $position_detail = 108; // Position ordonnée = $position_entete+hauteur de la cellule d'en-tête (60+8)

            //DETAILS DE LA COMMANDE
            $products_model = new Orders();
            $products_data = $products_model->select(DBPREFIXE."product_order.id_group_variant, " .DBPREFIXE."orders.id, " .DBPREFIXE."orders.CreatedAt, " .DBPREFIXE."orders.status, " .DBPREFIXE."orders.montant, " .DBPREFIXE."user.firstname, " .DBPREFIXE."user.lastname, " .DBPREFIXE."user.email"  )
                ->innerJoin(DBPREFIXE."product_order",DBPREFIXE."orders.id","=",DBPREFIXE."product_order.id_order")
                ->innerJoin(DBPREFIXE."user",DBPREFIXE."orders.User_id","=",DBPREFIXE."user.id")
                ->orderBy(DBPREFIXE."product_order.id_group_variant", 'ASC')
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

            $quantityModel = new Product_order();

            foreach ($array as $key => $product) {
                $quantity = $quantityModel->select('id')
                    ->where('id_order = :order', 'id_group_variant = :variant')
                    ->setParams(['order' => $_GET['id'], 'variant' => $product[0]['id']])
                    ->get();
                $array[$key]['quantity'] = count($quantity);
            }

            $unique =  array_unique($array, SORT_REGULAR);

            foreach ($unique as $key => $product) {
                // position abcisse de la colonne 1 (10mm du bord)
                $pdf->SetY($position_detail);
                $pdf->SetX(10);
                $pdf->Cell(20,8, $product['quantity'],1,0,'C');

                //Récupérer les attributs d'un produit
                $attributs = "";
                foreach ($product as $value){
                    $attributs .= $value['nameTerm']." " ;
                }

                // position abcisse de la colonne 2 (70 = 10 + 60)
                $pdf->SetY($position_detail);
                $pdf->SetX(30);
                $pdf->Cell(90,8,utf8_decode($product[0]['name']) .' '.utf8_decode($attributs) ,1,0, 'C');

                // position abcisse de la colonne 3 (130 = 70+ 60)
                $pdf->SetY($position_detail);
                $pdf->SetX(120);
                $pdf->Cell(40,8, $product[0]['price'],1,0, 'C');

                $pdf->SetY($position_detail);
                $pdf->SetX(160);
                $pdf->Cell(40,8, $product[0]['price']  *  $product['quantity'], 1,0,'C');

                // on incrémente la position ordonnée de la ligne suivante (+8mm = hauteur des cellules)
                $position_detail += 8;
            }

            $nombre_format_francais = "Total : " . number_format($products_data[0]['montant'], 2, ',', ' ') . chr(128); //chr(128) = €
            $pdf->SetY($position_detail);
            $pdf->SetX(120);
            $pdf->Cell( 80, 8, $nombre_format_francais, 1, 0, 'R');

            $pdf->Output('facture.pdf','I');

        } else {
            if($_SESSION['user']['id_role'] == 2){
                header("Location: /mes-commandes");
                exit();
            } else if($_SESSION['user']['id_role'] == 1){
                header("Location: /admin/liste-commande");
                exit();
            }
        }

    }

}