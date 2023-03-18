<?php

namespace App\Controllers;

abstract class CoreController
{
    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewData Tableau des données à transmettre aux vues
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
     * Méthode ("helper" = méthode public) pour vérifier les autorisations des users via les controllers
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
                echo '403';
                exit();
            }
            // si User pas connecté redirection vers page de connexion
        } else { 
            header("Location: /user/connection");
            exit();
        }   
    }
}