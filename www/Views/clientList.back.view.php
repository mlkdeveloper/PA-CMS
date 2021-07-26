<div class="container">

    <?php if(isset($_SESSION['deleteClient'])):?>
        <div class="alert alert--green"><?= $_SESSION['deleteClient']?></div>
        <?php unset($_SESSION['deleteClient']); ?>
    <?php endif;?>


    <div class="align">
        <h1>Liste des clients</h1>
        <a href="/admin/ajout-client">
            <button class="button button--blue">Nouveau client</button>
        </a>
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
                        <th>N° de téléphone</th>
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
                                <a class="button button--black" href="/admin/modification-client?id=<?= $client['id'] ?>"><i class="fas fa-pencil-alt"></i></a>
                                <button class="button button--alert">
                                    <i class="fas fa-trash" onclick="showModalDeleteClient(<?= $client['id'] ?>)"></i>
                                </button>
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

