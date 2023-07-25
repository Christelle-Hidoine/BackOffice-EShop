
<div class="container my-4">
  
  <h2>Ajouter une catégorie</h2>
 
  <form action="<?= $router->generate('category-create'); ?>" method="POST" class="mt-5">
    <div class="form-row">
      <?php 
      if (isset($error)) : 
        foreach($error as $message) :?>
        <div class="alert alert-warning" role="alert">
          <?= $message ?>
        </div>
      <?php endforeach; endif; ?> 
      <div class="col-md-4 mb-3">
        <label for="name" class="form-label">
          Nom
        </label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $category->getName() ?>" placeholder="Nom de la catégorie"
        >
      </div>
      <div class="col-md-4 mb-3">
        <label for="subtitle" class="form-label">
          Sous-titre
        </label>
        <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?= $category->getSubtitle() ?>" placeholder="Sous-titre" aria-describedby="subtitleHelpBlock"
        >
        <small id="subtitleHelpBlock" class="form-text text-muted">
          Sera affiché sur la page d'accueil comme bouton devant l'image
        </small>
      </div>
      <div class="col-md-4 mb-3">
        <label for="picture" class="form-label">
          Image
        </label>
        <input type="text" class="form-control" id="picture" name="picture" value="<?= $category->getPicture() ?>" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock"
        >
        <small id="pictureHelpBlock" class="form-text text-muted">
          URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
        </small>
      </div>
      <!-- token hidden anti-csrf -->
      <input type="hidden" name="token" value="<?= $token ?>">
      
      <button type="submit" class="btn btn-primary mt-3">Valider</button>

    </div>  
  </form>

  <div class="mt-3">
    <a href="<?= $router->generate('category-list') ?>" class="btn btn-success">
      Retour
    </a>
  </div>
  
</div>