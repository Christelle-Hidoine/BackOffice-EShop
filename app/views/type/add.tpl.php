<?php
    // On créé un token que l'on stocke en session ET dans une variable
    // (pour pouvoir s'en servir dans le form)
    $token = $_SESSION['token'] = random_bytes(5);
    // Dump à titre de debug : pour lire le token, on doit passer par 
    // la fonction PHP native bin2hex
    dump(bin2hex($_SESSION['token']));
?>

<div class="container my-4">
  <a href="<?= $router->generate('type-list') ?>" class="btn btn-success float-end">
    Retour
  </a>
        <!-- On va gérer un affichage dynamique pour le libellé h2 -->
        <!-- Objectif : savoir si on est en mode create ou update -->
        <!-- En mode create, ce template ne récupère aucune donnée -->
        <!-- En mode update, ce template récupère une marque (et éventuellement une marque id) -->
        <?php if (empty($id)) : ?>
            <h2>Ajouter un type</h2>
        <?php else : ?>
            <h2>Modifier un type</h2>
        <?php endif; ?>

  <?php 
   if (isset($error)) : 
    foreach($error as $message) :?>
    <div class="alert alert-warning" role="alert">
      <?= $message ?>
    </div>
  <?php endforeach; endif; ?> 
  
  <form action="" method="POST" class="col-3 m-auto">
    <div class="mb-3">
      <label for="name" class="form-label">
        Nom
      </label>
      <input type="text" class="form-control" id="name" name="name" value="<?= $type->getName() ?>" placeholder="Nom du type">
    </div>

    <!-- Pour le CSRF : on ajoute cet input caché -->
    <input type="hidden" name="token" value="<?= $token ?>">
    
    <div class="d-grid gap-2">
      <button type="submit" class="btn btn-primary mt-5">Valider</button>
    </div>
  </form>
</div>
