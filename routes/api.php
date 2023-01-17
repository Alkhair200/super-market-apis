<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', [App\Http\Controllers\Auth\AuthController::class,'login']);
Route::group([

    'middleware' => 'jwt.verify',
    'prefix' => 'auth'

], function ($router) {
    
    // ملاحظه
    // Route::post('register', [App\Http\Controllers\Auth\AuthController::class,'register']);


    Route::post('logout', [App\Http\Controllers\Auth\AuthController::class,'logout']);
    Route::post('refresh', [App\Http\Controllers\Auth\AuthController::class,'refresh']);
    Route::post('me', [App\Http\Controllers\Auth\AuthController::class,'me']);

});

Route::group(['middleware' => 'jwt.verify'], function(){

    Route::group(['prefix' => 'users' , 'as' => 'users'],function()
    {
        Route::controller(App\Http\Controllers\Auth\UserController::class)->group(function(){
            Route::post('index', 'index');
            Route::post('store', 'store');
            Route::patch('update/{id}', 'update');
            Route::post('destroy/{id}', 'destroy');
        });
    });

    // العملاء
    Route::group(['prefix' => 'customer' , 'as' => 'customer'],function()
    {
        Route::controller(App\Http\Controllers\CustomersController::class)->group(function(){
            Route::post('index', 'index');
            Route::post('store', 'store');
            Route::patch('update/{id}', 'update');
            Route::post('destroy/{id}', 'destroy');
        });
    });

    // الموردين
    Route::group(['prefix' => 'importer' , 'as' => 'importer'],function()
    {
        Route::controller(App\Http\Controllers\ImportersController::class)->group(function(){
            Route::post('index', 'index');
            Route::post('store', 'store');
            Route::patch('update/{id}', 'update');
            Route::post('destroy/{id}', 'destroy');
    
        });
    });    
    
    // اماكن الاصناف علي الرفوف
    Route::group(['prefix' => 'place' , 'as' => 'place'],function()
    {
        Route::controller(App\Http\Controllers\PlacesController::class)->group(function(){
            Route::post('index', 'index');
            Route::post('store', 'store');
            Route::patch('update/{id}', 'update');
            Route::post('destroy/{id}', 'destroy');
        });
    });  

    // الاقسام
    Route::group(['prefix' => 'product' , 'as' => 'product'],function()
    {
        Route::controller(App\Http\Controllers\ProductsController::class)->group(function(){
            Route::post('index', 'index');
            Route::post('store', 'store');
            Route::patch('update/{id}', 'update');
            Route::post('destroy/{id}', 'destroy');
        });
    }); 
    
    // الشركان المصنعه
    Route::group(['prefix' => 'company' , 'as' => 'company'],function()
    {
        Route::controller(App\Http\Controllers\CompaniesController::class)->group(function(){
            Route::post('index', 'index');
            Route::post('store', 'store');
            Route::patch('update/{id}', 'update');
            Route::post('destroy/{id}', 'destroy');
        });
    });   
    
    // المنتجات
    Route::group(['prefix' => 'item' , 'as' => 'item'],function()
    {
        Route::controller(App\Http\Controllers\ItemsController::class)->group(function(){
            Route::post('index', 'index');
            Route::post('store', 'store');
            Route::patch('update/{id}', 'update');
            Route::post('destroy/{id}', 'destroy');
        });
    });       

    // حركة الاصناف
    Route::group(['prefix' => 'operation' , 'as' => 'poeration'],function()
    {
        Route::controller(App\Http\Controllers\OperationsController::class)->group(function(){
            Route::post('index', 'index');
            Route::post('store', 'store');
            Route::patch('update/{id}', 'update');
            Route::post('destroy/{id}', 'destroy');
        });
    });      
   

    // الحضور و الانصراف
    Route::group(['prefix' => 'action' , 'as' => 'action'],function()
    {
        Route::controller(App\Http\Controllers\HodoorEnserafController::class)->group(function(){
            Route::post('hodoor-user', 'hodoorUser');
            Route::post('store-hodoor', 'storeHodoor');
            Route::post('get-hodoor', 'getHodoor');

            Route::post('get-enseraf', 'getُEnseraf');
            Route::patch('enseraf/{id}', 'enseraf');
        });
    });     

    // الحضور و الانصراف
    Route::group(['prefix' => 'report' , 'as' => 'report'],function()
    {
        
        Route::controller(App\Http\Controllers\HodoorEnserafController::class)->group(function(){
            Route::post('report-user', 'reportUser');
        });
    });  
    
    // 
});