<?php

/*
    Framework Core Class
    Formats URL and passes to router

*/

    // load config
    // load libraries
    // load routes.php file


    // =======
    // Routes class
    // =======

    // (how to add middleware)

    // get path
    // check if path and method is valid
    // add data to request and response
    // search for attached controller
    
    // =======
    // Controller class
    // =======

    // Load method
    // Load model
    // run code
    // render view


    class App {
        public function __construct() {
            // Load app config
            require_once '../app/config/config.php';

            // Autoload Core Libraries
            spl_autoload_register(function($className) {
                require_once  APPROOT . '/libraries/' . $className . '.php';
            });

            require_once APPROOT . '/routes.php';
        }
    }
