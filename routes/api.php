<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PatternController;


Route::prefix('products')->group(function () {
    Route::get('', 'ProductController@showAll');
    Route::get('{id}', 'ProductController@show');
    Route::get('{id}/pattern', 'ProductController@showPattern');
    Route::get('{products_id}/comments', 'ProductController@showComments');
    Route::post('add', 'ProductController@create');
    Route::put('{id}', 'ProductController@update');
    Route::delete('{id}', 'ProductController@delete');
});


Route::prefix('comments')->group(function () {
    Route::get('', 'CommentController@showAll');
    Route::post('', 'CommentController@create');
});

Route::prefix('patterns')->group(function () {
    Route::get('', 'PatternController@showAll');
});
