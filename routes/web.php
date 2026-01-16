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
Route::get('/', [IndexController::class, 'index'])->name('index');

# Services Page
Route::get('services', [ServiceController::class, 'index'])->name('services');

# About Us Page
Route::get('about-us', [AboutUsController::class, 'index'])->name('about-us');

# Contact Us Page
Route::get('contact-us', [ContactUsController::class, 'index'])->name('contact-us');

Route::post('contact-us', [ContactUsController::class, 'store'])->name('contact-us.save');

# Cookies Policy Page
Route::get('cookies-policy', [CookiesController::class, 'index'])->name('cookies-policy');

# Privacy Policy Page
Route::get('privacy-policy', [PrivacyController::class, 'index'])->name('privacy-policy');

# Frequently Asked Questions Page
Route::get('frequently-asked-questions', [FaqController::class, 'index'])->name('frequently-asked-questions');

# Terms and Conditions Page
Route::get('terms-and-conditions', [TermsAndConditionsController::class, 'index'])->name('terms-and-conditions');
