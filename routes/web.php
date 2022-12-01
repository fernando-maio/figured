<?php

use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

/** Routes organized by Controllers (InventoryController). I decided to use names to keep more organized, 
 *      and call the route by name on blade and controller files.
 * The first one is a get request calling a index function. 
 * The second one is a post request calling apply function.
 **/

Route::controller(InventoryController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'apply')->name('apply');
});