<div class="container">
    <div class="row">
        <div class="col col-lg-10">
            <h1 style="text-align: center;font-size: 40px">Envoie d'un mail</h1>
            <div class="jumbotron">
                <?php if(isset($errors)):?>

                    <?php foreach ($errors as $error):?>
                        <li><?=$error?></li>
                    <?php endforeach;?>

                <?php endif;?>
                <?php App\Core\FormBuilder::render($form); ?>
            </div>
        </div>
    </div>
</div>