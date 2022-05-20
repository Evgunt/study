<?php

use Src\Route;

Route::add('GET', '/', [Controller\Api::class, 'index']);
Route::add('GET', '/catalog', [Controller\Api::class, 'catalog']);
Route::add('POST', '/echo', [Controller\Api::class, 'echo']);
Route::add('POST', '/login', [Controller\Api::class, 'login']);
Route::add(['GET', 'POST'], '/lk', [Controller\Api::class, 'Personal']);

