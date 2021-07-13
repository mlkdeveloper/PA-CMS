<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
    <title><?= $title ?></title>
	<meta name="description" content="description de la page de front">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="../../src/js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../../dist/main.css">
    <link rel="stylesheet" href="../../dist/pageFronts.css">
</head>
<body>

    <header>
        <nav id="main-nav">
            <div>
            <ul>
                <?php
                foreach ($navbar as $value):
                    if ($value['status'] == 0){
                        echo '<li><a href="';
                            if (isset($value['page'])){
                                foreach ($pages as $valuePage):
                                    if ($value["page"] == $valuePage['id']){
                                        echo $valuePage['slug'];
                                    }
                                endforeach;
                            }else{
                                echo $value["category"];
                            }
                        echo '">'.$value["name"].'</a></li>';
                    }else {
                        echo '<li class="dropdownMenuFront"><a>'.$value["name"].'&nbsp<i class="fa fa-caret-down"></i></a>';
                        echo '<ul class="submenu">';
                        foreach ($tabNavbar as $valueTab):
                            if ($valueTab['navbar'] == $value['id']){
                                echo '<li><a href="';
                                if (isset($valueTab['page'])){
                                    foreach ($pages as $valuePage):
                                        if ($valueTab["page"] == $valuePage['id']){
                                            echo $valuePage['slug'];
                                        }
                                    endforeach;
                                }else{
                                    echo $valueTab["category"];
                                }
                                echo '">'.$valueTab["name"].'</a></li>';
                            }
                        endforeach;
                        echo '</ul></li>';
                    }
                endforeach; ?>
            </ul>
                <ul>
                   <li><a href="/panier">Panier <i class="fa fa-shopping-cart"></i></a></li>
                </ul>
            </div>
        </nav>
    </header>


    <main>



	<!-- afficher la vue -->
	<?php include $this->view ?>

    </main>



</body>

</html>