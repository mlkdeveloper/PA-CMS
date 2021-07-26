<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col">
                <div class="jumbotron">
                    <a href="/admin/barre-de-navigation">
                        <button class="button button--blue">Retour</button>
                    </a>
                    <?php

                    if (isset($errors)){

                        echo "<div class='container'>";
                        echo "<div class='alert alert--red'>";

                        foreach($errors as $error){
                            echo $error . "<br>";
                        }

                        echo "</div>";
                        echo "</div>";
                    }

                    if (isset($errorType)){

                        echo "<div class='container'>";
                        echo "<div class='alert alert--red'>";
                        echo $errorType;
                        echo "</div>";
                        echo "</div>";
                    }

                    if(isset($_SESSION['errorDropDown'])){
                        echo '<div class="alert alert--red errorMessageImage"><h4>'.$_SESSION['errorDropDown'].'</h4></div>';
                    }
                    ?>
                    <div class="centered p-3">
                        <div>
                            <form method="POST" action="" class="form_align form_align--top">
                                <label class="label" for="name">Titre *</label>
                                <input type="text" class="input" name="name" id="name" maxlength="50" minlength="2">

                                <div id="containerSimpleTab">
                                <label class="label pt-3" for="typeNavbar">Type *</label>
                                <select class="input" id="typeNavbar" name="typeNavbar">
                                    <option value="" disabled selected>Sélectionner le type de la page</option>
                                    <option value="page">Page statique</option>
                                    <option value="category">Category</option>
                                </select>

                                <label class="label pt-3" for="selectType" id="labelSelectType"></label>
                                <select class="input" id="selectType" name="selectType"></select>
                                </div>
                                <label class="label pt-3" for="dropdown">Mode liste déroulante </label>
                                <input class="input" type="checkbox" name="dropdown" id="dropdown" value="dropdown">

                                <div id="containerDropdownNavbar" class="pt-3">
                                    <div class="pt-2">
                                        <label class="label" for="nameDropdown1">Nom de l'onglet *</label>
                                        <input class="input" type="text" name="nameDropdown1" maxlength="50" minlength="2">

                                        <label class="label" for="typeDropdown1">Type *</label>
                                        <select class="input typeDropdown" name="typeDropdown1">
                                            <option value="" disabled selected>Sélectionner le type de la page</option>
                                            <option value="page">Page statique</option>
                                            <option value="category">Category</option>
                                        </select>

                                        <select class="input" name="selectTypeDropdown1" id="selectTypeDropdown1"></select>
                                    </div>

                                    <span class="pt-3" id="addTabDropdown"><i class="fas fa-plus-circle"></i></span>
                                </div>

                                <button type="submit" class="button button--blue mt-3">Enregistrer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="../public/js/navbar.js"></script>