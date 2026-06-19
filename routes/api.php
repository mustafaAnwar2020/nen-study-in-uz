<?php

use App\Http\Controllers\Api\AjaxController;
use App\Http\Controllers\ExamsPlatform\ExamsPlatformController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get/cities', [AjaxController::class, 'get_cities']);
Route::get('/get/villages', [AjaxController::class, 'get_villages']);
Route::get('/get/edu_admins', [AjaxController::class, 'get_edu_admins']);
Route::get('/get-news', [AjaxController::class, 'getNews']);

Route::prefix("exams")->name("exams.")->group(function () {
    Route::post('/login', [ExamsPlatformController::class, 'login']);
    Route::get('/provider/{id}', [ExamsPlatformController::class, 'getTraineeById']);
    Route::post('sso-provider', [ExamsPlatformController::class, 'loginTraineeSSO']);

    Route::get('programs-courses', [ExamsPlatformController::class, 'programCoursesData']);
});