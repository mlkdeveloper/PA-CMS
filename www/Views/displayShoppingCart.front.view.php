<section>
    <div class="container">

        <div class="align">
            <h1>Panier</h1>
            <?php if(!empty($_SESSION['panier'])): ?>
                <?php if(empty($_SESSION['user'])): ?>
                    <button class="button button--blue"><a onclick="showModalConnexionStripe()">Procéder au paiement</a></button>
                <?php endif; ?>
                <?php if(!empty($_SESSION['user'])): ?>
                    <button class="button button--blue" id="paiement-stripe">Procéder au paiement</button>
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
            <div class="col-md-12 col-sm-12">
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

                        <?php foreach ($products as $product)  :?>
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
</section>
<script type="text/javascript">
    // Create an instance of the Stripe object with your publishable API key
    var stripe = Stripe("pk_test_51JC0puGueu1Z1r2S3oq9aEovJmlKpYwQ8isyViEyKtwQrLXIEZBdOVeXiihXPpi4EtJHkTd53Whc5F6J7TNxLEQz00XaTk67k0");
    var checkoutButton = document.getElementById("paiement-stripe");

    checkoutButton.addEventListener("click", function () {
        fetch("/create-checkout-session", {
            method: "POST",
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (session) {
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
