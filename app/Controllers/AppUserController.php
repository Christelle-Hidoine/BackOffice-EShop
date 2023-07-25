<?php

namespace App\Controllers;

use App\Models\AppUser;
use Dispatcher;

class AppUserController extends CoreController

{
    /** 
     * Method to display user's list
     *
     */
    public function list()
    {
        // $this->checkAuthorization('admin');
        $users = AppUser::findAll();
        $this->show("appUser/list", ['users' => $users, 'token' => $this->generateToken()]);
    }

    /**
     * Method to display user's add form
     *
     */
    public function add()
    {
        $users = AppUser::findAll();
        
        $this->show("appUser/add", ['user' => new AppUser, 'users' => $users, 'token' => $this->generateToken()]);
    }

    /**
     * Method to retrieve data from user's add form
     *
     */
    public function create()
    {
        $firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_SPECIAL_CHARS);
        $email  = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, "password");
        $role = filter_input(INPUT_POST, "role");
        $status = filter_input(INPUT_POST, "status", FILTER_VALIDATE_INT);

        // On vérifie les valeurs de ces variables "filtrées"
        $errorList = [];

        if (empty($firstname)) {
            $errorList[] = 'Merci de compléter le champs prénom';
        }

        if (empty($lastname)) {
            $errorList[] = 'Merci de compléter le champs nom';
        }

        if (empty($email)) {
            $errorList[] = 'Merci de compléter l\'email';
        }

        if (empty($password)) {
            $errorList[] = 'Merci d\'indiquer un mot de passe';
        }

        if ($this->checkPassword($password) === false) {
            $errorList[] = "Le mot de passe doit contenir au minimum 8 caractères, 1 minuscule, 1 majuscule, 1 chiffre et 1 caractère spécial";
        }

            if (empty($errorList)) {
                $user = new AppUser();

                $passwordHashed = password_hash($password, PASSWORD_BCRYPT);

                $user->setFirstName($firstname);
                $user->setLastName($lastname);
                $user->setEmail($email);
                $user->setPassword($passwordHashed);
                $user->setRole($role);
                $user->setStatus($status);

                if ($user->save()) {
                    // header("Location: /user/list");
                    header("Location: " . $this->router->generate('user-list'));
                    exit;

                } else {
                    $message = "Echec de la sauvegarde en BDD";
                    $this->show("appUser/add", ['error' => $message, 'token' => $this->generateToken()]);
                }
            } else { 
                $user = new AppUser();
                $passwordHashed = password_hash($password, PASSWORD_BCRYPT);

                $user->setFirstName($firstname);
                $user->setLastName($lastname);
                $user->setEmail($email);
                $user->setPassword($passwordHashed);
                $user->setRole($role);
                $user->setStatus($status);
                
                $message = $errorList;
                
                $this->show("appUser/add", ['error' => $message, 'user' => $user, 'token' => $this->generateToken()]);
            } 
    }

    /**
     * Method to display user's connection (login)
     *
     */
    public function connect()
    {
        $user = new AppUser();

        $this->show("appUser/connection", ['user' => $user, 'token' => $this->generateToken()]);
    }

    /**
     * Method to retrieve and check data from user's connection form
     *
     */
    public function check()
    {
        $email    = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, "password");

        $errorList = [];

        if (empty($email)) {
            $errorList[] = "L'adresse email doit être indiquée";
        }

        if (empty($password)) {
            $errorList[] = "Le mot de passe doit être indiqué";
        }

        if (empty($errorList)) {

            $user = AppUser::findByEmail($email);

            if ($user !== false) {

                // https://www.php.net/manual/fr/function.password-verify.php
                if (password_verify($password, $user->getPassword())) {

                    $_SESSION['userObject'] = $user;
                    $_SESSION['userId'] = $user->getId();
                    $_SESSION['userName'] = $user->getFirstname();

                    header("Location: " . $this->router->generate('main-home'));
                    exit;

                } else {

                    $message = "Email et/ou mot de passe incorrect";

                    $user = new AppUser();
                    $user->setEmail($email);

                    $this->show("appUser/connection", ['error' => $message, 'user' => $user, 'token' => $this->generateToken()]);
                }
            } else {

                $message = "Email et/ou mot de passe incorrect";
                $user= new AppUser();
                $user->setEmail($email);

                $this->show("appUser/connection", ['error' => $message, 'user' => $user, 'token' => $this->generateToken()]);
            }
        } else {

            $message = $errorList;
            $user = new AppUser();
            $user->setEmail($email);

            $this->show("appUser/connection", ['errorList' => $message, 'user' => $user, 'token' => $this->generateToken()]);        
        }
    }

    /**
     * Method to display edit's user
     *
     * @param [int] $id
     * @return void
     */
    public function edit($id)
    { 
        $user = AppUser::find($id);
        $this->show("appUser/edit", ["user" => $user, 'token' => $this->generateToken()]);
    }

    /**
     * Method to retrieve data from edit's user form
     *
     * @param [int] $id
     * @return void
     */
    public function update($id)
    {    
        $firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_SPECIAL_CHARS);
        $email  = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, "password");
        $role = filter_input(INPUT_POST, "role");
        $status = filter_input(INPUT_POST, "status", FILTER_VALIDATE_INT);

        $errorList = [];

        if (empty($firstname)) {
            $errorList[] = 'Merci de compléter le champs prénom';
        }

        if (empty($lastname)) {
            $errorList[] = 'Merci de compléter le champs nom';
        }

        if (empty($email)) {
            $errorList[] = 'Merci de compléter l\'email';
        }

        if (empty($password)) {
            $errorList[] = 'Merci d\'indiquer un mot de passe';
        }

        if(empty($errorList))
        {
            $user = AppUser::find($id);

            $passwordHashed = password_hash($password, PASSWORD_BCRYPT);
  
            $user->setFirstName($firstname);
            $user->setLastName($lastname);
            $user->setEmail($email);
            $user->setPassword($passwordHashed);
            $user->setRole($role);
            $user->setStatus($status);


            if ($user->save()) {

                // header("Location: /user/list");
                header("Location: " . $this->router->generate('user-list'));
                exit;
            } else {
                $message = "Echec de la sauvegarde en BDD";
                $this->show("appUser/edit", ['error' => $message, 'token' => $this->generateToken()]);
            }
        } else { 

            $user = AppUser::find($id);

            $passwordHashed = password_hash($password, PASSWORD_BCRYPT);
    
            $user->setFirstName($firstname);
            $user->setLastName($lastname);
            $user->setEmail($email);
            $user->setPassword($passwordHashed);
            $user->setRole($role);
            $user->setStatus($status);

            $message = $errorList;
            $this->show("appUser/edit", ['error' => $message, 'user' => $user, 'token' => $this->generateToken()]);
        } 
    }

    /**
     * Method to logout and delete session 
     *
     * @return void
     */
    public function logout()
    {
        if (isset($_SESSION['userId']))
        {
            session_unset();
            header("Location: /user/connection");
        }
        session_destroy();
        header("Location: /user/connection");
    }

    /**
     * Method to check password's security
     *
     * @param [string] $password
     * @return bool
     */
    public static function checkPassword($password)	
    { 
            $lenght = strlen($password);

            $oneCaps = preg_match('/[A-Z]/', $password);

            $oneLowCase = preg_match('/[a-z]/', $password);

            $oneNumber = preg_match('/\d/', $password);

            $oneSpecialChar = preg_match('/[_\-|%&*=@$]/', $password);

            return $lenght >= 8 && $oneCaps && $oneLowCase && $oneNumber && $oneSpecialChar;

    }
    
    /**
     * Method to delete a user from user's list
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id)
    {
        $user = AppUser::find($id);  

        if($user->delete())
        {
            // header("Location: /user/list");
            header("Location: " . $this->router->generate('user-list'));
            exit;
        }
        else
        {
            $message = "Echec de la suppression de l'utilisateur";
            $users = AppUser::findAll();
    
            $this->show("appUser/list", ['users' => $users, ['error' => $message, 'token' => $this->generateToken()]]);
        }
    }
}