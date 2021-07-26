<div class="container">

    <div class="align">
        <h1>Récapitulatif de la commande #<?= $order[0]['id']?></h1>
        <div>

            <?php if($order[0]['status'] == 0):?>
                <button class="button button--alert">
                    <a onclick="showModalCancelCommand(<?= $_GET['id'] ?>)">Annuler la commande</a>
                </button>
                <button class="button button--blue">
                    <a onclick="showModalValidCommand(<?= $_GET['id'] ?>)">Valider la commande</a>
                </button>

            <?php endif;?>

            <?php if($order[0]['status'] == 1):?>
                <button class="button button--blue">
                    <a onclick="showModalDoneCommand(<?= $_GET['id'] ?>)">Terminer la commande</a>
                </button>
            <?php endif;?>


        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="jumbotron ">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h3>Statut : <?php
                            if ($order[0]['status'] == -1){
                                echo "Annulé";
                            }if($order[0]['status'] == 0){
                                echo "En attente";
                            }if($order[0]['status'] == 1){
                                echo "Validé";
                            }if($order[0]['status'] == 2){
                                echo "Terminé";
                            }?></h3>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <p>Montant total du panier : <?= $order[0]['montant'] ?> €</p>
                        <p>Commande passée le : <?= \App\Core\Helpers::dateFr($order[0]['CreatedAt'])?></p>
                        <p>Par : <?= $order[0]['firstname'].' '.$order[0]['lastname']. ' ('.  $order[0]['email']. ')'?></p>
                    </div>
                </div>
                <div class="align">
                    <div>
                        <a class="button button--blue " href="/facture?id=<?= $order[0]['id'] ?>" > Facture</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12 col-sm-12 col-lg-12">
            <div class="jumbotron">
                <table id="table" class="row-border hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prix</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php  foreach ($products as $product): ?>
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
            <h3>Voulez-vous valider la commande ?</h3>
            <a id="buttonValidCommand"><button class="button button--success">Oui</button></a>
            <button class="button button--alert" onclick="hideModalValidCommand()">Non</button>
        </div>
    </div>
    <div class="modal" id="modalDoneCommand">
        <div class="modal-content">
            <h3>Voulez-vous terminer la commande ?</h3>
            <a id="buttonDoneCommand"><button class="button button--success">Oui</button></a>
            <button class="button button--alert" onclick="hideModalDoneCommand()">Non</button>
        </div>
    </div>

</div>

<script src="../public/js/datatable.js"></script>
<script src="../public/js/commande.js" type="text/javascript"></script>

