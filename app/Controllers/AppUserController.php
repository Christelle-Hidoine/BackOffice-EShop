<?php

namespace App\Controllers;

use App\Models\AppUser;

class AppUserController extends CoreController

{
    /** 
     * Méthode pour afficher la liste des users
     *
     */
    public function list()
    {
        $this->checkAuthorization(['admin']);

        $users = AppUser::findAll();

        $this->show("appUser/list", ['users' => $users]);
    }



    /**
     * Méthode pour afficher le formulaire d'ajout
     *
     */
    public function add()
    {
        $this->checkAuthorization(['admin']);
        $this->show("appUser/add");
    }


    /**
     * Méthode pour traiter l'ajout d'un user
     *
     */
    public function create()
    {
        $this->checkAuthorization(['admin']);
        // dump( $_POST );

        $firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_SPECIAL_CHARS);
        $email  = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, "password");
        $role = filter_input(INPUT_POST, "role");
        $status = filter_input(INPUT_POST, "status", FILTER_VALIDATE_INT);


        // On vérifie les valeurs de ces variables "filtrées"
        $errorList = [];

        if(empty($firstname)) 
        {
            $errorList[] = 'Merci de compléter le champs prénom';
        }

        if(empty($lastname)) 
        {
            $errorList[] = 'Merci de compléter le champs nom';
        }

        if(empty($email)) 
        {
            $errorList[] = 'Merci de compléter l\'email';
        }

        if(empty($password)) 
        {
            $errorList[] = 'Merci d\'indiquer un mot de passe';
        }

        // Si on a rencontré aucune erreur => si $errorList est vide donc
        if(empty($errorList))
        {
            $user = new AppUser; 

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
            if($user->save())
            {
                // Si la sauvegarde a fonctionné
                header( "Location: /user/list" );
                exit;
            }
            else
            {
                echo "Echec de la sauvegarde en BDD";
            }
        }
        else // Sinon, on affiche les erreurs 
        {
        // On affiche chaque erreurs rencontrée
        foreach($errorList as $error)
        {
            echo $error . "<br>";
        }
        }
    }

    /**
     * Méthode pour afficher la page de connexion
     *
     */
    public function connect()
    {
        $this->show("appUser/connection");
    }

    /**
     * Méthode pour récupérer et traiter la page de connexion
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

        // si pas d'erreur de remplissage des champs du formulaire
        if (empty($errorList)) {

            // on récupère l'email correspondant dans la BDD
            $user = AppUser::findByEmail($email);
            // dump($appUserEmail);

            // on vérifie qu'il correspond à notre BDD = return true ou false
            if ($user !== false) {

                // V2 : on doit modifier le if précédent car à présent tous les password sont hashés
                // https://www.php.net/manual/fr/function.password-verify.php
                if (password_verify($password, $user->getPassword())) {

                // Email et password associé sont bons
                // on le compare au password saisi dans le formulaire

                    $_SESSION['userId'] = $user->getId();
                    $_SESSION['userObject'] = $user;
                    $_SESSION['userName'] = $user->getFirstName();

                    echo "Bravo {$_SESSION['userName']}, Vous êtes bien connecté(e)";
                    dump($user);

                } else {
                    // si mdp différent = message d'erreur sur le mdp
                    echo "Email et/ou mot de passe incorrect";
                    
                }
            } else {
                // si user n'existe pas = message d'erreur
                echo "Email et/ou mot de passe incorrects";
            }
        } else {
            header('Location: /user/add');
            foreach($errorList as $error)
            {
                echo "<p>{$error}</p>";
            }
            dump($error);
        }
    }

    public function logout()
        {
            if (isset($_SESSION['UserId']))
            {
                return session_unset($_SESSION);
                header("Location: /user/connection");
            }
            session_destroy();
            header("Location: /user/connection");
        }
    
}