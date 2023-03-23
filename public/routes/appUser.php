<?php

use App\Controllers\AppUserController;

// ---------------------------------------- Routes APP_USER  ----------------------------------------

// Liste des Users
$router->map(
    'GET',
    '/user/list',
    [
      'method' => 'list',
      'controller' => AppUserController::class
    ],
    'user-list'
  );
  
  // Affiche Connexion User
  $router->map(
    'GET',
    '/user/connection',
    [
      'method' => 'connect',
      'controller' => AppUserController::class
    ],
    'user-connection'
  );
  
  // Traite Connexion User
  $router->map(
    'POST',
    '/user/connection',
    [
      'method' => 'check',
      'controller' => AppUserController::class
    ],
    'user-check'
  );
  
  
  // Affiche Ajout User
  $router->map(
    'GET',
    '/user/add',
    [
      'method' => 'add',
      'controller' => AppUserController::class
    ],
    'user-add'
  );
  
  // Traite Ajout User
  $router->map(
    'POST',
    '/user/add',
    [
      'method' => 'create',
      'controller' => AppUserController::class
    ],
    'user-create'
  );
  
  // Affiche Modifie User
  $router->map(
    'GET',
    '/user/[i:id]/update',
    [
      'method' => 'edit',
      'controller' => AppUserController::class
    ],
    'user-edit'
  );
  
  // Traite Modifie User
  $router->map(
    'POST',
    '/user/[i:id]/update',
    [
      'method' => 'update',
      'controller' => AppUserController::class
    ],
    'user-update'
  );
  
  // Traite Supprime User
  $router->map(
    'GET',
    '/user/[i:id]/delete',
    [
      'method' => 'delete',
      'controller' => AppUserController::class
    ],
    'user-delete'
  );
  
  // Deconnecte le User
  $router->map(
    'GET',
    '/user/logout',
    [
      'method' => 'logout',
      'controller' => AppUserController::class
    ],
    'user-logout'
  );