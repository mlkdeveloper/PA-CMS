<div class="container">
    <div class="align">

        <h1>Ma commande #<?= $order[0]['id'] ?>  </h1>

        <?php if($order[0]['status'] == 0) : ?>
            <a href="/annuler-commande?id=<?= $order[0]['id'] ?>  "><button class="button button--alert">Annuler ma commande</button></a>
        <?php endif; ?>
    </div>

    <div class="">
        <p>Statut de la commande : <?php
            if ($order[0]['status'] == -1){
                echo "Annulé";
            }if($order[0]['status'] == 0){
                echo "En attente";
            }if($order[0]['status'] == 1){
                echo "Validé";
            }if($order[0]['status'] == 2){
                echo "Terminé";
            }?>
        </p>
        <p>Date : <?= \App\Core\Helpers::dateFr($order[0]['CreatedAt'])?></p>
        <p>Total : € <?= $order[0]['montant']?></p>

        <a class="button button--blue" href="/facture?id=<?= $order[0]['id'] ?>" > Facture</a>
    </div>


    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="jumbotron">
                <table id="table" class="row-border hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Produits</th>
                        <th>Prix</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product)  :?>
                        <tr>
                            <td>#<?= $product[0]['id'] ?></td>
                            <td>
                                <?= $product[0]['name'] . "<br>" ?>
                                <?php foreach (array_map("current", $product) as $value)  :?>
                                    <?= $value . " "  ?>
                                <?php endforeach; ?>
                            </td>
                            <td>€ <?= $product[0]['price'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="../public/js/datatable.js"></script>
