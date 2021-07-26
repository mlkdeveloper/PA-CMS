<section>
    <div class="container">

        <div class="align">
            <h1>Panier</h1>
            <?php if(!empty($_SESSION['panier'])): ?>
                <?php if(empty($_SESSION['user'])): ?>
                    <button class="button button--blue"><a onclick="showModalConnexionStripe()">Procéder au paiement</a></button>
                <?php endif; ?>
                <?php if(!empty($_SESSION['user'])): ?>
                    <button class="button button--blue" id="checkStock"><a onclick="showModalCheckStockStripe()">Procéder au paiement</a></button>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php if(empty($_SESSION['panier'])): ?>
        <div>
            <p>Votre panier est vide.</p>
            <a href="/">Retourner vers la boutique</a>
        </div>
        <?php endif; ?>


        <?php if(!empty($_SESSION['panier'])): ?>

        <div class="row">
            <div class="col col-md-12 col-sm-12 col-lg-12">
                <div class="jumbotron">
                    <table id="table" class="row-border hover">
                        <thead>
                        <tr>
                            <th>Nom du produit</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($products as $product)  : ?>

                            <tr>

                                <td>
                                    <?= $product[0]['name'] . "<br>" ?>
                                    <?php foreach (array_map("current", $product) as $value)  :?>
                                        <?= $value . " "  ?>
                                    <?php endforeach; ?>
                                </td>
                                <td>€ <?= $product[0]['price'] ?></td>
                                <td><?= $_SESSION['panier'][$product[0]['id']] ?></td>
                                <td><?= $_SESSION['panier'][$product[0]['id']] *  $product[0]['price']  ?></td>
                                <td><a href="/supprimer-panier?id=<?= $product[0]['id'] ?>">Supprimer</a></td>

                            </tr>

                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div style="display: flex; justify-content: flex-end">
                    <h3> Total : <?= $_SESSION['panierTotal']?></h3>
                </div>
            </div>

            <?php endif; ?>
    </div>

        <div class="modal" id="modalConnexionStripe">
            <div class="modal-content">
                <h3>Vous devez être connecter pour pouvoir passer au paiement de votre commande</h3>
                <a id="buttonConnexionStripe"><button class="button button--success">Connexion</button></a>
                <button class="button button--alert" onclick="hideModalConnexionStripe()">Annuler</button>
            </div>
        </div>

        <div class="modal" id="modalCheckStockStripe">
            <div class="modal-content">
                <h3 id="titre-paiement"></h3>
                <p id="passage-paiement"></p>
                <p id="btnPaiementStripe">
                    <button class="button button--success" id="paiement-stripee">Paiement</button>
                    <button class="button button--alert" onclick="hideModalCheckStockStripe()">Fermer</button>

                </p>
            </div>
        </div>
        <input type="hidden" value="<?=PUBLICKEYSTRIPE ?>" id="publicKeyStripe">
</section>
<script type="text/javascript">
    var checkoutButton = document.getElementById("checkStock");

    checkoutButton.addEventListener("click", function () {
        $('#titre-paiement').val("")
        $.ajax({
            url: '/verification-stock-panier',
            error: function() {
                $('.msgConexion').remove()
                $('#titre-paiement').append('<p class="msgConexion">Erreur sur votre panier</p>')
                $('#passage-paiement').append("Certains produits de votre panier n'est plus en stock dans notre boutique. <br> Nous vous invitons à le supprimer de votre panier")
                $('#paiement-stripee').remove()
            },
            success: function(data) {
                $('.msgPaiement').remove()
                $('#titre-paiement').append('<p class="msgPaiement">Procéder au paiement</p>')
                $('#btnPaiementStripe button:first-child').attr('id', 'paiement-stripee')
            },
            type: 'GET'
        });
    });

    // Create an instance of the Stripe object with your publishable API key
    var publicKey = $('#publicKeyStripe').val();
    var stripe = Stripe(publicKey);
    var checkoutButton = document.getElementById("paiement-stripee");
    checkoutButton.addEventListener("click", function () {
        fetch("/create-checkout-session", {
            method: "POST",
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (session) {
                var pi = session.payment_intent

                $.ajax({
                    url: "/insert-payment-stripe",
                    type: 'GET',
                    data: {payment_intent: pi},
                    success:function(data) {},
                    error: function(request, status, error) {alert(request,status);}
                });
                return stripe.redirectToCheckout({ sessionId: session.id });
            })
            .then(function (result) {
                // If redirectToCheckout fails due to a browser or network
                // error, you should display the localized error message to your
                // customer using error.message.
                if (result.error) {
                    alert(result.error.message);
                }
            })
            .catch(function (error) {
                console.error("Error:", error);
            });
    });
</script>




<script src="../public/js/datatable.js"></script>
<script src="../public/js/stripe.js"></script>
