<?php

    Route::get('/', 'User');
    Route::post('/profile', 'User@profile');

    // Route::post('/profile', 'User@post_profile');


    // Route::any('*', 'Base@notfound');

    Route::match(['get', 'post'], '/yeet', 'Base@notfound');

