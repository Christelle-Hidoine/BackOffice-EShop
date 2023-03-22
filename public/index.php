<?php

// POINT D'ENTRÉE UNIQUE :
// FrontController

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)
require_once '../vendor/autoload.php';

use App\Controllers\AppUserController;
use App\Controllers\BrandController;
use App\Controllers\MainController;
use App\Controllers\CategoryController;
use App\Controllers\ProductController;
use App\Controllers\TypeController;



/* -------------------
--- SESSION STORAGE---
--------------------*/

session_start();

/* ------------
--- ROUTAGE ---
-------------*/


// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
} else { // sinon
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// On doit déclarer toutes les "routes" à AltoRouter,
// afin qu'il puisse nous donner LA "route" correspondante à l'URL courante
// On appelle cela "mapper" les routes
// 1. méthode HTTP : GET ou POST (pour résumer)
// 2. La route : la portion d'URL après le basePath
// 3. Target/Cible : informations contenant
//      - le nom de la méthode à utiliser pour répondre à cette route
//      - le nom du controller contenant la méthode
// 4. Le nom de la route : pour identifier la route, on va suivre une convention
//      - "NomDuController-NomDeLaMéthode"
//      - ainsi pour la route /, méthode "home" du MainController => "main-home"

// ----------------------------------------Routes HOME ----------------------------------------

$router->map(
  'GET',
  '/',
  [
    'method' => 'home',
    'controller' => MainController::class
  ],
  'main-home'
);

// ---------------------------------------- Routes CATEGORY  ----------------------------------------

// Liste les catégories
$router->map(
  'GET',
  '/category/list',
  [
    'method' => 'list',
    'controller' => CategoryController::class 
  ],
  'category-list'
);

// Affiche sélection Catégorie Home
$router->map(
  'GET',
  '/category/home',
  [
    'method' => 'homeList',
    'controller' => CategoryController::class
  ],
  'category-home'
);

// Traite sélection Catégorie Home
$router->map(
  'POST',
  '/category/home',
  [
    'method' => 'homeSelect',
    'controller' => CategoryController::class
  ],
  'category-homeSelect'
);

// Affiche Ajout Catégorie
$router->map(
  'GET',
  '/category/add',
  [
    'method' => 'add',
    'controller' => CategoryController::class 
  ],
  'category-add'
);

// Traite Ajout Catégorie
$router->map(
  'POST',
  '/category/add',
  [
    'method' => 'create',
    'controller' => CategoryController::class 
  ],
  'category-create'
);

// Affiche Modifie Catégorie
$router->map(
  'GET',
  '/category/[i:id]/update',
  [
    'method' => 'edit',
    'controller' => CategoryController::class
  ],
  'category-edit'
);

// Traite Modifie Catégorie
$router->map(
  'POST',
  '/category/[i:id]/update',
  [
    'method' => 'update',
    'controller' => CategoryController::class
  ],
  'category-update'
);

// Traite Supprime Catégorie
$router->map(
  'GET',
  '/category/[i:id]/delete',
  [
    'method' => 'delete',
    'controller' => CategoryController::class
  ],
  'category-delete'
);

// ---------------------------------------- Routes PRODUCT  ----------------------------------------

// Liste des produits
$router->map(
  'GET',
  '/product/list',
  [
    'method' => 'list',
    'controller' => ProductController::class
  ],
  'product-list'
);

// Affiche Ajout produit
$router->map(
  'GET',
  '/product/add',
  [
    'method' => 'add',
    'controller' => ProductController::class
  ],
  'product-add'
);

// Traite Ajout produit
$router->map(
  'POST',
  '/product/add',
  [
    'method' => 'create',
    'controller' => ProductController::class
  ],
  'product-create'
);

// Affiche Modifie Produit
$router->map(
  'GET',
  '/product/[i:id]/update',
  [
    'method' => 'edit',
    'controller' => ProductController::class
  ],
  'product-edit'
);

// Traite Modifie Produit
$router->map(
  'POST',
  '/product/[i:id]/update',
  [
    'method' => 'update',
    'controller' => ProductController::class
  ],
  'product-update'
);

// Traite Supprime Produit
$router->map(
  'GET',
  '/product/[i:id]/delete',
  [
    'method' => 'delete',
    'controller' => ProductController::class
  ],
  'product-delete'
);

// ---------------------------------------- Routes BRAND -------------------------------------------

// Liste des Marques
$router->map(
  'GET',
  '/brand/list',
  [
    'method' => 'list',
    'controller' => BrandController::class 
  ],
  'brand-list'
);

// Affiche Ajout Marque
$router->map(
  'GET',
  '/brand/add',
  [
    'method' => 'add',
    'controller' => BrandController::class
  ],
  'brand-add'
);

// Traiter Ajout Marque
$router->map(
  'POST',
  '/brand/add',
  [
    'method' => 'createOrEdit',
    'controller' => BrandController::class
  ],
  'brand-create'
);

// Afficher Modifie Marque
$router->map(
  'GET',
  '/brand/add/[i:id]',
  [
    'method' => 'edit',
    'controller' => BrandController::class
  ],
  'brand-edit'
);

// Traiter Modifie Marque
$router->map(
  'POST',
  '/brand/add/[i:id]',
  [
    'method' => 'createOrEdit',
    'controller' => BrandController::class
  ],
  'brand-update'
);

// Supprime la marque
$router->map(
  'GET',
  '/brand/[i:id]/delete',
  [
    'method' => 'delete',
    'controller' => BrandController::class
  ],
  'brand-delete'
);
// ---------------------------------------- Routes TYPE  -------------------------------------------

// Liste des Types
$router->map(
  'GET',
  '/type/list',
  [
    'method' => 'list',
    'controller' => TypeController::class 
  ],
  'type-list'
);

// Affiche Ajout Type
$router->map(
  'GET',
  '/type/add',
  [
    'method' => 'add',
    'controller' => TypeController::class
  ],
  'type-add'
);

// Traiter Ajout Type
$router->map(
  'POST',
  '/type/add',
  [
    'method' => 'createOrEdit',
    'controller' => TypeController::class
  ],
  'type-create'
);

// Afficher Modifie Type
$router->map(
  'GET',
  '/type/add/[i:id]',
  [
    'method' => 'edit',
    'controller' => TypeController::class
  ],
  'type-edit'
);

// Traiter Modifie Type
$router->map(
  'POST',
  '/type/add/[i:id]',
  [
    'method' => 'createOrEdit',
    'controller' => TypeController::class
  ],
  'type-update'
);

// Supprime la Type
$router->map(
  'GET',
  '/type/[i:id]/delete',
  [
    'method' => 'delete',
    'controller' => TypeController::class
  ],
  'type-delete'
);

// ---------------------------------------- Routes APP_USER  ----------------------------------------

// Liste des Users
$router->map(
  'GET',
  '/user/list',
  [
    'method' => 'list',
    'controller' => AppUserController::class
  ],
  'user-list'
);

// Affiche Connexion User
$router->map(
  'GET',
  '/user/connection',
  [
    'method' => 'connect',
    'controller' => AppUserController::class
  ],
  'user-connection'
);

// Traite Connexion User
$router->map(
  'POST',
  '/user/connection',
  [
    'method' => 'check',
    'controller' => AppUserController::class
  ],
  'user-check'
);


// Affiche Ajout User
$router->map(
  'GET',
  '/user/add',
  [
    'method' => 'add',
    'controller' => AppUserController::class
  ],
  'user-add'
);

// Traite Ajout User
$router->map(
  'POST',
  '/user/add',
  [
    'method' => 'create',
    'controller' => AppUserController::class
  ],
  'user-create'
);

// Affiche Modifie User
$router->map(
  'GET',
  '/user/[i:id]/update',
  [
    'method' => 'edit',
    'controller' => AppUserController::class
  ],
  'user-edit'
);

// Traite Modifie User
$router->map(
  'POST',
  '/user/[i:id]/update',
  [
    'method' => 'update',
    'controller' => AppUserController::class
  ],
  'user-update'
);

// Traite Supprime User
$router->map(
  'GET',
  '/user/[i:id]/delete',
  [
    'method' => 'delete',
    'controller' => AppUserController::class
  ],
  'user-delete'
);

// Deconnecte le User
$router->map(
  'GET',
  '/user/logout',
  [
    'method' => 'logout',
    'controller' => AppUserController::class
  ],
  'user-logout'
);

/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();