<?php 

use App\Controllers\TagController;

// -------------------------------- Routes Tag ---------------------------------------

// Afficher la List
$router->map(
    'GET',
    '/tag/list',
    [
        'method' => 'list',
        'controller' => TagController::class
    ],
    'tag-list'
);

// Affiche Ajout Tag
$router->map(
    'GET',
    '/tag/add',
    [
      'method' => 'add',
      'controller' => TagController::class
    ],
    'tag-add'
  );
  
  // Traiter Ajout Tag
  $router->map(
    'POST',
    '/tag/add',
    [
      'method' => 'createOrEdit',
      'controller' => TagController::class
    ],
    'tag-create'
  );
  
  // Afficher Modifie Tag
  $router->map(
    'GET',
    '/tag/add/[i:id]',
    [
      'method' => 'edit',
      'controller' => TagController::class
    ],
    'tag-edit'
  );
  
  // Traiter Modifie Tag
  $router->map(
    'POST',
    '/tag/add/[i:id]',
    [
      'method' => 'createOrEdit',
      'controller' => TagController::class
    ],
    'tag-update'
  );
  
  // Supprime le Tag
  $router->map(
    'GET',
    '/tag/[i:id]/delete',
    [
      'method' => 'delete',
      'controller' => TagController::class
    ],
    'tag-delete'
  );