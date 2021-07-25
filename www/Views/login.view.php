<div class="container">
    <div class="row">
        <div class="col col-lg-10">
            <h1 style="text-align: center;font-size: 40px">Connexion</h1>
            <div class="jumbotron">
                <?php if(isset($errors)):?>
                    <ul class="alert alert--red">
                        <?php foreach ($errors as $error):?>
                            <?=$error?><br>
                        <?php endforeach;?>
                    </ul>
                <?php endif;?>
                <?php App\Core\FormBuilder::render($formLogin); ?>
                <a href="/mot-de-passe-oublie" class="centered"> Mot de passe oublié</a>
                <p class="centered">Pas encore de compte ?&nbsp;<a href="/inscription" class="centered">S'inscrire</a></p>
            </div>
        </div>
    </div>
</div>