<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col">
                <div class="jumbotron">
                    <a href="/admin/barre-de-navigation">
                        <button class="button button--blue">Retour</button>
                    </a>
                    <div class="centered p-3">
                        <div>
                            <form method="POST" class="form_align form_align--top">
                                <label class="label" for="name">Titre: </label>
                                <input type="text" class="input" name="name" id="name">

                                <label class="label pt-3" for="type">Type: </label>
                                <select class="input" id="typeNavbar" name="type">
                                    <option value="" disabled selected>Sélectionner le type de la page</option>
                                    <option value="page">Page statique</option>
                                    <option value="category">Category</option>
                                </select>

                                <div id="containerSelectTypeNavbar">
                                    <label class="label pt-3" for="selectType"></label>
                                    <select class="input" id="selectType" name="selectType">
                                        <option>Page</option>
                                        <option>Category</option>
                                    </select>
                                </div>

                                <label class="label pt-3" for="name">Mode liste déroulante: </label>
                                <input type="checkbox">

                                <button type="submit" class="button button--blue">Enregistrer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="../public/js/navbar.js"></script>