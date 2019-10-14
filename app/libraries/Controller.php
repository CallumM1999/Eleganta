<?php

    abstract class Controller {
        // Load model
        protected function model($model) {
            require_once APPROOT . '/models/' . $model . '.php';

            // Instantiate Model
            return new $model();
        }
    }