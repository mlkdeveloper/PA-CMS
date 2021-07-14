<div class="container">

    <div class="align">
        <h1>Liste des produits</h1>
        <button class="button button--blue">
            <a href="/admin/nouvelle-categorie">Ajouter une catégorie</a>
        </button>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="jumbotron">
                <table id="table" class="row-border hover">
                    <thead>
                    <tr>
                        <th>N° catégorie</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Variants</th>
                        <th>Publié</th>
                        <th class="thAction">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($produits as $produit):
                    ?>
                    <tr>
                        <td><?= $produit['id'] ?></td>
                        <td><?= $produit['name'] ?></td>
                        <td><?= $produit['description'] ?></td>
                        <td><?= $produit['type'] ? "Oui" : "Non" ?></td>
                        <td><?= $produit['isPublished'] ?></td>
                        <td>
                            <button class="button button--black">
                                <i class="fas fa-pencil-alt"></i>
                                <a href="/admin/modification-produit?id=<?= $produit['id'] ?>">Modifier</a>
                            </button>

                            <button class="button button--warning">
                                <i class="fas fa-info"></i>
                                <a href="/admin/information-produit?id=<?= $produit['id'] ?>">Informations</a>
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