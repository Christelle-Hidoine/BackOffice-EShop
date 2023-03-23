<?php

use App\Controllers\BrandController;

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