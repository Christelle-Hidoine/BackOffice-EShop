<?php

use App\Controllers\ProductController;

// ---------------------------------------- Routes PRODUCT  ----------------------------------------

// Products list

$router->map(
    'GET',
    '/product/list',
    [
      'method' => 'list',
      'controller' => ProductController::class
    ],
    'product-list'
  );
  
  // Display Product add
  $router->map(
    'GET',
    '/product/add',
    [
      'method' => 'add',
      'controller' => ProductController::class
    ],
    'product-add'
  );
  
  // Handle Product add
  $router->map(
    'POST',
    '/product/add',
    [
      'method' => 'create',
      'controller' => ProductController::class
    ],
    'product-create'
  );
  
  // Display Product update
  $router->map(
    'GET',
    '/product/[i:id]/update',
    [
      'method' => 'edit',
      'controller' => ProductController::class
    ],
    'product-edit'
  );
  
  // Handle Product update
  $router->map(
    'POST',
    '/product/[i:id]/update',
    [
      'method' => 'update',
      'controller' => ProductController::class
    ],
    'product-update'
  );
  
  // Product delete
  $router->map(
    'GET',
    '/product/[i:id]/delete',
    [
      'method' => 'delete',
      'controller' => ProductController::class
    ],
    'product-delete'
  );