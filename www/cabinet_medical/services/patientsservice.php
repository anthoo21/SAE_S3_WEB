<?php


namespace services;

use PDOException;

class PatientsService 
{
    



    private static $defaultService;

    /**
     * @return mixed
     *  the default instance of PatientsService used by controllers
     */
    public static function getDefaultService()
    {
        if (PatientsService::$defaultService == null) {
            PatientsService::$defaultService = new PatientsService();
        }
        return PatientsService::$defaultService;
    }
}