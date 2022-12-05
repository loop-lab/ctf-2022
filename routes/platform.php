<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\PlatformScreen;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');
