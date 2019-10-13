<?php

    Route::get('/', 'Base@home');
    Route::post('/post', 'Base@post');
    Route::match(['get', 'post', 'delete'], '/match', 'Base@match');
    Route::any('/any', 'Base@any');
    Route::view('/view', 'view', ["message" => "some message"]); // Cannot encode params in url

    Route::any('/middleware', 'auth', 'Base@middleware');

    Route::any('/func', function($request, $params) {
        
        echo "Inline function method works";

    });

    Route::view('/redirectend', 'redirect');
    Route::redirect('/redirect', '/redirectend');

    Route::any('*', 'Base@notfound');