<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get( '/topics', function ( Request $request ) {
    $topics = \App\Topic::select( ['name', 'id'] )->where( 'name', 'like', '%'.$request->query( 'q' ).'%' )->get();
    return $topics;
} );

Route::middleware('auth:api')->post('/uploads/image', 'UploadsController@fileUpload')->name('uploads.image');
