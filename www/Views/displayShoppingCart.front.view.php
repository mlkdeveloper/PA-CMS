<section>
    <div class="container">

        <div class="align">
            <h1>Panier</h1>
            <?php if(!empty($_SESSION['panier'])): ?>
            <button class="button button--blue">Procéder au paiement</button>
            <?php endif; ?>
        </div>

        <?php if(empty($_SESSION['panier'])): ?>
        <div>
            <p>Votre panier est vide.</p>
            <a href="/">Retourner vers la boutique</a>
        </div>
        <?php endif; ?>
    </div>
</section>
