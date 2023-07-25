
<div class="container my-4">
        
    <h2>Modifier un produit</h2>

    <form action="<?= $router->generate('product-edit', ['id' => $product->getId()]); ?>" method="POST" class="mt-5">
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
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom du produit" value="<?= $product->getName() ?>" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="descrition" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Description" aria-describedby="subtitleHelpBlock" value="<?= $product->getDescription() ?>" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="picture" class="form-label">Image</label>
                <input type="text" class="form-control" id="picture" name="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock" value="<?= $product->getPicture() ?>" required>
                <small id="pictureHelpBlock" class="form-text text-muted">
                    URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
                </small>
            </div>
            <div class="col-md-4 mb-3">
                <label for="price" class="form-label">Prix</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="Ex: 45.90" aria-describedby="subtitleHelpBlock" value="<?= $product->getPrice() ?>" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="rate" class="form-label">Note</label>
                <select class='form-control' name="rate" id="rate" value="<?= $product->getRate() ?>" required>
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <option value="<?= $i ?>" <?= $product->getRate() == $i ? 'selected' : '' ?>><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="status" class="form-label">Statut</label>
                <select class='form-control'  name="status" id="status" value="<?= $product->getStatus() ?>" required>
                <?php for ($i = 1; $i <= 2; $i++) : ?>
                    <option value="<?= $i ?>" <?= $product->getStatus() == $i ? 'selected' : '' ?>><?= $i ?></option>
                    <?php endfor; ?>
                </select>
                <small id="subtitleHelpBlock" class="form-text text-muted">
                    1 = Actif, 2 = Inactif
                </small>
            </div>
            <div class="col-md-4 mb-3">
                <label for="category" class="form-label">Catégorie</label>
                <select class='form-control' name="category" id="category" value="<?= $product->getCategoryId() ?>">
                    <?php foreach ($categoryList as $category): ?>
                    <option value="<?=$category->getId() ?>" <?= $category->getId() == $product->getCategoryId() ? 'selected' : '' ?>><?= $category->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="brand" class="form-label">Marque</label>
                <select class='form-control' name="brand" id="brand" value="<?= $product->getBrandId() ?>">
                    <?php foreach ($brandList as $brand): ?>
                        <option value="<?=$brand->getId() ?>" <?= $brand->getId() == $product->getBrandId() ? 'selected' : '' ?>><?= $brand->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="type" class="form-label">Type</label>
                <select class='form-control' name="type" id="type" value="<?= $product->getTypeId() ?>">
                    <?php foreach ($typeList as $type): ?>
                        <option value="<?=$type->getId() ?>" <?= $type->getId() == $product->getTypeId() ? 'selected' : '' ?>><?= $type->getName() ?></option>
                    <?php endforeach; ?> 
                </select>
            </div>
            <fieldset>
                <legend class="fs-5">Choisissez 1 (ou plusieurs) tag</legend>
                <?php $tagIds= explode (",", $product->getTagIds()) ?>
                <?php foreach ($tagList as $tag): ?>
                    <div>
                        <input type="checkbox" id="<?= $tag->getName() ?>" name="tag[]" value="<?=$tag->getId() ?>" 
                            <?=in_array($tag->getId(), $tagIds) ? 'checked' : '' ?>>    
                        <label for="<?= $tag->getName() ?>" value="<?=$tag->getId() ?>"><?= $tag->getName() ?></label>
                    </div>
                <?php endforeach; ?>     
            </fieldset>

            <!-- token hidden anti-csrf -->
            <input type="hidden" name="token" value="<?= $token ?>">

            <button type="submit" class="btn btn-primary mt-5">Valider</button>

        </div>
    </form>

    <div>
        <a href="<?= $router->generate('product-list') ?>" class="btn btn-success mt-3">Retour</a>
    </div>

</div>