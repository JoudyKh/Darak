<?php

use App\Constants\Constants;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PSectionsController;
use App\Http\Controllers\SerSectionsController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

/** @Auth */
Route::post('/login', [AuthController::class, 'login']);
Route::post('send/verification-code', [AuthController::class, 'sendVerificationCode']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
Route::post('check/verification-code', [AuthController::class, 'checkVerificationCode']);


Route::middleware(['auth:sanctum', 'locale', 'ability:' . Constants::ROLES['admin']])
    ->group(function () {
        /** @Auth */
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/check/auth', [AuthController::class, 'authCheck']);
        Route::get('/profile', [AuthController::class, 'profile']);

        /* Offers*/
        Route::prefix('/offers')->group(function () {
            Route::get('/', [OfferController::class, 'index']);
            Route::get('/{offer}', [OfferController::class, 'show']);
            Route::post('/', [OfferController::class, 'create']);
            Route::put('/{offer}', [OfferController::class, 'update']);
            Route::delete('/{offer}', [OfferController::class, 'destroy']);
        });


        /* Infos */
        Route::prefix('/infos')->group(function () {
            Route::get('/', [InfoController::class, 'index']);
            Route::get('/{info}', [InfoController::class, 'show']);
            Route::post('/', [InfoController::class, 'create']);
            Route::put('/{key}/update', [InfoController::class, 'update']);
            Route::delete('/{key}', [InfoController::class, 'destroy']);
        });

        /* Messages */
        Route::prefix('/messages')->group(function () {
            Route::get('/', [MessageController::class, 'index']);
            Route::get('/{message}', [MessageController::class, 'show']);
            Route::delete('/{message}', [MessageController::class, 'destroy']);
        });

        /* Properties */ 
            Route::get('/psections/{section}/properties', [PropertyController::class, 'index']);
            Route::get('/properties/{property}', [PropertyController::class, 'show']);
            Route::post('/psections/{section}/properties', [PropertyController::class, 'create']);
            Route::put('/psections/{section}/properties/{property}', [PropertyController::class, 'update']);
            Route::get('/properties', [PropertyController::class, 'search']);
            Route::get('/regions', [PropertyController::class, 'regions']);
            Route::delete('/properties/{property}', [PropertyController::class, 'destroy']);
            Route::get('/properties_map',[PropertyController::class, 'map'] );

        /* Properties sections */
        Route::prefix('/properties-sections')->group(function () {
            Route::get('/', [PSectionsController::class, 'index']);
            Route::get('/{section}', [PSectionsController::class, 'show']);
            Route::post('/', [PSectionsController::class, 'create']);
            Route::put('/{section}', [PSectionsController::class, 'update']);
            Route::delete('/{section}', [PSectionsController::class, 'destroy']);
        });

        /* Services */
        Route::get('/ser_section/{section}/services', [ServiceController::class, 'index']);
        Route::get('/services/{service}', [ServiceController::class, 'show']);
        Route::post('/ser_sections/{section}/services', [ServiceController::class, 'create']);
        Route::put('/ser_sections/{section}/services/{service}', [ServiceController::class, 'update']);
        Route::delete('/services/{service}', [ServiceController::class, 'destroy']);

        /* Services sections */
        Route::prefix('/services-sections')->group(function () {
            Route::get('/', [SerSectionsController::class, 'index']);
            Route::get('/{section}', [SerSectionsController::class, 'show']);
            Route::post('/', [SerSectionsController::class, 'create']);
            Route::put('/{section}', [SerSectionsController::class, 'update']);
            Route::delete('/{section}', [SerSectionsController::class, 'destroy']);
        });
    });
