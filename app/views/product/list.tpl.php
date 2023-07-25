<div class="container my-4">
    
    <h2>Liste des produits</h2>
    <a href="<?= $router->generate('product-add') ?>" class="btn btn-success">
      Ajouter
    </a>
    
    <div class="table-responsive">
        <table class="table table-hover table-sm mt-4">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Description</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : 
                    $labels= explode (",", $product->getTags()) ?>
                <tr>
                    <th scope="row"><?=$product->getId()?></th>
                    <td class="flex-column text-center"><?=$product->getName()?>
                    <?php foreach ($labels as $label) : ?>
                        <div class="d-flex flex-column text-center rounded-pill border bg-secondary text-white text-center">
                            <span><?= $label ?><span>
                        </div>    
                    <?php endforeach ?>
                    </td>
                    <td><?=$product->getDescription()?></td>
                    
                    <td class="text-end">
                        <a href="<?= $router->generate('product-edit', ['id' => $product->getId()]) ?>" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?= $router->generate('product-delete', ['id' => $product->getId()]) ?>?token=<?= $token ?>">Oui, je veux supprimer</a>
                                <a class="dropdown-item" href="#" data-bs-toggle="dropdown">Oups !</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>