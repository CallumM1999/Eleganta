<?php

class View {
    public static function render($view) {
        // echo $view;


        $params = explode('@', $view);

        $cname = $params[0];
        $page = (isset($params[1])) ? $params[1] : 'index';

        require_once APPROOT . '/views/' . $cname . '/' . $page . '.php';

    }
}