<div class="container">

    <div class="align">
        <h1>Liste des produits</h1>
        <a class="button button--blue" href="/admin/ajout-produit">Ajouter un produit</a>
    </div>
    <div class="row">
        <div class="col col-md-12 col-sm-12 col-lg-12">
            <div class="jumbotron">
                <table id="table" class="row-border hover">
                    <thead>
                    <tr>
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
                        <td><?= $produit['name'] ?></td>
                        <td><?= $produit['description'] ?></td>
                        <?= $produit['type'] ? "<td class='alert--green'>Oui</td>" : "<td class='alert--red'>Non</td>" ?>
                        <?= $produit['isPublished'] ? "<td class='alert--green'>Oui</td>" : "<td class='alert--red'>Non</td>" ?>
                        <td>
                            <a class="button button--black" href="/admin/modification-produit?id=<?= $produit['id'] ?>"><i class="fas fa-pencil-alt"></i></a>

                            <a class="button button--blue" href="/admin/information-produit?id=<?= $produit['id'] ?>"><i class="fas fa-info"></i></a>
                            
                            <a class="button button--alert" href="/admin/del-product?id=<?= $produit['id'] ?>"><i class="fas fa-trash"></i></a>

                            <?php if($produit["isPublished"] == 0):?>
                                <a class="button button--success" href="/admin/publish-product?id=<?= $produit['id'] ?>"><i class="fas fa-check"></i></a>
                            <?php else: ?>
                                <a class="button button--warning" href="/admin/depublish-product?id=<?= $produit['id'] ?>"><i class="fas fa-times-circle"></i></a>
                            <?php endif; ?>
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