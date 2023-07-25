
<div class="container my-4">

  <!-- create mode, this template doesn't retrieve any data -->
  <!-- update mode, this template retrieve an id -->
  <?php 
        if (isset($id)) : ?>
            <h2>Modifier une marque</h2>
            <?php
        else : ?>
            <h2>Ajouter une marque</h2>
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
          <label for="name" class="form-label">Nom</label>
          <input type="text" class="form-control" id="name" name="name" value="<?= $brand->getName() ?>" placeholder="Nom de la marque">
        </div>
        <!-- token hidden anti-csrf -->
        <input type="hidden" name="token" value="<?= $token ?>">
        
        <button type="submit" class="btn btn-primary mt-3">Valider</button>
        
      </div>      
    </form>

    <div class="mt-3">
      <a href="<?= $router->generate('brand-list') ?>" class="btn btn-success">
        Retour
      </a>
    </div>

</div>