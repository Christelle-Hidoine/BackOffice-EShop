<?php

namespace App\Controllers;

class ErrorController extends CoreController
{
    /**
     * Method to display 404 error
     *
     * @return void
     */
    public function err404()
    {
        // On envoie le header 404
        header('HTTP/1.0 404 Not Found');

        // Puis on gère l'affichage
        $this->show('error/err404');
    }

    /**
     * Method to display 403 error
     *
     * @return void
     */
    public function err403()
    {
        // On envoie le header 403
        header('HTTP/1.0 403 Forbidden');

        // Puis on gère l'affichage
        $this->show('error/err403');
    }
}