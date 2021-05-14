<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col center-margin">
            <div class="jumbotron">
                <div class="container">
                    <h2>Information nécessaires</h2>
                    <hr>
                    <?php if(isset($errors)):?>
                        <div class="alert alert--red errorMessageImage">
                            <?php foreach ($errors as $error):?>
                                <h4><?=$error?></h4>
                            <?php endforeach;?>
                        </div>
                    <?php endif;?>
                    <div class="col col-lg-4 col-md-4 center-margin">
                        <?php App\Core\FormBuilder::render($form); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>