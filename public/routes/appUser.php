<?php

use App\Controllers\AppUserController;

// ---------------------------------------- Routes APP_USER  ----------------------------------------

// Users list
$router->map(
    'GET',
    '/user/list',
    [
      'method' => 'list',
      'controller' => AppUserController::class
    ],
    'user-list'
  );
  
  // User login
  $router->map(
    'GET',
    '/user/connection',
    [
      'method' => 'connect',
      'controller' => AppUserController::class
    ],
    'user-connection'
  );
  
  // User login handling
  $router->map(
    'POST',
    '/user/connection',
    [
      'method' => 'check',
      'controller' => AppUserController::class
    ],
    'user-check'
  );
  
  
  // Display User add
  $router->map(
    'GET',
    '/user/add',
    [
      'method' => 'add',
      'controller' => AppUserController::class
    ],
    'user-add'
  );
  
  // Handle User add
  $router->map(
    'POST',
    '/user/add',
    [
      'method' => 'create',
      'controller' => AppUserController::class
    ],
    'user-create'
  );
  
  // Display User Update
  $router->map(
    'GET',
    '/user/[i:id]/update',
    [
      'method' => 'edit',
      'controller' => AppUserController::class
    ],
    'user-edit'
  );
  
  // Handle User update
  $router->map(
    'POST',
    '/user/[i:id]/update',
    [
      'method' => 'update',
      'controller' => AppUserController::class
    ],
    'user-update'
  );
  
  // Handle User delete
  $router->map(
    'GET',
    '/user/[i:id]/delete',
    [
      'method' => 'delete',
      'controller' => AppUserController::class
    ],
    'user-delete'
  );
  
  // User Logout
  $router->map(
    'GET',
    '/user/logout',
    [
      'method' => 'logout',
      'controller' => AppUserController::class
    ],
    'user-logout'
  );