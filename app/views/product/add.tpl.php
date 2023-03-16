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
            <input type="text" class="form-control" id="description" name="description" placeholder="Sous-titre" 
                aria-describedby="descriptionHelpBlock">
            <small id="subtitleHelpBlock" class="form-text text-muted">
                La description du produit 
            </small>
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
            <input type="number" class="form-control" step="0.01" id="price" name="price" placeholder="Prix" 
                aria-describedby="priceHelpBlock">
            <small id="priceHelpBlock" class="form-text text-muted">
                Le prix du produit 
            </small>
        </div>
        <div class="mb-3">
            <label for="rate">Note</label>
            <input type="text" class="form-control" id="rate" name="rate" placeholder="Note" 
                aria-describedby="rateHelpBlock">
            <small id="rateHelpBlock" class="form-text text-muted">
                Le note du produit 
            </small>
        </div>
        <div class="mb-3">
            <label for="status">Statut</label>
            <select class="form-control" id="status" name="status" aria-describedby="statusHelpBlock">
                <option value="0">Inactif</option>
                <option value="1">Actif</option>
            </select>
            <small id="statusHelpBlock" class="form-text text-muted">
                Le statut du produit 
            </small>
        </div>
        <div class="mb-3">
            <label for="category">Categorie</label>
            <select class="form-control" id="category" name="category" aria-describedby="categoryHelpBlock">
                <option value="1" selected>Détente</option>
                <option value="2">Au travail</option>
                <option value="3">Cérémonie</option>
            </select>
            <small id="categoryHelpBlock" class="form-text text-muted">
                La catégorie du produit 
            </small>
        </div>
        <div class="mb-3">
            <label for="brand">Marque</label>
            <select  class="form-control" id="brand" name="brand" aria-describedby="brandHelpBlock">
                <option value="1" selected>oCirage</option>
                <option value="2">BOOTstrap</option>
                <option value="3">Talonette</option>
            </select>
            <small id="brandHelpBlock" class="form-text text-muted">
                La marque du produit 
            </small>
        </div>
        <div class="mb-3">
            <label for="type">Type</label>
            <select class="form-control" id="type" name="type" aria-describedby="typeHelpBlock">
                <option value="1" selected>Chaussures de ville</option>
                <option value="2">Chaussures de sport</option>
                <option value="3">Tongs</option>
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