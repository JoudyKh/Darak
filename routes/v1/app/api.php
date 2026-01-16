<?php


use App\Http\Controllers\InfoController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PSectionsController;
use App\Http\Controllers\SerSectionsController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware('locale')->group(function(){ 

    /* Offers */ 
    Route::prefix('/offers')->group(function () {
        Route::get('/', [OfferController::class, 'index']);
        Route::get('/{offer}', [OfferController::class, 'show']);
    });
    
     /* Infos */
     Route::prefix('/infos')->group(function(){
        Route::get('/', [InfoController::class, 'index']);
        Route::get('/{info}', [InfoController::class, 'show']);
    });
    
    /* Messages */
    Route::prefix('/messages')->group(function() {
        Route::post('', [MessageController::class, 'create']);
    });
    
    /* Properties */ 
    Route::get('/psections/{section}/properties', [PropertyController::class, 'index']);
    Route::get('/properties/{property}', [PropertyController::class, 'show']);
    Route::get('/properties', [PropertyController::class, 'search']);
    Route::get('/regions', [PropertyController::class, 'regions']);
    Route::get('/properties_map',[PropertyController::class, 'map'] );
    
    /* Properties sections */
    Route::prefix('/psections')->group(function(){
        Route::get('/{section}/properties', [PropertyController::class, 'index']);
        Route::get('/', [PSectionsController::class, 'index']);
        Route::get('/{section}', [PSectionsController::class, 'show']);
    });
    
    /* Services */
        Route::get('services-sections/{section}/services', [ServiceController::class, 'index']);
        Route::get('/services/{service}', [ServiceController::class, 'show']);
    
    /* Services sections */
    Route::prefix('/services-sections')->group(function(){
        Route::get('/', [SerSectionsController::class, 'index']);
        Route::get('/{section}', [SerSectionsController::class, 'show']);
    });

    
});