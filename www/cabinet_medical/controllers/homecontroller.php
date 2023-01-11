<?php
namespace controllers;

use yasmf\View;

class HomeController {

    public function index() {
        $view = new View("cabinet_medical/views/accueil");
        $view->setVar('erreurLog', false);
        return $view;
    }

}