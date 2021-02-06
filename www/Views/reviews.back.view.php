<h1 class="centered">Avis</h1>

<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="jumbotron">
                <table id="table" class="display">
                    <thead>
                    <tr>
                        <th>N° produit</th>
                        <th>Image</th>
                        <th>Commentaire</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>1</td>
                        <td>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias at, autem, delectus
                                distinctio dolorem facere harum ipsam labore magnam molestiae nemo, non vero. Earum
                                eligendi enim id, placeat possimus quaerat.
                            </p>
                        </td>
                        <td>test@test.com</td>
                        <td>
                            <button class="button button--warning">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="button button--alert">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <form class="form jumbotron">
            <div class="col-md-12">
                <div class="form_align form_align--top">
                    <label class="label" for="description">Description</label>
                    <textarea id="description" class="input input--textarea"></textarea>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form_align form_align--top">
                    <label class="label" for="test">Nom de la base de données</label>
                    <input type="text" class="input" id="test">
                </div>
            </div>

            <div class="col-md-6">
                <div class="checkboxes">
                    <div class="form_align form_align--top">
                        <label for="radio" class="label">Radiobbbb</label>
                        <input type="radio" class="" id="radio">
                    </div>

                    <div class="form_align form_align--top">
                        <label for="radio" class="label">Radio</label>
                        <input type="checkbox" class="" id="radio">
                    </div>
                    <div class="form_align form_align--top">
                        <label for="radio" class="label">Radio</label>
                        <input type="checkbox" class="" id="radio">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="../public/js/datatable.js"></script>