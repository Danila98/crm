<?php

use App\Http\Controllers\Api\Randomizer\ColorController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [Controller::class, 'index']);


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
Route::get('/{string}', [Controller::class, 'index']);
