<?php

require_once '../vendor/autoload.php';

use App\Controllers\MainController;

/* -------------------
--- SESSION STORAGE ---
--------------------*/

session_start();

/* ------------
--- ROUTAGE ---
-------------*/

$router = new AltoRouter();

// ----------------------------------------Routes HOME ----------------------------------------

$router->map(
  'GET',
  '/',
  [
    'method' => 'home',
    'controller' => MainController::class
  ],
  'main-home'
);

require_once __DIR__ . '/routes/appUser.php';
require_once __DIR__ . '/routes/brand.php';
require_once __DIR__ . '/routes/category.php';
require_once __DIR__ . '/routes/product.php';
require_once __DIR__ . '/routes/type.php';
require_once __DIR__ . '/routes/tag.php';


/* -------------
--- DISPATCH ---
--------------*/

$match = $router->match();

$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
$dispatcher->setControllersArguments($router, $match);

$dispatcher->dispatch();