<?php

namespace App\Controllers;

abstract class CoreController
{
    public function __construct()
    {
        // on définit une liste des permissions ACL (access control list)
        $acl = [
            'user-list' => ['admin'],
            'user-add' => ['admin'],
            'user-create' => ['admin'],
            'user-edit' => ['admin'],
            'user-update' => ['admin'],
            'user-delete' => ['admin'],
        ];

        // on vérifie si l'url demandée (nom de la route) nécessite une autorisation ($acl)
        // On a donc besoin de la route actuelle : $match['name']
        // ==> On doit donc récupérer $match
        global $match;
        // On récupère le nom de la route
        $routeName = $match['name'];
        
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
        // cad toute le monde peut accéder librement et directement à cete route

        /*
        * Gestion du CSRF : exemple sur le form user/add
        */ 
        $csrfTokenToCheck = [
            'user-create',
            
        ];


        // Si la route nécessite le check CSRF
        if (in_array($routeName, $csrfTokenToCheck)) {
            // On récupère le token en POST
            $postToken = isset($_POST['token']) ? $_POST['token'] : '';

            // On récupère le token de la session
            $sessionToken = isset($_SESSION['token']) ? $_SESSION['token'] : '';

            // On lève une erreur 403 s'ils sont vides ou pas égaux
            if ($postToken !== $sessionToken || empty($postToken)) {
                // On affiche une erreur 403
                // => on envoie le header "403 Forbidden"
                http_response_code(403);
                // Puis on affiche la (nouvelle) page d'erreur 403
                $this->show('error/err403');
                // Enfin on arrête le script pour que la page demandée ne s'affiche pas
                exit();
            } else {
                // Sinon RAS, on supprime juste le token en session
                unset($_SESSION['token']);
            }
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
        global $router;

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
        dump($_SESSION);

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
        if (isset($_SESSION['userId'])) {
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
            header("Location: /user/connection");
            exit();
        }   
    }
}