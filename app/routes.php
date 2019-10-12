<?php

    Route::get('/', 'User');
    Route::get('/profile', 'User@profile');

    Route::post('/profile', 'User@post_profile');

