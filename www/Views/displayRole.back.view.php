<div class="container">

    <?php if(isset($_SESSION['successDeleteRole'])):?>
            <div class="alert alert--green"><?= $_SESSION['successDeleteRole']?></div>
            <?php unset($_SESSION['successDeleteRole']); ?>
    <?php endif;?>

    <?php if(isset($_SESSION['errorDeleteRole'])):?>
        <div class="alert alert--red"><?= $_SESSION['errorDeleteRole']?></div>
        <?php unset($_SESSION['errorDeleteRole']); ?>
    <?php endif;?>

    <div class="align">
        <h1>Liste des rôles</h1>
        <button class="button button--blue">
            <a href="/admin/nouveau-role">Créer un rôle</a>
        </button>
    </div>
    <div class="row">
        <div class="col col-md-12 col-sm-12 col-lg-12">
            <div class="jumbotron">
                <table id="table" class="row-border hover">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th style="width: 150px">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($listRoles as $value):
                        ?>
                        <tr>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['name'] ?></td>

                            <td>
                                <a class="button button--black" href="/admin/modification-role?id=<?= $value['id'] ?>"><i class="fas fa-pencil-alt"></i></a>
                                <button class="button button--alert">
                                    <i class="fas fa-trash" onclick="showModalDeleteRole(<?= $value['id'] ?>)"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal" id="modalDeleteRole">
        <div class="modal-content">
            <h3>Voulez-vous vraiment supprimer ce rôle ?</h3>
            <a id="buttonDeleteRole"><button class="button button--success">Oui</button></a>
            <button class="button button--alert" onclick="hideModalDeleteRole()">Non</button>
        </div>
    </div>


</div>

<script src="../public/js/datatable.js"></script>
<script src="../public/js/role.js" type="text/javascript"></script>
