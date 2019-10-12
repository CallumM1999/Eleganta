<?php

class View {
    public static function render($view, $data = []) {

        // Controller name
        $cname = debug_backtrace()[1]['class'];
        $filePath = APPROOT . '/views/' . $cname . '/' . $view . '.php';
        require_once $filePath;
    }
}