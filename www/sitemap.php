<?php
namespace App;
use App\Core\ConstantManager;
use App\Models\Category;
use App\Models\Pages;
use App\Models\Products;

require "Autoload.php";
Autoload::register();

new ConstantManager();
$page = new Pages();
$category = new Category();
$product = new Products();
$categories = $category->select("name")->where("status = 0")->get();
$pages = $page->select("slug")->where("publication = 1")->get();
$products = $product->select("id")->where("status = 1")->get();

header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';


foreach ($pages as $page){

    echo'<url>';
    echo'<loc>'.$_SERVER["HTTP_HOST"]. $page['slug'] . '</loc>';
    echo' <priority>1.0</priority>';
    echo '<changefreq>monthly</changefreq>';
    echo' </url>';
}


foreach ($categories as $category){

    echo'<url>';
    echo '<loc>'. $_SERVER["HTTP_HOST"]. '/collections?name=' . $category['name'] . '</loc>';
    echo' <priority>1.0</priority>';
    echo '<changefreq>monthly</changefreq>';
    echo' </url>';
}

foreach ($products as $product){

    echo'<url>';
    echo '<loc>'. $_SERVER["HTTP_HOST"]. '/produit?id=' . $product['id'] . '</loc>';
    echo' <priority>1.0</priority>';
    echo '<changefreq>monthly</changefreq>';
    echo' </url>';
}


echo'<url>';
echo '<loc>'. $_SERVER["HTTP_HOST"]. '/connexion</loc>';
echo' <priority>1.0</priority>';
echo '<changefreq>monthly</changefreq>';
echo' </url>';

echo'<url>';
echo '<loc>'. $_SERVER["HTTP_HOST"]. '/deconnexion</loc>';
echo' <priority>1.0</priority>';
echo '<changefreq>monthly</changefreq>';
echo' </url>';

echo'<url>';
echo '<loc>'. $_SERVER["HTTP_HOST"]. '/connexion-admin</loc>';
echo' <priority>1.0</priority>';
echo '<changefreq>monthly</changefreq>';
echo' </url>';

echo'<url>';
echo '<loc>'. $_SERVER["HTTP_HOST"]. '/inscription</loc>';
echo' <priority>1.0</priority>';
echo '<changefreq>monthly</changefreq>';
echo' </url>';

echo'<url>';
echo '<loc>'. $_SERVER["HTTP_HOST"]. '/mot-de-passe-oublie</loc>';
echo' <priority>1.0</priority>';
echo '<changefreq>monthly</changefreq>';
echo' </url>';

echo'<url>';
echo '<loc>'. $_SERVER["HTTP_HOST"]. '/recuperation-mot-de-passe</loc>';
echo' <priority>1.0</priority>';
echo '<changefreq>monthly</changefreq>';
echo' </url>';

echo'<url>';
echo '<loc>'. $_SERVER["HTTP_HOST"]. '/confirmation-inscription</loc>';
echo' <priority>1.0</priority>';
echo '<changefreq>monthly</changefreq>';
echo' </url>';

echo'<url>';
echo '<loc>'. $_SERVER["HTTP_HOST"]. '/panier</loc>';
echo' <priority>1.0</priority>';
echo '<changefreq>monthly</changefreq>';
echo' </url>';

echo'<url>';
echo '<loc>'. $_SERVER["HTTP_HOST"]. '/mes-commandes</loc>';
echo' <priority>1.0</priority>';
echo '<changefreq>monthly</changefreq>';
echo' </url>';

echo'<url>';
echo '<loc>'. $_SERVER["HTTP_HOST"]. '/ma-commande</loc>';
echo' <priority>1.0</priority>';
echo '<changefreq>monthly</changefreq>';
echo' </url>';

echo'<url>';
echo '<loc>'. $_SERVER["HTTP_HOST"]. '/mon-profil</loc>';
echo' <priority>1.0</priority>';
echo '<changefreq>monthly</changefreq>';
echo' </url>';

echo '</urlset>';