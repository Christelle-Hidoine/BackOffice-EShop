<?php

use App\Controllers\BrandController;

// ---------------------------------------- Routes BRAND -------------------------------------------

// Brandslist
$router->map(
    'GET',
    '/brand/list',
    [
      'method' => 'list',
      'controller' => BrandController::class 
    ],
    'brand-list'
  );
  
  // Display Brand add
  $router->map(
    'GET',
    '/brand/add',
    [
      'method' => 'add',
      'controller' => BrandController::class
    ],
    'brand-add'
  );
  
  // Handle Brand add
  $router->map(
    'POST',
    '/brand/add',
    [
      'method' => 'createOrEdit',
      'controller' => BrandController::class
    ],
    'brand-create'
  );
  
  // Display Brand update
  $router->map(
    'GET',
    '/brand/add/[i:id]',
    [
      'method' => 'edit',
      'controller' => BrandController::class
    ],
    'brand-edit'
  );
  
  // Handle Brand update
  $router->map(
    'POST',
    '/brand/add/[i:id]',
    [
      'method' => 'createOrEdit',
      'controller' => BrandController::class
    ],
    'brand-update'
  );
  
  // Delete a brand
  $router->map(
    'GET',
    '/brand/[i:id]/delete',
    [
      'method' => 'delete',
      'controller' => BrandController::class
    ],
    'brand-delete'
  );