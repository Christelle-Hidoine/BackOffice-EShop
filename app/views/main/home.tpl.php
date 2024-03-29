<div class="container my-4">
    <p class="display-4">
        Bienvenue dans le backOffice <strong>Dans les shoe</strong>...
    </p>

    <div class="row mt-5">
        <div class="col-12 col-md-6">
            <div class="card text-white mb-3">
                <div class="card-header bg-primary">Liste des catégories</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nom</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>

                          <?php foreach($category as $categoryObject) : ?>
                            <tr>
                                <th scope="row">
                                  <?= $categoryObject->getId() ?>
                                </th>
                                <td>
                                  <?= $categoryObject->getName() ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?= $router->generate('category-edit', ['id' => $categoryObject->getId()]) ?>" class="btn btn-sm btn-warning">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                    
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Oui, je veux supprimer</a>
                                            <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                          <?php endforeach; ?>

                        </tbody>
                    </table>
                    <div class="d-grid gap-2">
                        <a href="<?= $router->generate('category-list') ?>" class="btn btn-success">
                          Voir plus
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card text-white mb-3">
                <div class="card-header bg-primary">Liste des produits</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nom</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>                            

                          <?php foreach($product as $productObject) : ?>
                            <?php $labels= explode (",", $productObject->getTags()) ?>
                            <tr>
                                <th scope="row">
                                  <?= $productObject->getId() ?>
                                </th>
                                <td class="flex-wrap justify-content-between">
                                  <?= $productObject->getName() ?>
                                  <div class="d-flex flex-wrap">
                                  <?php foreach ($labels as $label) : ?>
                                    <div class="text-center rounded-pill border bg-secondary text-white text-center small px-3">
                                        <span><?= $label ?><span>
                                    </div>    
                                <?php endforeach ?>
                                  </div>
                                </td>
                                <td class="text-end">
                                    <a href="<?= $router->generate('product-edit', ['id' => $productObject->getId()]) ?>" class="btn btn-sm btn-warning">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                    
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Oui, je veux supprimer</a>
                                            <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                          <?php endforeach; ?>

                        </tbody>
                    </table>
                    <div class="d-grid gap-2">
                        <a href="<?= $router->generate('product-list') ?>" class="btn btn-success">
                          Voir plus
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>