<div class="container">
    <div class="row centered">
        <div class="col col-lg-10">
            <h1 style="text-align: center;font-size: 40px">Envoie d'un mail</h1>
            <div class="jumbotron">
                <?php if(isset($errors)):?>
                <ul class="alert alert--red">
                    <?php foreach ($errors as $error):?>
                        <?=$error?>
                    <?php endforeach;?>
                </ul>
                <?php endif;?>
                <?php App\Core\FormBuilder::render($form); ?>
            </div>
        </div>
    </div>
</div>