<?php

   Route::view('/', 'welcome', ["title" => "Welcome page"]);

//    Route::any('/profile', 'User@profile');

//    Route::any('/test', 'User@index');




    Route::redirect('/profile', '/');

    Route::any('*', 'Base@notfound');