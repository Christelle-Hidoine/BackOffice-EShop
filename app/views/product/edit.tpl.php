<?php 
// dump($typeListById, $brandListById, $categoryListById ,$product);
?>
<div class="container my-4">
        <a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-end">Retour</a>
        <h2>Modifier un produit</h2>
        
        <form action="<?= $router->generate('product-edit', ['id' => $product->getId()]); ?>" method="POST" class="col-5 m-auto">
        <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom du produit" value="<?= $product->getName() ?>" required>
            </div>
            <div class="mb-3">
                <label for="descrition" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Description" aria-describedby="subtitleHelpBlock" value="<?= $product->getDescription() ?>" required>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Image</label>
                <input type="text" class="form-control" id="picture" name="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock" value="<?= $product->getPicture() ?>"required>
                <small id="pictureHelpBlock" class="form-text text-muted">
                    URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
                </small>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Prix</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="Ex: 45.90" aria-describedby="subtitleHelpBlock" value="<?= $product->getPrice() ?>" required>
            </div>
            <div class="mb-3">
                <label for="rate" class="form-label">Note</label>
                <select class='form-control' name="rate" id="rate" value="<?= $product->getRate() ?>" required>
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Statut</label>
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
                <label for="category_id" class="form-label">Catégorie</label>
                <select class='form-control' name="category" id="category" value="">
                    <option value="<?=$product->getCategoryId() ?>"><?= $categoryListById[$product->getCategoryId()]->getName() ?></option>
                    <?php foreach ($categoryList as $category): ?>
                    <option value="<?=$category->getId() ?>"><?=$category->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="brand_id" class="form-label">Marque</label>
                <select class='form-control' name="brand" id="brand" value="">
                    <option value="<?=$product->getBrandId() ?>"><?= $brandListById[$product->getBrandId()]->getName() ?></option>
                    <?php foreach ($brandList as $brand): ?>
                    <option value="<?=$brand->getId() ?>"><?=$brand->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="type_id" class="form-label">Type</label>
                <select class='form-control' name="type" id="type" value="">
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