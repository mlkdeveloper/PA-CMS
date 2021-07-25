<div class="container">
    <div class="">
        <h1>Mes commandes</h1>
    </div>
    <div class="row">
        <div class="col col-md-12 col-sm-12 col-lg-12">
            <div class="jumbotron">
                <table id="table" class="row-border hover">
                    <thead>
                    <tr>
                        <th>N° Commande</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th class="thAction">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($orders as $order):
                        ?>
                        <tr>
                            <td><?= $order['id'] ?></td>
                            <td><?= $order['montant'] ?></td>
                            <td><?= \App\Core\Helpers::dateFr($order['CreatedAt'])?></td>
                            <td> <?php
                                    if ($order['status'] == -1){
                                        echo "Annulé";
                                    }if($order['status'] == 0){
                                        echo "En attente";
                                    }if($order['status'] == 1){
                                        echo "Validé";
                                    }if($order['status'] == 2){
                                        echo "Terminé";
                                    }?>
                                </td>
                            <td>
                                <button class="button button--black">
                                        <i class="fas fa-pencil-alt"></i>
                                        <a href="/ma-commande?id=<?= $order['id'] ?>">Détails</a>
                                </button>

                            </td>
                        </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>

<script src="../public/js/datatable.js"></script>
