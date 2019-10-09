<?php

    class View {
        public static function render($name) {
            $params = explode('@', $name);

            $cname = $params[0];
            $page = (isset($params[1])) ? $params[1] : 'index';

            require_once APPROOT . '/controllers/' . $cname . '.php';

            new $cname($page);
        }
    }

    Route::get('/', function($request, $response) {
        View::render('User');
    });
    
    Route::get('/memes', function($request, $response) {
        // echo "memes page";

        View::render('User@profile');
    });