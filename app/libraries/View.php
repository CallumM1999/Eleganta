<?php

class View {
    public static function render($view, $data = []) {

        // Determine is view loaded from Route::view() or controller
        // With a controller, the file would be stored in /controller/filename.php
        // instead of /filename.php

        $fromView = debug_backtrace()[1]['class'] === 'Route';
        $fromController = debug_backtrace()[2]['class'] === 'Controller';

        $filePath = '';

        if ($fromView) {
            $filePath = APPROOT . '/views/' . $view . '.php';            
        } else if ($fromController) {
            // Controller name
            $cname = debug_backtrace()[1]['class'];
            $filePath = APPROOT . '/views/' . $cname . '/' . $view . '.php';
        } else {
            $filePath = APPROOT . '/views/' . $view . '.php'; 
        }

        require_once $filePath;
    }
}