<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProtectedFileAccessController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;


Route::get('/maintenance-mode', [SiteController::class, 'MaintenanceMode'])->name('m_mode');

Route::group(['middleware' => 'MaintenanceModeMiddleware',], function () {
    Route::group(['middleware' => 'web', 'as' => 'site.'], function () {
        Route::get('/', [SiteController::class, 'index'])->name('index');
        Route::get('/offers', [SiteController::class, 'offers'])->name('offers');
        Route::get('/products', [SiteController::class, 'products'])->name('products');
        Route::get('/events', [SiteController::class, 'events'])->name('events');
        Route::get('/events/{slug}', [SiteController::class, 'eventShow'])->name('events.show');
        Route::get('/blogs', [SiteController::class, 'blogs'])->name('blogs');
        Route::get('/blogs/{slug}', [SiteController::class, 'blogShow'])->name('blogs.show');
        Route::get('/faqs', [SiteController::class, 'faqs'])->name('faqs');
        Route::get('/TPS', [SiteController::class, 'tpi'])->name('tpi');
        Route::post('/contact-us', [SiteController::class, 'postContact'])->name('contact');
        Route::post('/request-event', [SiteController::class, 'postEventRequest'])->name('event-request');
        Route::post('/contact-trainer', [SiteController::class, 'contactTrainer'])->name('contact.trainer');
        Route::post('/subscribe', [SiteController::class, 'subscribe'])->name('subscribe');

        Route::group(['prefix' => 'p', 'as' => 'p.'], function () {
            Route::get('/{slug}', [PageController::class, 'show'])->name('show');
        });

    });

    // Protected Files Routes (outside site group to avoid 'site.' prefix)
    Route::group(['prefix' => 'protected-files', 'as' => 'protected-files.'], function () {
        Route::get('/', [ProtectedFileAccessController::class, 'index'])->name('index');
        Route::get('/{protectedFile}/password', [ProtectedFileAccessController::class, 'showPasswordForm'])->name('password-form');
        Route::post('/{protectedFile}/verify', [ProtectedFileAccessController::class, 'verifyPassword'])->name('verify-password');
        
        Route::group(['middleware' => 'protected-file-access'], function () {
            Route::get('/{protectedFile}/edit', [ProtectedFileAccessController::class, 'edit'])->name('edit');
            Route::put('/{protectedFile}', [ProtectedFileAccessController::class, 'update'])->name('update');
            Route::post('/{protectedFile}/upload', [ProtectedFileAccessController::class, 'upload'])->name('upload');
            Route::get('/{protectedFile}/download', [ProtectedFileAccessController::class, 'download'])->name('download');
        });
        
        Route::get('/logout', [ProtectedFileAccessController::class, 'logout'])->name('logout');
    });

    require_once('ajax.php');
});


Route::get('logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout_route');
