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
        header('HTTP/1.0 404 Not Found');
        $this->show('error/err404');
    }

    /**
     * Method to display 403 error
     *
     * @return void
     */
    public function err403()
    {
        header('HTTP/1.0 403 Forbidden');
        $this->show('error/err403');
    }
}
