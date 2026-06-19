<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AjaxController;

Route::group(['middleware' => 'web', 'as' => 'ajax.', 'prefix' => 'ajax'], function () {
    Route::post('/cities', [AjaxController::class, 'getCities'])->name('getCities');
    Route::get('/get-cities/{id}', [AjaxController::class, 'getCitiesByGovID']);
    Route::get('/get-models', [AjaxController::class, 'getModels'])->name('get-models');
    Route::post('/file-upload', [AjaxController::class, 'fileUpload'])->name('file-upload');
    Route::post('/get-offer-details', [AjaxController::class, 'getOfferDetails'])->name('get-offer-details');
    Route::post('/get-event-details', [AjaxController::class, 'getEventDetails'])->name('get-event-details');
    Route::get('/get-network-data', [AjaxController::class, 'getNetworkDataFromXLSFile'])->name('get-network-data');
});


