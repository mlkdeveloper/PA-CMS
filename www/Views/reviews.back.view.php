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
                    <?php foreach ($datas as $review): ?>
                    <tr>
                        <td><?= $review["id"] ?></td>
                        <td><?= $review["commentary"] ?></td>
                        <td><?= $review["commentary"] ?></td>
                        <td><?= $review["status"] ?></td>
                        <td>
                            <a href="/admin/check-review/<?= $review["id"] ?>" class="button button--success">
                                <i class="bi bi-check"></i>
                            </a>
                            <a class="button button--alert">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
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