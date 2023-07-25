
<div class="container my-4">
  
  <h2>Liste des tags</h2>
  <a href="<?= $router->generate('tag-add') ?>" class="btn btn-success">
    Ajouter
  </a>

    <div class="table-responsive">
      <table class="table table-hover table-sm mt-4">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

          <?php foreach($tags as $tag) : ?>
            <tr>
                <th scope="row">
                  <?= $tag->getId() ?>
                </th>
                <td>
                  <?= $tag->getName() ?>
                </td>
                <td class="text-end">
                    <a href="<?= $router->generate('tag-edit', ['id' => $tag->getId()]) ?>" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= $router->generate('tag-delete',['id' => $tag->getId()]) ?>?token=<?= $token ?>">
                              Oui, je veux supprimer
                            </a>
                            <a class="dropdown-item" href="#" data-toggle="dropdown">
                              Oups !
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
          <?php endforeach; ?>

        </tbody>
      </table>
    </div>
    
</div>