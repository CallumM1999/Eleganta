<?php

    Route::get('/', 'User');

    Route::any('/profile/{id}', 'User@profile');

    Route::any('*', 'Base@notfound');

