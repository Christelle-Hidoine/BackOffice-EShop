<?php

namespace App\Controllers;

use App\Models\AppUser;

class AppUserController extends CoreController

{
    /**
     * Méthode pour afficher le formulaire d'ajout
     *
     */
    public function add()
    {
        $this->show("appUser/add");
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
            // Si une errorList existe = message avec les erreurs concernées par les champs vides
            foreach($errorList as $error)
            {
                echo "<p>{$error}</p>";
            }
        }
    }
}