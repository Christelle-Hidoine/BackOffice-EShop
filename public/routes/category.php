<?php

use App\Controllers\CategoryController;

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