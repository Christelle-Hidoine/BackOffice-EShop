<div class="container my-4">
        <a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-end">Retour</a>
        <h2>Ajouter un produit</h2>
        
        <form action="" method="POST" class="mt-5">
            <div class="mb-3">
                <label for="name" class="form-label">*Nom</label>
                <input type="text" class="form-control" id="name" name='name' placeholder="Nom du produit" required>
            </div>
            <div class="mb-3">
                <label for="subtitle" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name='description' placeholder="Description" aria-describedby="subtitleHelpBlock">
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Image</label>
                <input type="text" class="form-control" id="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock">
                <small id="pictureHelpBlock" class="form-text text-muted">
                    URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
                </small>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">*Prix</label>
                <input type="text" class="form-control" id="price" name='price' placeholder="Prix du produit" required>
            </div>
            <div class="mb-3">
                <label for="rate" class="form-label" required>*Avis</label>
                <select name='rate' id="rate">
                    <option value="1">1 étoile</option>
                    <option value="2">2 étoiles</option>
                    <option value="3">3 étoiles</option>
                    <option value="4">4 étoiles</option>
                    <option value="5">5 étoiles</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label" required>*Statut</label>
                <select name="status" id="status">
                    <option value="1">Disponible</option>
                    <option value="2">Pas disponible</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="brand" class="form-label" required>*Marque</label>
                <select name="brand" id="brand">
                    <?php foreach ($brandList as $brand): ?>
                    <option value="<?=$brand->getId() ?>"><?=$brand->getName() ?></option>
                    <?php endforeach; ?>
                </select>

            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Catégorie</label>
                <select name="category" id="category">
                    <option value="">Default</option>
                    <?php foreach ($categoryList as $category): ?>
                    <option value="<?=$category->getId() ?>"><?=$category->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label" required>*Type</label>
                <select name="type" id="type">
                    <?php foreach ($typeList as $type): ?>
                    <option value="<?=$type->getId() ?>"><?=$type->getName() ?></option>
                    <?php endforeach; ?> 
                </select>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary mt-5">Valider</button>
            </div>
        </form>
        <small id="fieldHelpBlock" class="form-text text-muted">
                    * Champs obligatoires
        </small>
    </div>