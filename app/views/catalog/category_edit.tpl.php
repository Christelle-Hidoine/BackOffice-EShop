<?php dump($category->getName(), $category); ?>
<div class="container my-4">
        <a href="<?= $router->generate('category-list')?>" class="btn btn-success float-end">Retour</a>
        <h2>Modifier une catégorie</h2>
        
        <form action="" method="POST" class="mt-5">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <!-- l'attribut required permet d'indiquer qu'ils sont obligatoires avec un message en survolant les champs -->
                <input liste="name" type="text" class="form-control" id="name" name="name" value="<?= $category->getName() ?>" placeholder="Nom de la catégorie">
            </div>
            <div class="mb-3">
                <label for="subtitle" class="form-label">Sous-titre</label>
                <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?= $category->getSubtitle() ?>" placeholder="Sous-titre" aria-describedby="subtitleHelpBlock">
                <small id="subtitleHelpBlock" class="form-text text-muted">
                    Sera affiché sur la page d'accueil comme bouton devant l'image
                </small>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Image</label>
                <input type="text" class="form-control" id="picture" name="picture" value="<?= $category->getPicture() ?>" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock">
                <small id="pictureHelpBlock" class="form-text text-muted">
                    URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
                </small>
            </div>
            <div class="mb-3">
                <label for="home_order" class="form-label">Ordre d'affichage sur la page d'accueil</label>
                <input type="text" class="form-control" id="home_order" name="home_order" value="<?= $category->getHomeOrder() ?>" placeholder="ordre d'affichage sur la page d'accueil">
                <small id="pictureHelpBlock" class="form-text text-muted">
                    Si pas d'affichage = 0
                </small>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary mt-5">Valider</button>
            </div>
        </form>
    </div>
