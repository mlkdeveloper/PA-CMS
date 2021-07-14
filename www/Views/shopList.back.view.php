<div class="container">
    <div class="row">
        <div class="col col-lg-12">
            <h1 style="text-align: center;font-size: 40px">Gestion des magasins </h1>
            <div class="jumbotron">
                <div class="flex-end mb-1">

                    <a href="/admin/nouveau-magasin"><button class="button button--blue">Nouveau magasin</button></a>

                </div>
                <table id="table" class="row-border hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>N° Tel.</th>
                        <th>Adresse</th>
                        <th>Ville</th>
                        <th>Code postal</th>
                        <th style="width:150px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($shop as $value):
                        ?>
                        <tr>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['name'] ?></td>
                            <td><?= $value['phoneNumber'] ?></td>
                            <td><?= $value['address'] ?></td>
                            <td><?= $value['city'] ?></td>
                            <td><?= $value['zipCode'] ?></td>
                            <td>
                                <div class="align">
                                    <div class="align">
                                        <a href="/admin/detail-magasin?id=<?= $value['id']?>">
                                            <button class="button button--black">
                                                <i class="fas fa-pencil-alt"></i>
                                                Modifier
                                            </button>
                                        </a>
                                    </div>
                                    <div class="align">
                                        <?php  //App\Core\FormBuilder::render($form); ?>
                                        <a href="/admin/delete-shop?id=<?= $value['id']?>"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/French.json'
            },
            "columnDefs": [
                {"className": "dt-center", "targets": "_all"}
            ]
        });
    });
</script>