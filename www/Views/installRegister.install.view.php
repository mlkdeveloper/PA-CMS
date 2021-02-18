<div class="container">
    <div class="row">
        <div class="col col-lg-12">
            <div class="jumbotron">
                <p>Bienvenue dans l'enregistrement de Click & Create ! Vous n'avez qu'à remplir les informations demandées ci-dessous et vous serez prêt à utiliser Click & Create</p>
                <div class="container">
                    <h2>Information nécessaires</h2>
                    <hr>
                    <div class="col col-lg-4 col-md-4 center-margin">
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
    </div>
</div>