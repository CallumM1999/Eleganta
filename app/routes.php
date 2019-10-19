<?php

    Route::get('/', 'Base@home');
    Route::post('/post', 'Base@post');
    Route::match(['get', 'post', 'delete'], '/match', 'Base@match');
    Route::any('/any', 'Base@any');
    Route::view('/view', 'view', [
        "message" => "some message",
        "title" => "View Page"
    ]); // Cannot encode params in url

    Route::any('/middleware', 'auth', 'Base@middleware');

    Route::any('/func', function($request, $params) {

        $data = [
            "title" => "Page title"
        ];

        View::render('func', $data);
    });

    Route::view('/redirectend', 'redirect', ["title" => "Redirect Page"]);
    Route::redirect('/redirect', '/redirectend');

    Route::any('*', 'Base@notfound');