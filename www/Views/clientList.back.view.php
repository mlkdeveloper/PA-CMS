<div class="container">

    <?php if(isset($_SESSION['deleteClient'])):?>
        <div class="alert alert--green"><?= $_SESSION['deleteClient']?></div>
        <?php unset($_SESSION['deleteClient']); ?>
    <?php endif;?>


    <div class="align">
        <h1>Liste des clients</h1>
        <button class="button button--blue">
            <a href="/admin/ajout-client">Nouveau client</a>
        </button>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="jumbotron">
                <table id="table" class="row-border hover">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th style="width: 150px">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php  foreach ($array as $client): ?>
                        <tr>
                            <td><?= $client['firstname'] ?></td>
                            <td><?= $client['lastname'] ?></td>
                            <td><?= $client['email'] ?></td>
                            <td><?= $client['phoneNumber'] ?></td>
                            <td>
                                <div class="align">
                                    <button class="button button--black">
                                        <i class="fas fa-pencil-alt"></i>
                                        <a href="/admin/modification-client?id=<?= $client['id'] ?>">Modifier</a>
                                    </button>
                                    <i class="fas fa-trash" onclick="showModalDeleteClient(<?= $client['id'] ?>)"></i>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal" id="modalDeleteClient">
        <div class="modal-content">
            <h3>Voulez-vous vraiment supprimer ce client ?</h3>
            <a id="buttonDeleteClient"><button class="button button--success">Oui</button></a>
            <button class="button button--alert" onclick="hideModalDeleteClient()">Non</button>
        </div>
    </div>



</div>

<script src="../public/js/datatable.js"></script>
<script src="../public/js/user.js" type="text/javascript"></script>

