<section>
    <div class="container">

        <?php if(isset($_SESSION['deleteUser'])):?>
            <div class="alert alert--green"><?= $_SESSION['deleteUser']?></div>
            <?php unset($_SESSION['deleteUser']); ?>
        <?php endif;?>

        <div class="align">
            <h1>Liste des utilisateurs</h1>
            <button class="button button--blue">
                <a href="/admin/ajout-utilisateur">Créer un utilisateur</a>
            </button>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="jumbotron">
                    <table id="table" class="row-border hover">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($users as $user):
                            ?>
                            <tr>
                                <td><?= $user['lastname'] ?></td>
                                <td><?= $user['firstname'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['name'] ?></td>

                                <td>
                                    <a class="button button--black" href="/admin/modification-utilisateur?id=<?= $user['id'] ?>"><i class="fas fa-pencil-alt"></i></a>
                                    <button class="button button--alert">
                                        <i class="fas fa-trash" onclick="showModalDeleteUser(<?= $user['id'] ?>)"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach;?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal" id="modalDeleteUser">
            <div class="modal-content">
                <h3>Voulez-vous vraiment supprimer cet utilisateur définitivement ?</h3>
                <a id="buttonDeleteUser"><button class="button button--success">Oui</button></a>
                <button class="button button--alert" onclick="hideModalDeleteUser()">Non</button>
            </div>
        </div>
    </div>
</section>


<script src="../public/js/datatable.js"></script>
<script src="../public/js/user.js" type="text/javascript"></script>
