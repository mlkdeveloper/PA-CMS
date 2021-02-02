<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Template de back</title>
	<meta name="description" content="description de la page de back">
    <link rel="stylesheet" href="../../dist/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <header>
        <div class="headerBack">
            <p></p>
            <h1>Header</h1>
            <button class="button button--blue">Deconnexion</button>
        </div>
        <div class="sidenav">
            <a href="#about">Dashboard</a>
            <a href="#services">Commandes</a>
            <a class="dropdown-btn">Produit
                <i class="fa fa-caret-down"></i>
            </a>
            <div class="dropdown-container">
                <a href="#">Categories</a>
                <a href="#">Promotions</a>
                <a href="#">Link 3</a>
            </div>
            <a href="#contact">Contact</a>
        </div>
    </header>
    <main class="main-doc">
        <!-- afficher la vue -->
        <?php include $this->view ?>
    </main>


</body>
<script>
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>

</html>