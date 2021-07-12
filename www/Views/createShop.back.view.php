<div class="container">
    <div class="row">
        <div class="col col-lg-12">
            <h1 style="text-align: center;font-size: 40px">Création d'un magasin</h1>
            <div class="jumbotron">
                <?php if(isset($errors)):?>
                <ul class="alert alert--red">
                    <?php foreach ($errors as $error):?>
                        <li><?=$error?></li>
                    <?php endforeach;?>
                </ul>
                <?php endif;?>

                <?php App\Core\FormBuilder::render($form); ?>
            </div>
        </div>
    </div>
</div>