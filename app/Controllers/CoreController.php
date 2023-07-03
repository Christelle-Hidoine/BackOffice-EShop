<?php

namespace App\Controllers;

abstract class CoreController
{
    // pour supprimer la global $router et $match on utiliser le construct = on passe les variables en paramètre
    protected $router;
    protected $match;

    public function __construct($router, $match)
    {
        $this->router = $router;
        $this->match = $match;

        // on définit une liste des permissions ACL (access control list) nécessitant une connexion utilisateur
        $acl = [
    
            // USER 
            'user-list' => ['admin'],
            'user-add' => ['admin'],
            'user-create' => ['admin'],
            'user-edit' => ['admin'],
            'user-update' => ['admin'],
            'user-delete' => ['admin'],
            // BRAND
            'brand-list' => ['catalog-manager', 'admin'],
            'brand-add' => ['catalog-manager', 'admin'],
            'brand-create' => ['catalog-manager', 'admin'],
            'brand-edit' => ['catalog-manager', 'admin'],
            'brand-update' => ['catalog-manager', 'admin'],
            'brand-delete' => ['catalog-manager', 'admin'],
            // CATEGORY
            'category-list' => ['catalog-manager', 'admin'],
            'category-add' => ['catalog-manager', 'admin'],
            'category-create' => ['catalog-manager', 'admin'],
            'category-edit' => ['catalog-manager', 'admin'],
            'category-update' => ['catalog-manager', 'admin'],
            'category-delete' => ['catalog-manager', 'admin'],
            // PRODUCT
            'product-list' => ['catalog-manager', 'admin'],
            'product-add' => ['catalog-manager', 'admin'],
            'product-create' => ['catalog-manager', 'admin'],
            'product-edit' => ['catalog-manager', 'admin'],
            'product-update' => ['catalog-manager', 'admin'],
            'product-delete' => ['catalog-manager', 'admin'],
            // TAG
            'tag-list' => ['catalog-manager', 'admin'],
            'tag-add' => ['catalog-manager', 'admin'],
            'tag-create' => ['catalog-manager', 'admin'],
            'tag-edit' => ['catalog-manager', 'admin'],
            'tag-update' => ['catalog-manager', 'admin'],
            'tag-delete' => ['catalog-manager', 'admin'],
            // TYPE
            'type-list' => ['catalog-manager', 'admin'],
            'type-add' => ['catalog-manager', 'admin'],
            'type-create' => ['catalog-manager', 'admin'],
            'type-edit' => ['catalog-manager', 'admin'],
            'type-update' => ['catalog-manager', 'admin'],
            'type-delete' => ['catalog-manager', 'admin'],
        ];

        // on vérifie si l'url demandée (nom de la route) nécessite une autorisation ($acl)
        // On a donc besoin de la route actuelle : $match['name']
        // ==> On doit donc récupérer $match
        // On récupère le nom de la route
        $routeName = $this->match['name'];
        
        // si la route existe dans $acl 
        if (array_key_exists($routeName,$acl))
        {
            // les roles autorisés sont les valeurs de chaque clé ($match['name]) de $acl
            $authorizedRoles = $acl[$routeName];

            // si oui = checkAuthorization();
            $this->checkAuthorization($authorizedRoles);
        }
        
        // else ? ==> pas besoin de else car si on ne rentre pas dans le if, ca signifie 
        // que la route n'est pas dans la liste $acl des routes à vérifier
        // càd toute le monde peut accéder librement et directement à cette route

        
        // Gestion des tokens anti-CSRF pour les routes en POST
        $csrfTokenToCheckInPost = [
            'user-create',
            'user-check',
            'user-update',
            'brand-create',
            'brand-update',
            'category-homeSelect',
            'category-create',
            'category-update',
            'product-create',
            'product-update',
            'tag-create',
            'tag-update',
            'type-create',
            'type-update'
        ];
        
        // Gestion des tokens anti-CSRF pour les routes en GET
        $csrfTokenToCheckInGet = [
            'user-delete',
            'brand-delete',
            'category-delete',
            'product-delete',
            'tag-delete',
            'type-delete',
        ];
        
        // Si la route en POST nécessite le check CSRF
        if (!empty($csrfTokenToCheckInPost) && in_array($routeName, $csrfTokenToCheckInPost)) {
            // On récupère le token en POST
            $token = isset($_POST['token']) ? $_POST['token'] : '';

            // $token = filter_input(INPUT_POST, 'token');
            // $token = $_POST['token'] ?? '';

            $this->getCsrfToken($token);
        }
          
        // Si la route en GET nécessite le check CSRF
        if (!empty($csrfTokenToCheckInGet) && in_array($routeName, $csrfTokenToCheckInGet)) {
            // On récupère le token en GET
            $token = isset($_GET['token']) ? $_GET['token'] : '';
            // $token = filter_input(INPUT_GET, 'token');
            // $token = $_GET['token'] ?? '';

            $this->getCsrfToken($token);
        }
    }

    /**
     * Method to display templates by their names and transfer data to these views
     *
     * @param string $viewName Template name
     * @param array $viewData Array with data
     * @return void
     */
    protected function show(string $viewName, $viewData = [])
    {
        // On globalise $router car on ne sait pas faire mieux pour l'instant
        // global $router;

        // avec les paramètres $router définit dans le construct, on peut appeler la propriété $router dans la méthode show sans passer par global

        $viewData['router'] = $this->router;

        // Comme $viewData est déclarée comme paramètre de la méthode show()
        // les vues y ont accès
        // ici une valeur dont on a besoin sur TOUTES les vues
        // donc on la définit dans show()
        $viewData['currentPage'] = $viewName;

        // définir l'url absolue pour nos assets
        $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] .'assets/';
        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        // On veut désormais accéder aux données de $viewData, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewData);
        // => la variable $currentPage existe désormais, et sa valeur est $viewName
        // => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        // => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        // => il en va de même pour chaque élément du tableau
       
        // Astuce pour voir les variables disponibles dans nos vues
        // A ne pas laisser en PROD !
        dump(get_defined_vars());


        // $viewData est disponible dans chaque fichier de vue
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }

    /**
     * Method ("helper" = public method) to check users' authorization by controllers
     *
     * @param [array] $authorizedRoles
     * @return void
     */
    protected function checkAuthorization($authorizedRoles)
    {
        // vérification si user connecté
        if (isset($_SESSION['userObject'])) {
            // récupération du User via la $_SESSION
            $user = $_SESSION['userObject'];

            // vérification de son rôle
            $role = $user->getRole();

            // Vérification si son rôle permet d'accéder à la page demandée ()
            if (in_array($role, $authorizedRoles)) {
                // si son rôle le permet => ok : on retourne true
                return true;
            } else {
                // sinon => ko : on renvoie une 403 "Forbidden"
                // On envoie le code 403 dans le header
                // Amélioration possible : créer un template 403 et rediriger vers cette page dédiée
                http_response_code(403);
                $this->show('error/err403');
                exit();
            }
            // si User pas connecté redirection vers page de connexion
        } else { 
            header("Location: " . $this->router->generate('user-connection'));
            exit();
        }   
    }

    /**
     * Method to check if the form's token matches with session's token
     *
     * @param string $token
     * @return void
     */
    protected function getCsrfToken(string $token)
    {
        // On récupère le token en SESSION
        $sessionToken = isset($_SESSION['token']) ? $_SESSION['token'] : '';
        // $sessionToken = $_SESSION['token'] ?? '';
        
        // S'ils ne sont pas égaux ou vide
        if ($token !== $sessionToken || empty($token)) {
            // Alors on affiche une 403
            $this->show('error/err403');
            exit;
        } else { // Sinon, tout va bien
            // On supprime le token en session
            // Ainsi, on ne pourra pas soumettre plusieurs fois le même formulaire, ni réutiliser ce token
            unset($_SESSION['token']);
        }
    }

    /**
     * Method to generate a random token
     *
     * @return string
     */
    protected function generateToken()
    {
        // génération d'un token aléatoire
        $_SESSION['token'] = bin2hex(random_bytes(10));
        return $_SESSION['token'];
    }
}