

<div class="container my-4">

    <a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-end">
      Retour
    </a>
    
    <h2>Ajouter un produit</h2>

    <form action="" method="POST" class="col-3 m-auto">
        <?php 
        if (isset($error)) : 
            foreach($error as $message) :?>
            <div class="alert alert-warning" role="alert">
            <?= $message ?>
            </div>
        <?php endforeach; endif; ?> 
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
                    <option value="<?= $i ?>" <?= $product->getRate() == $i ? 'selected' : '' ?>><?= $i ?></option>
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
                    <option value="<?= $i ?>" <?= $product->getStatus() == $i ? 'selected' : '' ?>><?= $i ?></option>
                    <?php endfor; ?>
                </select>
                <small id="subtitleHelpBlock" class="form-text text-muted">
                    1 = Actif, 2 = Inactif
                </small>
        </div>
        <div class="mb-3">
            <label for="category">Catégorie</label>
                <select class='form-control' name="category" id="category" value="<?= $product->getCategoryId() ?>">
                    <?php foreach ($categoryList as $category): ?>
                    <option value="<?=$category->getId() ?>" <?= $category->getId() == $product->getCategoryId() ? 'selected' : '' ?>><?= $category->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            <small id="categoryHelpBlock" class="form-text text-muted">
                La catégorie du produit 
            </small>
        </div>
        <div class="mb-3">
            <label for="brand">Marque</label>
                <select class='form-control' name="brand" id="brand" value="<?= $product->getBrandId() ?>">
                    <?php foreach ($brandList as $brand): ?>
                        <option value="<?=$brand->getId() ?>" <?= $brand->getId() == $product->getBrandId() ? 'selected' : '' ?>><?= $brand->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            <small id="brandHelpBlock" class="form-text text-muted">
                La marque du produit 
            </small>
        </div>
        <div class="mb-3">
            <label for="type">Type</label>
                <select class='form-control' name="type" id="type" value="<?= $product->getTypeId() ?>">
                    <?php foreach ($typeList as $type): ?>
                        <option value="<?=$type->getId() ?>" <?= $type->getId() == $product->getTypeId() ? 'selected' : '' ?>><?= $type->getName() ?></option>
                    <?php endforeach; ?> 
                </select>
            <small id="typeHelpBlock" class="form-text text-muted">
                Le type de produit 
            </small>
        </div>

        
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>

</div>