<?php

use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\SocialNetworkController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {

    Route::resource('/users', UserController::class);

    Route::post('/users/{userId}/languages/attach', [LanguageController::class, 'attachLanguage']);
    Route::delete('/users/{userId}/languages/detach', [LanguageController::class, 'detachLanguage']);
    Route::post('/users/{userId}/social_networks/attach', [SocialNetworkController::class, 'attachSocialNetwork']);
    Route::delete('/users/{userId}/social_networks/detach', [SocialNetworkController::class, 'detachSocialNetwork']);
    Route::post('/users/{userId}/skills/attach', [SkillController::class, 'attachSkill']);
    Route::delete('/users/{userId}/skills/detach', [SkillController::class, 'detachSkill']);

    Route::resource('/projects', ProjectController::class);

    Route::resource('/experiences', ExperienceController::class);

    Route::resource('/educations', EducationController::class);

    Route::resource('/languages', LanguageController::class);

    Route::resource('/skills', SkillController::class);

    Route::resource('/socialNetworks', SocialNetworkController::class);

});
