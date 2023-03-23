<?php

use App\Controllers\ProductController;

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