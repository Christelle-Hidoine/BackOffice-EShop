<?php

use App\Controllers\CategoryController;

// ---------------------------------------- Routes CATEGORY  ----------------------------------------

// Categories list
$router->map(
    'GET',
    '/category/list',
    [
      'method' => 'list',
      'controller' => CategoryController::class 
    ],
    'category-list'
  );
  
  // Display Category selection homepage
  $router->map(
    'GET',
    '/category/home',
    [
      'method' => 'homeList',
      'controller' => CategoryController::class
    ],
    'category-home'
  );
  
  // Handle Category selection homepage
  $router->map(
    'POST',
    '/category/home',
    [
      'method' => 'homeSelect',
      'controller' => CategoryController::class
    ],
    'category-homeSelect'
  );
  
  // Display Category add
  $router->map(
    'GET',
    '/category/add',
    [
      'method' => 'add',
      'controller' => CategoryController::class 
    ],
    'category-add'
  );
  
  // Handle Category add
  $router->map(
    'POST',
    '/category/add',
    [
      'method' => 'create',
      'controller' => CategoryController::class 
    ],
    'category-create'
  );
  
  // Display Category update
  $router->map(
    'GET',
    '/category/[i:id]/update',
    [
      'method' => 'edit',
      'controller' => CategoryController::class
    ],
    'category-edit'
  );
  
  // Handle Category Update
  $router->map(
    'POST',
    '/category/[i:id]/update',
    [
      'method' => 'update',
      'controller' => CategoryController::class
    ],
    'category-update'
  );
  
  // Delete category
  $router->map(
    'GET',
    '/category/[i:id]/delete',
    [
      'method' => 'delete',
      'controller' => CategoryController::class
    ],
    'category-delete'
  );