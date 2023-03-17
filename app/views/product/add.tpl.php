<div class="container my-4">

    <a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-end">
      Retour
    </a>
    
    <h2>Ajouter un produit</h2>

    <form action="" method="POST" class="mt-5">
        <div class="mb-3">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nom du produit">
        </div>
        <div class="mb-3">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" placeholder="Description du produit" 
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
            <input type="number" class="form-control" step="0.01" id="price" name="price" placeholder="Prix du produit" 
                aria-describedby="priceHelpBlock">
        </div>
        <div class="mb-3">
            <label for="rate">Note</label>
                <select class='form-control' name="rate" id="rate" required>
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
                <select class="form-control" id="status" name="status" aria-describedby="statusHelpBlock">
                    <option value="2">Inactif</option>
                    <option value="1">Actif</option>
                </select>
            <small id="statusHelpBlock" class="form-text text-muted">
                Le statut du produit 
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
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>

</div>