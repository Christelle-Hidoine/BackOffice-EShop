
<div class="container my-4">
  
  <h2>Modifier un utilisateur</h2>
  
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
        <label for="lastname" class="form-label">
              Nom
        </label>
        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nom l'utilisateur" value="<?= $user->getLastName() ?>">
      </div>
      <div class="col-md-4 mb-3">
        <label for="firstname" class="form-label">
              Prénom
        </label>
        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Prénom de l'utilisateur" value="<?= $user->getFirstName() ?>">
      </div>
      <div class="col-md-4 mb-3">
        <label for="email" class="form-label">
              Email
        </label>
        <input type="email" class="form-control" id="email" name="email" placeholder="adresse email" value="<?= $user->getEmail() ?>">
      </div>
      <div class="col-md-4 mb-3">
          <label for="password" class="form-label">
              Password
          </label>
          <input type="password" class="form-control" id="password" name="password" placeholder="mot de passe" value="">
      </div>
      <div class="col-md-4 mb-3">
          <label for="role" class="form-label">
              Rôle
          </label>
              <select class="form-control" name="role" id="role" required>
                  <option value="catalog-manager" <?= $user->getRole() === 'catalog-manager' ? 'selected' : '' ?>>catalog-manager</option>
                  <option value="admin" <?= $user->getRole() === 'admin' ? 'selected' : '' ?>>admin</option>
              </select>
          </label>
      </div>
      <div class="col-md-4 mb-3">
          <label for="status" class="form-label">
              Statut
          </label>
              <select class="form-control" name="status" id="status" required>
                  <option value="1" <?= $user->getStatus() === "1" ? 'selected' : '' ?>>Actif</option>
                  <option value="2" <?= $user->getStatus() === "2" ? 'selected' : '' ?>>Désactivé/Bloqué</option>
              </select>
      </div>
      
      <!-- token hidden anti-csrf -->
      <input type="hidden" name="token" value="<?= $token ?>">


      <button type="submit" class="btn btn-primary mt-3">Valider</button>
    </div>
  </form>

  <div>
    <a href="<?= $router->generate('user-list') ?>" class="btn btn-success mt-3">
      Retour
    </a>
  </div>

</div>