<?php
namespace controllers;

use yasmf\View;

class HomeController {

    public function index() {
        $view = new View("SAE_S3_WEB/views/accueil");
        $view->setVar('erreurLog', false);
        return $view;
    }

}