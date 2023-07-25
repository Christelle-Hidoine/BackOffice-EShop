<?php

namespace App\Controllers;

abstract class CoreController
{
    protected $router;
    protected $match;

    public function __construct($router, $match)
    {
        $this->router = $router;
        $this->match = $match;

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
            'category-home' => ['catalog-manager', 'admin'],
            'category-homeSelect' => ['catalog-manager', 'admin'],
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

        $routeName = $this->match['name'];

        if (array_key_exists($routeName,$acl))
        {
            $authorizedRoles = $acl[$routeName];
            $this->checkAuthorization($authorizedRoles);
        }
        
        // Handling POST Routes with token
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
        
        // Handling GET Routes with token
        $csrfTokenToCheckInGet = [
            'user-delete',
            'brand-delete',
            'category-delete',
            'product-delete',
            'tag-delete',
            'type-delete',
        ];
        
        if (!empty($csrfTokenToCheckInPost) && in_array($routeName, $csrfTokenToCheckInPost)) {

            $token = isset($_POST['token']) ? $_POST['token'] : '';
            $this->getCsrfToken($token);
        }

        if (!empty($csrfTokenToCheckInGet) && in_array($routeName, $csrfTokenToCheckInGet)) {

            $token = isset($_GET['token']) ? $_GET['token'] : '';
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
        $viewData['router'] = $this->router;
        $viewData['currentPage'] = $viewName;

        extract($viewData);

        // dump(get_defined_vars());      

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
        if (isset($_SESSION['userObject'])) {

            $user = $_SESSION['userObject'];
            $role = $user->getRole();

            if (in_array($role, $authorizedRoles)) {
                return true;
            } else {

                http_response_code(403);
                $this->show('error/err403');
                exit();
            }

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
        $sessionToken = isset($_SESSION['token']) ? $_SESSION['token'] : '';

        if ($token !== $sessionToken || empty($token)) {
            $this->show('error/err403');
            exit;
        } else { 
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
        $_SESSION['token'] = bin2hex(random_bytes(10));
        return $_SESSION['token'];
    }
}