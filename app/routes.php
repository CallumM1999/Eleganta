<?php

    // Route::get('/', 'User');



    // Route::get('/', function() {
    //     echo "yeet";
    // });


    // Route::any('/profile/{id}/{name}', 'User@profile');

    Route::any('/profile/{id}/{name}', function($id, $name) {
        echo "Loading profile: " . $id . " , name: " . $name;
    });


    Route::any('*', 'Base@notfound');

