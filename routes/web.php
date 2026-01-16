<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\FaqController;
use App\Http\Controllers\Guest\IndexController;
use App\Http\Controllers\Guest\PrivacyController;
use App\Http\Controllers\Guest\ServiceController;
use App\Http\Controllers\Guest\AboutUsController;
use App\Http\Controllers\Guest\ContactUsController;
use App\Http\Controllers\Guest\CookiesController;
use App\Http\Controllers\Guest\TermsAndConditionsController;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# Homepage
Route::redirect('/', '/superadmin')->name('index');
