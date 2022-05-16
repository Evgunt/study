<?php

use Src\Route;

Route::add(['GET', 'POST'], '/', [Controller\Site::class, 'hello']);

Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add(['GET', 'POST'], '/lk', [Controller\Site::class, 'lk']) ->middleware('auth');
Route::add(['GET', 'POST'], '/cart', [Controller\Site::class, 'cart']) ->middleware('auth');

Route::add('GET', '/catalog', [Controller\Site::class, 'catalog']);
Route::add('GET', '/item', [Controller\Site::class, 'item']);