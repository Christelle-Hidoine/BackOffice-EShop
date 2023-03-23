<?php

use App\Controllers\TypeController;

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
  