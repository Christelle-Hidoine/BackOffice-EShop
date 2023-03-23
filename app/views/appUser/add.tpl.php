

<div class="container my-4">
  <a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-end">
    Retour
  </a>

  <h2>Ajouter un utilisateur</h2>
  
  
  <!-- affichage en haut du formulaire de la liste des erreurs  -->
  <form action="" method="POST" class="col-3 m-auto">
    <?php 
    if (isset($error)) : 
      foreach($error as $message) :?>
      <div class="alert alert-warning" role="alert">
        <?= $message ?>
      </div>
    <?php endforeach; endif; ?> 

    <div class="mb-3">
      <label for="lastname" class="form-label">
            Nom
      </label>
      <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nom l'utilisateur" value="<?= $user->getLastName() ?>">
    </div>
    <div class="mb-3">
      <label for="firstname" class="form-label">
            Prénom
      </label>
      <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Prénom de l'utilisateur" value="<?= $user->getFirstName() ?>" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">
            Email
      </label>
      <input type="email" class="form-control" id="email" name="email" placeholder="adresse email" value="<?= $user->getEmail() ?>" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">
            Password
        </label>
        <input type="password" class="form-control" id="password" name="password" placeholder="mot de passe" required>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">
            Rôle
        </label>
            <select class='form-control' name="role" id="role" value="<?= $user->getRole() ?>">
              <option value="catalog-manager">catalog-manager</option>
              <option value="admin">admin</option>
            </select>
        </label>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">
            Statut
        </label>
          <select class='form-control' name="status" id="status" value="<?= $user->getStatus() ?>">
              <option value="<?= $user->getStatus() ? $user->getStatus() : 1 ?>">Actif</option>
              <option value="<?= $user->getStatus() ? $user->getStatus() : 2 ?>">Désactivé/Bloqué</option>
          </select>
    </div>
    
    <!-- Pour le CSRF : on ajoute cet input caché -->
    <input type="hidden" name="token" value="<?= $token ?>">

    <div class="d-grid gap-2">
      <button type="submit" class="btn btn-primary mt-5">Valider</button>
    </div>
  </form>
</div>
