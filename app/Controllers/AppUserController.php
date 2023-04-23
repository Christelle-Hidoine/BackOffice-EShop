<?php

namespace App\Controllers;

use App\Models\AppUser;


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
        $this->show("appUser/list", ['users' => $users]);
    }

    /**
     * Method to display user's add form
     *
     */
    public function add()
    {
        $users = AppUser::findAll();
        
        $this->show("appUser/add", ['user' => new AppUser, 'users' => $users]);
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

        // vérification de la sécurité du mot de passe
        // $check = $this->checkPassword($password);
        // if ($check === true) {
            // Si on a rencontré aucune erreur => si $errorList est vide donc
            if (empty($errorList)) {
                $user = new AppUser();

                // on hash le mdp
                $passwordHashed = password_hash($password, PASSWORD_BCRYPT);

                // On met à jour ses propriétés avec les données du formulaire (nettoyées)
                $user->setFirstName($firstname);
                $user->setLastName($lastname);
                $user->setEmail($email);
                $user->setPassword($passwordHashed);
                $user->setRole($role);
                $user->setStatus($status);

                // ajout en BDD
                if ($user->save()) {
                    // Si la sauvegarde a fonctionné
                    // header("Location: /user/list");

                    header("Location: " . $this->router->generate('user-list'));
                    exit;

                } else {
                    $message = "Echec de la sauvegarde en BDD";
                    $this->show("appUser/add", ['error' => $message]);
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
                
                // On affiche chaque erreurs rencontrée et renvoi vers la page formulaire create avec l'autocomplétion
                $message = $errorList;
                
                $this->show("appUser/add", ['error' => $message, 'user' => $user]);
            } 
            // si le mot de passe n'est pas suffisamment sécurisé = message d'erreur  
        // } else {
        //     $message = $check;
        //     $this->show("appUser/add",['check' => $message]);
        // }
    }

    /**
     * Method to display user's connection (login)
     *
     */
    public function connect()
    {
        // on récupère l'objet user pour l'autocomplétion du formulaire si erreur dans la méthode check
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
        // $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
        // dump($email);
        $password = filter_input(INPUT_POST, "password");

        $errorList = [];

        if (empty($email)) {
            $errorList[] = "L'adresse email doit être indiquée";
        }

        if (empty($password)) {
            $errorList[] = "Le mot de passe doit être indiqué";
        }
        
        // si pas d'erreur de remplissage des champs du formulaire
        if (empty($errorList)) {

            // on récupère l'email correspondant dans la BDD
            $user = AppUser::findByEmail($email);
            // dump($user);

            // on vérifie qu'il correspond à notre BDD = return true ou false
            if ($user !== false) {

                // V2 : on doit modifier le if précédent car à présent tous les password sont hashés
                // https://www.php.net/manual/fr/function.password-verify.php
                if (password_verify($password, $user->getPassword())) {

                // Email et password associé sont bons
                // on le compare au password saisi dans le formulaire

                // on récupère les données de la $_SESSION (suite à session_start() dans l'index)
                    $_SESSION['userObject'] = $user;
                    $_SESSION['userId'] = $user->getId();
                        
                    // dump($user);

                    header("Location: " . $this->router->generate('main-home'));
                    exit;

                } else {
                    // si mdp différent = message d'erreur
                    $message = "Email et/ou mot de passe incorrect";

                    // on récupère les infos pour autocompléter le formulaire avec les données rentrées
                    $user = new AppUser();
                    $user->setEmail($email);
                    $this->show("appUser/connection", ['error' => $message, 'user' => $user, 'token' => $this->generateToken()]);
                }
            } else {
                // si user n'existe pas = message d'erreur
                $message = "Email et/ou mot de passe incorrect";
                $user= new AppUser();
                $user->setEmail($email);
                $this->show("appUser/connection", ['error' => $message, 'user' => $user, 'token' => $this->generateToken()]);
            }
        } else {
            // on récupère la liste des erreurs et on l'affiche sur la tpl avec une boucle
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
        $this->show("appUser/edit", ["user" => $user]);
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

        // Maintenant on vérifie les valeurs de ces variables "filtrées"
        // Pour ça on créé un tableau qui va contenir toutes les erreurs rencontrées
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

        // Si je n'ai rencontré aucune erreur, $errorList est vide
        if(empty($errorList))
        {
            // On commence par récupérer la catégorie actuellement en BDD
            $user = AppUser::find($id);

            $passwordHashed = password_hash($password, PASSWORD_BCRYPT);

            // On modifie ses propriétés grace aux setters      
            $user->setFirstName($firstname);
            $user->setLastName($lastname);
            $user->setEmail($email);
            $user->setPassword($passwordHashed);
            $user->setRole($role);
            $user->setStatus($status);


            if ($user->save()) {
                // Si la sauvegarde a fonctionné
                // header("Location: /user/list");

                header("Location: " . $this->router->generate('user-list'));
                exit;
            } else {
                $message = "Echec de la sauvegarde en BDD";
                $this->show("appUser/edit", ['error' => $message]);
            }
        } else { 

            $user = AppUser::find($id);

            $passwordHashed = password_hash($password, PASSWORD_BCRYPT);

            // On modifie ses propriétés grace aux setters      
            $user->setFirstName($firstname);
            $user->setLastName($lastname);
            $user->setEmail($email);
            $user->setPassword($passwordHashed);
            $user->setRole($role);
            $user->setStatus($status);

            // Sinon, on affiche les erreurs
            // On affiche chaque erreur rencontrée et renvoi vers la page formulaire create
            $message = $errorList;
            $this->show("appUser/edit", ['error' => $message, 'user' => $user]);
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
            return session_unset();
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
    public function checkPassword($password)	
    { 
            $lenght = strlen($password);

            $oneCaps = preg_match('/[A-Z]/', $password);

            $oneLowCase = preg_match('/[a-z]/', $password);

            $oneNumber = preg_match('/\d/', $password);

            $oneSpecialChar = preg_match('/[_\-|%&*=@$]/', $password);

            // mdp : > 8 caractères, contient mini 1 minuscule, 1 majuscule, 1 chiffre et 1 caractère spécial
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
    
            $this->show("appUser/list", ['users' => $users, ['error' => $message]]);
        }
    }
}