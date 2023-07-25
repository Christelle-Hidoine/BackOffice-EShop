

<div class="container my-4">

        <?php if (empty($id)) : ?>
            <h2>Ajouter un type</h2>
        <?php else : ?>
            <h2>Modifier un type</h2>
        <?php endif; ?>
  
  <form action="" method="POST" class="mt-5">
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
        <input type="text" class="form-control" id="name" name="name" value="<?= $type->getName() ?>" placeholder="Nom du type">
      </div>
      <!-- token hidden anti-csrf -->
      <input type="hidden" name="token" value="<?= $token ?>">
      
      <button type="submit" class="btn btn-primary mt-3">Valider</button>
      
    </div>
  </form>

  <div>
  <a href="<?= $router->generate('type-list') ?>" class="btn btn-success mt-3">
      Retour
    </a>
  </div>
</div>