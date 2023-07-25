<?php

use App\Controllers\TypeController;

// ---------------------------------------- Routes TYPE  -------------------------------------------

// Type list
$router->map(
    'GET',
    '/type/list',
    [
      'method' => 'list',
      'controller' => TypeController::class 
    ],
    'type-list'
  );
  
  // Display Type add
  $router->map(
    'GET',
    '/type/add',
    [
      'method' => 'add',
      'controller' => TypeController::class
    ],
    'type-add'
  );
  
  // Handle Type add
  $router->map(
    'POST',
    '/type/add',
    [
      'method' => 'createOrEdit',
      'controller' => TypeController::class
    ],
    'type-create'
  );
  
  // Display Type update
  $router->map(
    'GET',
    '/type/add/[i:id]',
    [
      'method' => 'edit',
      'controller' => TypeController::class
    ],
    'type-edit'
  );
  
  // Handle Type update
  $router->map(
    'POST',
    '/type/add/[i:id]',
    [
      'method' => 'createOrEdit',
      'controller' => TypeController::class
    ],
    'type-update'
  );
  
  // Delete type
  $router->map(
    'GET',
    '/type/[i:id]/delete',
    [
      'method' => 'delete',
      'controller' => TypeController::class
    ],
    'type-delete'
  );
  