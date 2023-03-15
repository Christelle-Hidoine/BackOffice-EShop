<!-- on n'a plus besoin d'appeler la variable via le viewData de notre fonction show grâce à extract($viewData) dans notre CoreController -->
<div class="container my-4">
        <a href="<?= $router->generate('category-add') ?>" class="btn btn-success float-end">Ajouter</a>
        <h2>Liste des catégories</h2>
        <table class="table table-hover mt-4">
            <thead>
                <tr>

                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Sous-titre</th>
                    <th scope="col"></th>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                <?php foreach($categoryList as $element) : 
                    // dd($element); 
                    // $router->generate("category-update/{$element->getId()}") ?>
                    <th scope="row"><?= $element->getId() ?></th>
                    <td><?= $element->getName() ?></td>
                    <td><?= $element->getSubtitle() ?></td>

                    <td class="text-end">
                          
                        <a href="<?= $router->generate('category-update', ['categoryId' => $element->getId()]) ?>" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <!-- Example single danger button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    </div>