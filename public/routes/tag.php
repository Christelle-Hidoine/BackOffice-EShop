<?php 

// -------------------------------- Routes Tag ---------------------------------------

// Afficher le form List
$router->map(
    'GET',
    '/tag/list',
    [
        'method' => 'list',
        'controller' => TagController::class
    ],
    'tag-list'
);