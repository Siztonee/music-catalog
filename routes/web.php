<?php

use Illuminate\Support\Facades\Route;
use L5Swagger\L5Swagger;

Route::get('/', function () {
    return view('welcome');
});
