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
                    <?php for($i=1; $i <= 100; $i++): ?>

                    <tr>
                        <td><?= $i; ?></td>
                        <td>Image</td>
                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aliquid architecto atque
                            dolores ducimus eaque ex excepturi id, ipsum iste labore molestias, perspiciatis quod
                            reiciendis similique vero voluptate. Beatae, libero.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aliquid architecto atque
                            dolores ducimus eaque ex excepturi id, ipsum iste labore molestias, perspiciatis quod
                            reiciendis similique vero voluptate. Beatae, libero.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aliquid architecto atque
                            dolores ducimus eaque ex excepturi id, ipsum iste labore molestias, perspiciatis quod
                            reiciendis similique vero voluptate. Beatae, libero.</td>
                        <td>test@gmail.com</td>
                        <td style="display: flex; justify-content: space-between; align-items: center">
                            <button class="button button--warning"><i class="bi bi-pencil-square"></i></button>
                            <button class="button button--alert"><i class="bi bi-trash-fill"></i></button>
                        </td>
                    </tr>

                    <?php endfor;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col col-md-5 col-sm-5">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias beatae debitis esse,
                exercitationem modi molestiae natus pariatur possimus quia quisquam quo sapiente ut? Accusamus autem
                eligendi eos iusto saepe?</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci assumenda delectus, harum impedit ipsa
                laborum mollitia nam neque odio quas, reprehenderit, vel voluptates! Adipisci odit quae rem temporibus
                ullam unde.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet dicta eos eum eveniet id, illo laboriosam
                magnam maxime officia, officiis pariatur praesentium reiciendis suscipit unde, voluptatum! Dolorum
                laudantium soluta unde?</p>
        </div>
        <div class="col col-md-3 col-sm-3">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur at consequuntur dolorum facere fuga
                iure magni, maxime molestias nostrum quibusdam reprehenderit repudiandae. Doloribus magnam
                necessitatibus nisi quidem quos? Laborum, nihil.</p>
        </div>
        <div class="col col-md-4 col-sm-4">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci animi atque commodi, consequuntur
                dolore, et expedita facere harum odit optio rerum vel vitae? Alias culpa earum, laborum laudantium
                mollitia rem?</p>

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem commodi cumque dolore doloribus eos, est
                expedita facilis fugit in iusto libero nesciunt numquam porro quas sed, suscipit vero, vitae
                voluptatum!</p>
        </div>
    </div>
</div>

<script src="../public/js/datatable.js"></script>