<div class="container">

    <?php if(isset($errors)):?>
        <div class="alert alert--red"><?= $errors?></div>
    <?php endif;?>
    <div class="align">
        <h1>Récapitulatif de la commande #<?= $_GET['id']?></h1>
        <button class="button button--alert">
            <a onclick="showModalCancelCommand(<?= $_GET['id'] ?>)">Annuler la commande</a>
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
                        <th>Prix</th>
                        <th style="width: 150px">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php  foreach ($array as $product): ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td><?= $product['User_id'] ?></td>
                            <td>*Sum montant*</td>

                            <td>
                                <div>
                                    <button class="button button--black">
                                        <i class="fas fa-search"></i>
                                        <a href="/admin/detail-commande?id=<?= $product['id'] ?>">Voir plus</a>
                                    </button>
                                </div>
                            </td>
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

</div>

<script src="../public/js/datatable.js"></script>
<script src="../public/js/commande.js" type="text/javascript"></script>

