<?php
// On créé un token que l'on stocke en session ET dans une variable
// (pour pouvoir s'en servir dans le form)
$token = $_SESSION['token'] = random_bytes(5);
// Dump à titre de debug : pour lire le token, on doit passer par 
// la fonction PHP native bin2hex
dump(bin2hex($_SESSION['token']));
?>


<div class="container my-4">
  <a href="<?= $router->generate('main-home') ?>" class="btn btn-success float-end">
    Retour
  </a>

  <h2>Gestion de la page d'accueil</h2>

    <form action="" method="POST" class="mt-5">
        <div class="row">
            <div class="col-md-2 mb-2">
                <div class="form-group">
                    <label for="emplacement1">Emplacement #1</label>
                    <select class="form-control" id="emplacement1" name="emplacement[]">
                        <?php foreach ($homeOrder as $category) : ?>
                            <option value="<?= $category->getId() ?>" <?= $category->getHomeOrder() === "1" ? 'selected' : '' ?>><?= $category->getName() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2 mb-2">
                <div class="form-group">
                    <label for="emplacement2">Emplacement #2</label>
                    <select class="form-control" id="emplacement2" name="emplacement[]">
                        <?php foreach ($homeOrder as $category) : ?>
                            <option value="<?= $category->getId() ?>" <?= $category->getHomeOrder() === "2" ? 'selected' : '' ?>><?= $category->getName() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2 mb-2">
                <div class="form-group">
                    <label for="emplacement3">Emplacement #3</label>
                    <select class="form-control" id="emplacement3" name="emplacement[]">
                        <?php foreach ($homeOrder as $category) : ?>
                            <option value="<?= $category->getId() ?>" <?= $category->getHomeOrder() === "3" ? 'selected' : '' ?>><?= $category->getName() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2 mb-2">
                <div class="form-group">
                    <label for="emplacement4">Emplacement #4</label>
                    <select class="form-control" id="emplacement4" name="emplacement[]">
                        <?php foreach ($homeOrder as $category) : ?>
                            <option value="<?= $category->getId() ?>" <?= $category->getHomeOrder() === "4" ? 'selected' : '' ?>><?= $category->getName() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2 mb-2">
                <div class="form-group">
                    <label for="emplacement5">Emplacement #5</label>
                    <select class="form-control" id="emplacement5" name="emplacement[]">
                        <?php foreach ($homeOrder as $category) : ?>
                            <option value="<?= $category->getId() ?>" <?= $category->getHomeOrder() === "5" ? 'selected' : '' ?>><?= $category->getName() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
            <!-- Pour le CSRF : on ajoute cet input caché -->
        <input type="hidden" name="token" value="<?= $token ?>">
    
        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
    </form>
</div>