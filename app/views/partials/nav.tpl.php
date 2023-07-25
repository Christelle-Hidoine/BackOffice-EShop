<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="<?= $router->generate('main-home') ?>">
          oShop
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto align-items-center">
                <li class="nav-item">
                  <a class="nav-link <?= $viewName === "main/home" ? "active" : ""?>" href="<?= $router->generate('main-home') ?>">
                    Accueil <span class="sr-only">(current)</span>
                  </a>
                </li>
                <?php 
                if (isset($_SESSION['userObject'])) : ?>
                  <li class="nav-item nav-link">
                    <?= "Bienvenue {$_SESSION['userName']} !" ?>
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
                    <a class="nav-link <?= $viewName === "type/list" ? "active" : ""?>" href="<?= $router->generate('type-list') ?>">
                    Types
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?= $viewName === "brand/list" ? "active" : ""?>" href="<?= $router->generate('brand-list') ?>">
                  Marques
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= $viewName === "tag/list" ? "active" : ""?>" href="<?= $router->generate('tag-list') ?>">
                Tags
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= $viewName === "category/home" ? "active" : ""?>" href="<?= $router->generate('category-home') ?>">
                Sélection Accueil
                </a>
              </li>
            <?php endif; ?>
            <?php if(isset($_SESSION['userObject']) && $_SESSION['userObject']->isAdmin()) : ?>
              <li class="nav-item">
                <a class="nav-link <?= $viewName === "appUser/list" ? "active" : ""?>" href="<?= $router->generate('user-list') ?>">
                  Utilisateurs
                </a>
              </li>
            <?php endif; ?>
            <?php
            if (!isset($_SESSION['userObject'])) : ?>
              <li class="nav-item">
                <a class="nav-link" href="<?= $router->generate('user-connection') ?>">
                  <button type="button" class="btn btn-primary">Login</button>
                </a>
              </li>
            <?php endif; ?>
            <?php
            if (isset($_SESSION['userObject'])) : ?>
              <li class="nav-item">
                <a class="nav-link" href=" <?= $router->generate('user-logout') ?>">
                  <button type="button" class="btn btn-primary">Logout</button>
                </a>
              </li>
            <?php endif; ?>
        </ul>
      </div>
    </div>
</nav>