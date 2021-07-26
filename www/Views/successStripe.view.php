

<div class="container">
    <div class="row centered">
        <div class="col-md-10 col-sm-12">
            <div class="jumbotron">
                <?php
                if ($_SESSION['errorPanier'] != null){
                    echo '<div class="alert alert--red">' . $_SESSION['errorPanier'] . '</div>'; ?>
                    <section class="centered">
                        <p>
                            Nous recontrons un problème sur votre commande. <br>
                            Un ou plusieurs produit ne sont plus dispnible en stock. <br>
                            Nous sommes dans le regret de vous informer que votre commande à été annulé
                        </p>
                    </section>
                <?php
                }else{
                ?>
                <section class="centered">
                    <p>
                        Commande enregistré avec succes ! <br>
                        Vous receverez un mail lorsque vos produits seront prêt à être récuperer. <br> <br>
                        <button class="button button--blue">
                            <a href="/mes-commandes">Mes commandes</a>
                        </button>
                    </p>
                </section>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

