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
            $errorList[] = "L'adresse email est vide";
        }

        if (empty($password)) {
            $errorList[] = "Le mot de passe doit être indiqué";
        }

        // si pas d'erreur de remplissage des champs du formulaire
        if (empty($errorList)) {

            // on récupère l'email correspondant dans la BDD
            $appUserEmail = AppUser::findByEmail($email);
            // dump($appUserEmail);

            // on vérifie qu'il correspond à notre BDD = return true ou false
            if ($appUserEmail === false) {
                // si false = message d'erreur sur l'email
                echo "Email et/ou mot de passe incorrect";
            } else {
                // on le compare au password saisi dans le formulaire
                $appUserPassword = $appUserEmail->getPassword();

                if ($appUserPassword !== $password) {
                    // si différent = message d'erreur sur le mdp
                    echo "Email et/ou mot de passe incorrect";
                    // sinon affiche message succès 
                } else {
                    
                    $_SESSION['userId'] = $appUserEmail->getId();
                    $_SESSION['userObject'] = $appUserEmail;
                    $_SESSION['userName'] = $appUserEmail->getFirstName();

                    echo "Bravo {$_SESSION['userName']}, Vous êtes bien connecté(e)";
                }
            }
        } else {
            
            // On affiche les erreurs
            foreach($errorList as $error)
            {
                echo "<p>{$error}</p>";
            }
        }
    }
}