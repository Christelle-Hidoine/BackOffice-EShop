<?php 
// dump($typeListById, $brandListById, $categoryListById ,$product);
?>
<div class="container my-4">
        <a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-end">Retour</a>
        <h2>Modifier un produit</h2>
        
        <form action="" method="POST" class="mt-5">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name='name' value="<?= $product->getName() ?>" placeholder="Nom du produit">
            </div>
            <div class="mb-3">
                <label for="subtitle" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name='description' value="<?= $product->getDescription() ?>" placeholder="Description" aria-describedby="subtitleHelpBlock">
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Image</label>
                <input type="text" class="form-control" id="picture" name="picture" value="<?= $product->getPicture() ?>" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock">
                <small id="pictureHelpBlock" class="form-text text-muted">
                    URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
                </small>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Prix</label>
                <input type="text" class="form-control" id="price" name='price' value="<?= $product->getPrice() ?>" placeholder="Prix du produit">
            </div>
            <div class="mb-3">
                <label for="rate" class="form-label" required>Avis</label>
                <select class='form-control' name='rate' id="rate" value="<?= $product->getRate() ?>">
                    <option value="1">1 étoile</option>
                    <option value="2">2 étoiles</option>
                    <option value="3">3 étoiles</option>
                    <option value="4">4 étoiles</option>
                    <option value="5">5 étoiles</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label" required>Statut</label>
                <select class='form-control' name="status" id="status" value="<?= $product->getStatus() ?>">
                    <option value="1">Disponible</option>
                    <option value="2">Pas disponible</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="brand" class="form-label" required>Marque</label>
                <select class='form-control' name="brand" id="brand" value="<?= $brandListById[$product->getBrandId()]->getName() ?>">
                    <option value="<?=$product->getBrandId() ?>"><?= $brandListById[$product->getBrandId()]->getName() ?></option>
                    <?php foreach ($brandList as $brand): ?>
                    <option value="<?=$brand->getId() ?>"><?=$brand->getName() ?></option>
                    <?php endforeach; ?>
                </select>

            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Catégorie</label>
                <select class='form-control' name="category" id="category" value="<?= $categoryListById[$product->getCategoryId()]->getName() ?>">
                    <option value="<?=$product->getCategoryId() ?>"><?= $categoryListById[$product->getCategoryId()]->getName() ?></option>
                    <?php foreach ($categoryList as $category): ?>
                    <option value="<?=$category->getId() ?>"><?=$category->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label" required>Type</label>
                <select class='form-control' name="type" id="type" value="<?= $typeListById[$product->getTypeId()]->getName() ?>">
                    <option value="<?=$product->getTypeId() ?>"><?= $typeListById[$product->getTypeId()]->getName() ?></option>   
                    <?php foreach ($typeList as $type): ?>
                    <option value="<?=$type->getId() ?>"><?=$type->getName() ?></option>
                    <?php endforeach; ?> 
                </select>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary mt-5">Valider</button>
            </div>
        </form>
    </div>