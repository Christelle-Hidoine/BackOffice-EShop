<?php
    // On créé un token que l'on stocke en session ET dans une variable
    // (pour pouvoir s'en servir dans le form)
    $token = $_SESSION['token'] = random_bytes(5);
    // Dump à titre de debug : pour lire le token, on doit passer par 
    // la fonction PHP native bin2hex
    dump(bin2hex($_SESSION['token']));
?>

<div class="container my-4">

    <a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-end">
      Retour
    </a>
    
    <h2>Ajouter un produit</h2>

    <?php 
    if (isset($error)) : 
        foreach($error as $message) :?>
        <div class="alert alert-warning" role="alert">
        <?= $message ?>
        </div>
    <?php endforeach; endif; ?> 

    <form action="" method="POST" class="col-3 m-auto">
        <div class="mb-3">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $product->getName() ?>" placeholder="Nom du produit">
        </div>
        <div class="mb-3">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" value="<?= $product->getDescription() ?>" placeholder="Description du produit" 
                aria-describedby="descriptionHelpBlock">
        </div>
        <div class="mb-3">
            <label for="picture">Image</label>
            <input type="text" class="form-control" id="picture" name="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur 
                <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
        </div>
        <div class="mb-3">
            <label for="price">Prix</label>
            <input type="number" class="form-control" step="0.01" id="price" name="price" value="<?= $product->getPrice() ?>" placeholder="Prix du produit" 
                aria-describedby="priceHelpBlock">
        </div>
        <div class="mb-3">
            <label for="rate">Note</label>
                <select class='form-control' name="rate" id="rate" value="<?= $product->getRate() ?>" required>
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            <small id="rateHelpBlock" class="form-text text-muted">
                Le note du produit 
            </small>
        </div>
        <div class="mb-3">
            <label for="status">Statut</label>
                <select class='form-control'  name="status" id="status" value="<?= $product->getStatus() ?>" required>
                <?php for ($i = 1; $i <= 2; $i++) : ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
                <small id="subtitleHelpBlock" class="form-text text-muted">
                    1 = Actif, 2 = Inactif
                </small>
        </div>
        <div class="mb-3">
            <label for="category">Catégorie</label>
                <select class='form-control' name="category" id="category" value="">
                    <?php foreach ($categoryList as $category): ?>
                        <option value="<?=$category->getId() ?>"><?=$category->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            <small id="categoryHelpBlock" class="form-text text-muted">
                La catégorie du produit 
            </small>
        </div>
        <div class="mb-3">
            <label for="brand">Marque</label>
                <select class='form-control' name="brand" id="brand" value="">
                    <?php foreach ($brandList as $brand): ?>
                    <option value="<?=$brand->getId() ?>"><?=$brand->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            <small id="brandHelpBlock" class="form-text text-muted">
                La marque du produit 
            </small>
        </div>
        <div class="mb-3">
            <label for="type">Type</label>
                <select class='form-control' name="type" id="type" value="">  
                        <?php foreach ($typeList as $type): ?>
                        <option value="<?=$type->getId() ?>"><?=$type->getName() ?></option>
                        <?php endforeach; ?> 
                </select>
            <small id="typeHelpBlock" class="form-text text-muted">
                Le type de produit 
            </small>
        </div>

        <!-- Pour le CSRF : on ajoute cet input caché -->
        <input type="hidden" name="token" value="<?= $token ?>">
        
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>

</div>