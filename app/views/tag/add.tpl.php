<div class="container my-4">
  <a href="<?= $router->generate('tag-list') ?>" class="btn btn-success float-end">
    Retour
  </a>
        <!-- On va gérer un affichage dynamique pour le libellé h2 -->
        <!-- Objectif : savoir si on est en mode create ou update -->
        <!-- En mode create, ce template ne récupère aucune donnée -->
        <!-- En mode update, ce template récupère un tag (et éventuellement un tag id) -->
        <?php 
        if (isset($id)) : ?>
            <h2>Modifier un tag</h2>
        <?php
        else : ?>
            <h2>Ajouter un tag</h2>
        <?php endif; ?>
  
  <form action="" method="POST" class="col-3 m-auto">
    <?php 
    if (isset($error)) : 
      foreach($error as $message) :?>
      <div class="alert alert-warning" role="alert">
        <?= $message ?>
      </div>
    <?php endforeach; endif; ?> 
    <div class="mb-3">
      <label for="name" class="form-label">
        Nom
      </label>
      <input type="text" class="form-control" id="name" name="name" value="<?= $tag->getName() ?>" placeholder="Nom du tag">
    </div>

    <!-- Pour le CSRF : on ajoute cet input caché -->
    <input type="hidden" name="token" value="<?= $token ?>">

    <div class="d-grid gap-2">
      <button type="submit" class="btn btn-primary mt-5">Valider</button>
    </div>
  </form>
</div>