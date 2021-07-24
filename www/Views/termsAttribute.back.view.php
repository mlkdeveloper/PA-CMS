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

        <h1>Nouvelle valeur de  <?= $nameAttribute ?></h1>
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
                            <input class="input" type="text" name="name" placeholder="XSS" required="required">
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
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        foreach ($terms as $term):?>
                            <tr id="term-<?= $term['id']?>">
                                <td><?= $term['id'] ?></td>
                                <td><?= $term['name'] ?></td>
                                <td><i class="fas fa-trash" onclick="handleDeleteTerm(<?= $term['id']?>,<?= $term['idAttributes']?>)"></i></td>
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
