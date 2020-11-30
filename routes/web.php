<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response('No disponible', 404);
});

Auth::routes(['register' => false]);
