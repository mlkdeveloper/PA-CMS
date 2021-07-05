<div class="container">

    <?php if(isset($errors)):?>
        <div class="alert alert--red"><?= $errors?></div>
    <?php endif;?>
    <div class="align">
        <h1>Récapitulatif de la commande #<?= $_GET['id']?></h1>
        <button class="button button--alert">
            <a onclick="showModalCancelCommand(<?= $_GET['id'] ?>)">Annuler la commande</a>
        </button>
        <button class="button button--blue">
            <a onclick="showModalValidCommand(<?= $_GET['id'] ?>)">Valider la commande</a>
        </button>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="jumbotron">
                <table id="table" class="row-border hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Carateristique</th>
                        <th>Prix</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php  foreach ($array as $product): ?>
                        <tr>
                            <td><?= $product['idProductOrder'] ?></td>
                            <td><?= $product['productName'] ?></td>
                            <td><?= $product['termName'] ?></td>
                            <td><?= $product['variantPrice'] ?> €</td>
                        </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal" id="modalCancelCommand">
        <div class="modal-content">
            <h3>Voulez-vous annuler la commande ?</h3>
            <p>L'annulation entrainera le remboursement intégral de la commande</p>
            <a id="buttonCancelCommand"><button class="button button--success">Oui</button></a>
            <button class="button button--alert" onclick="hideModalCancelCommand()">Non</button>
        </div>
    </div>

    <div class="modal" id="modalValidCommand">
        <div class="modal-content">
            <h3>Voulez-vous Valider la commande ?</h3>
            <a id="buttonValidCommand"><button class="button button--success">Oui</button></a>
            <button class="button button--alert" onclick="hideModalValidCommand()">Non</button>
        </div>
    </div>

</div>

<script src="../public/js/datatable.js"></script>
<script src="../public/js/commande.js" type="text/javascript"></script>

