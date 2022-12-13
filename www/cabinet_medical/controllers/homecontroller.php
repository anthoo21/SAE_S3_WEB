<?php
namespace controllers;

use yasmf\View;

class HomeController {

    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     */
    public function index() {
        $view = new View("cabinet_medical/views/accueil");
        return $view;
    }

}