<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\RedirectController;

Route::get('/{code}', [RedirectController::class, 'handle'])->where('code', '[a-zA-Z0-9]{6}');