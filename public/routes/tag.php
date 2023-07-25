<?php 

use App\Controllers\TagController;

// -------------------------------- Routes Tag ---------------------------------------

// Tags list
$router->map(
    'GET',
    '/tag/list',
    [
        'method' => 'list',
        'controller' => TagController::class
    ],
    'tag-list'
);

// Display Tag add
$router->map(
    'GET',
    '/tag/add',
    [
      'method' => 'add',
      'controller' => TagController::class
    ],
    'tag-add'
  );
  
  // handle Tag add
  $router->map(
    'POST',
    '/tag/add',
    [
      'method' => 'createOrEdit',
      'controller' => TagController::class
    ],
    'tag-create'
  );
  
  // Display Tag add
  $router->map(
    'GET',
    '/tag/add/[i:id]',
    [
      'method' => 'edit',
      'controller' => TagController::class
    ],
    'tag-edit'
  );
  
  // Handle Tag add
  $router->map(
    'POST',
    '/tag/add/[i:id]',
    [
      'method' => 'createOrEdit',
      'controller' => TagController::class
    ],
    'tag-update'
  );
  
  // delete Tag
  $router->map(
    'GET',
    '/tag/[i:id]/delete',
    [
      'method' => 'delete',
      'controller' => TagController::class
    ],
    'tag-delete'
  );