<div class="container">
    <div class="align">
        <h1>Liste des pages</h1>
        <a href="/admin/nouvelle-page" class="button button--blue">Ajouter une page</a>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col">
            <div class="jumbotron">
                <table id="table" class="row-border hover">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Date de création</th>
                        <th>Chemin d'accès</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    foreach ($array as $value):
                        ?>
                        <tr>
                            <td><?= $value['name'] ?></td>
                            <td><?= $value['createdAt'] ?></td>
                            <td><?= $value['slug'] ?></td>
                            <td>
                                <div>
                                    <a href="/admin/modification-page?id=<?= $value['id'] ?>"
                                       class="button button--blue">
                                        <i class="fas fa-pencil-alt"></i>Modifier
                                    </a>
                                    <a href="/admin/publisher?name=<?= $value['name'] ?>" class="button button--blue">
                                        <i class="fas fa-eye"></i>Voir la page
                                    </a>
                                    <i class="fas fa-trash" onclick="showModalDeletePage(<?= $value['id'] ?>, '<?= $value['name'] ?>')"></i>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal" id="modalDeletePage">
        <div class="modal-content">
            <h3>Voulez-vous vraiment supprimer cette page ?</h3>
            <a id="buttonDeletPage"><button class="button button--success">Oui</button></a>
            <button class="button button--alert" onclick="hideModalDeletePage()">Non</button>
        </div>
    </div>
</div>

<script src="../public/js/datatable.js"></script>
<script src="../public/js/pages.js" type="text/javascript"></script>