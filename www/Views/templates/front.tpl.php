<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
    <title><?= $title ?></title>
	<meta name="description" content="description de la page de front">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="../../src/js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../../dist/main.css">
    <link rel="stylesheet" href="../../dist/pageFronts.css">
</head>
<body>

    <header>
        <span id="hamburger">
                <i class="fas fa-bars"></i>
        </span>
        <nav id="main-nav">
            <div>
                <ul>
                    <li><img src="../../images/logo/logo.png" alt="Logo" width="50"></li>
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
                                    foreach ($category as $valueCategory):
                                        if ($value["category"] == $valueCategory['id']){
                                            echo '/collections?name='.$valueCategory['name'];
                                        }
                                    endforeach;
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
                                        foreach ($category as $valueCategory):
                                            if ($valueTab["category"] == $valueCategory['id']){
                                                echo '/collections?name='.$valueCategory['name'];
                                            }
                                        endforeach;
                                    }
                                    echo '">'.$valueTab["name"].'</a></li>';
                                }
                            endforeach;
                            echo '</ul></li>';
                        }
                    endforeach; ?>
                </ul>
                <ul>
                   <li><a href="/panier">Panier &nbsp<i class="fa fa-shopping-cart"></i></a></li>
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