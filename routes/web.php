<?php

use Src\Route;

Route::add('GET', '/', [Controller\Site::class, 'hello']);
//    ;
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add('GET', '/lk', [Controller\Site::class, 'lk']) ->middleware('auth');
Route::add('GET', '/cart', [Controller\Site::class, 'cart']) ->middleware('auth');
