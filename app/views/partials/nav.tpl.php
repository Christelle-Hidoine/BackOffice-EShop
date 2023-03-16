<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= $router->generate('main-home') ?>">
          oShop
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link <?= $viewName === "main/home" ? "active" : ""?>" href="<?= $router->generate('main-home') ?>">
                      Accueil <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?= $viewName === "category/list" ? "active" : ""?>" href="<?= $router->generate('category-list') ?>">
                      Catégories
                    </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?= $viewName === "product/list" ? "active" : ""?>" href="<?= $router->generate('product-list') ?>">
                      Produits
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                      Types
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                      Marques
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                      Tags
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/category/home">
                      Sélection Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $viewName === "appUser/connection" ? "active" : ""?>" href="<?= $router->generate('user-connection') ?>">
                      Connexion Utilisateur
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>