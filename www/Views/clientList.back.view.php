<?php if(isset($errors)):?>

    <?php foreach ($errors as $error):?>
        <li><?=$error?></li>
    <?php endforeach;?>

<?php elseif(isset($message)):?>
    <li><?=$message?></li>
<?php endif;?>



<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="jumbotron">

                    <div class="container" style="display: flex;justify-content: flex-end">
                        <a class="button button--blue" href="/admin/ajout-client" >Nouveau client</a>
                    </div>

                    <table id="table" class="row-border hover">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  foreach ($array as $client): ?>
                        <tr>
                            <th hidden><?= $client['id'] ?></th>
                            <th><?= $client['firstname'] ?></th>
                            <th><?= $client['lastname'] ?></th>
                            <th><?= $client['email'] ?></th>
                            <th><?= $client['phoneNumber'] ?></th>
                            <td>
                                <div class="align">
                                    <button class="button button--black">
                                        <i class="fas fa-pencil-alt"></i>
                                        <a href="/admin/modification-client?id=<?= $client['id'] ?>">Modifier</a>
                                    </button>
                                    <form method="POST" action="/admin/suppression-client">
                                            <input type="hidden" name="id" value="<?= $client['id'] ?>">
                                            <button type="submit" class="button button--black"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach;?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</section>

<script src="../public/js/datatable.js"></script>
<script src="../public/js/category.js"></script>