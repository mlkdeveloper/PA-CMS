<section>
    <div class="container">

        <div id="msg">
            <?php if(isset($errors)):?>
                <div class="alert alert--red">
                    <?php foreach ($errors as $error):?>
                        <li><?=$error?></li>
                    <?php endforeach;?>
                </div>
            <?php endif;?>

            <?php if(isset($message)):?>
                <div class="alert alert--green"><?= $message?></div>
            <?php endif;?>
        </div>

        <h1>Nouvel attribut</h1>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-6 col">
                <div class="jumbotron">
                    <form method="POST" action="">
                        <div class="form_align--top">
                            <label class="label">Nom *</label>
                            <input class="input" type="text" name="name" placeholder="Couleur" required="required">
                        </div>

                        <div class="form_align--top mt-1">
                            <label class="label">Description</label>
                            <textarea class="input" type="text" name="description" placeholder="..."></textarea>
                        </div>
                        <div class="mt-1">
                            <input type="submit" class="button button--blue" value="Enregistrer">
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-6 col">
                <div class="jumbotron">
                    <table id="table" class="row-border hover">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($attributes as $attribute):?>
                            <tr id="attr-<?= $attribute['id'] ?>">
                                <td><?= $attribute['id'] ?></td>
                                <td><?= $attribute['name'] ?></td>
                                <td><?= $attribute['description'] ?></td>
                                <td>

                                    <?php if($attribute['id'] != 1):?>
                                        <i onclick="handleDelete(<?= $attribute['id'] ?>)" class="fas fa-trash"></i>
                                        <a href="/admin/modification-attribut?id=<?=$attribute['id']?>"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="/admin/valeurs-attribut?id=<?=$attribute['id']?>"><i class="fas fa-plus"></i></a>
                                    <?php endif;?>
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
<script src="../public/js/attribute.js"></script>