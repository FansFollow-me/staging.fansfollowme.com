<?php

use Illuminate\Support\Facades\Route;

// Landing page - no DB required
Route::get('/', function () {
    return response()->view('welcome');
});
