<div class="container my-4">
  <a href="<?= $router->generate('category-list') ?>" class="btn btn-success float-end">
    Retour
  </a>

  <h2>Modifier une catégorie</h2>
  
  <?php 
   if (isset($errorList)) : 
    foreach($errorList as $message) :?>
    <div class="alert alert-warning" role="alert">
      <?= $message ?>
    </div>
  <?php endforeach; endif; ?> 

  <form action="<?= $router->generate('category-edit', ['id' => $category->getId()]); ?>" method="POST" class="col-3 m-auto">
    <div class="mb-3">
      <label for="name" class="form-label">
        Nom
      </label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Nom de la catégorie"value="<?= $category->getName() ?>"
      >
    </div>
    <div class="mb-3">
      <label for="subtitle" class="form-label">
        Sous-titre
      </label>
      <input type="text" class="form-control" id="subtitle" name="subtitle"placeholder="Sous-titre" aria-describedby="subtitleHelpBlock"value="<?= $category->getSubtitle() ?>"
      >
      <small id="subtitleHelpBlock" class="form-text text-muted">
        Sera affiché sur la page d'accueil comme bouton devant l'image
      </small>
    </div>
    <div class="mb-3">
      <label for="picture" class="form-label">
        Image
      </label>
      <input type="text" class="form-control" id="picture" name="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock"value=""
      >
      <small id="pictureHelpBlock" class="form-text text-muted">
        URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
      </small>
    </div>
    <div class="d-grid gap-2">
      <button type="submit" class="btn btn-primary mt-5">Valider</button>
    </div>
  </form>
</div>