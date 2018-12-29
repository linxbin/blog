<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get( '/', 'ArticlesController@index' );

\Illuminate\Support\Facades\Auth::routes();

Route::get( '/home', 'HomeController@index' )->name( 'home' );

//Route::resource( 'articles', 'ArticlesController', [
//    'name' => [
//        'create'  => 'articles.create',
//        'store'   => 'articles.store',
//        'show'    => 'articles.show',
//        'destroy' => 'articles.destroy',
//        'drafts'  => 'articles.drafts',
//    ],
//] );

Route::get('/articles/create','ArticlesController@create')->name('articles.create');
Route::get('/articles/{id}','ArticlesController@show')->name('articles.show');
Route::get('/articles','ArticlesController@index')->name('articles.index');
Route::get('/articles/{id}/edit','ArticlesController@edit')->name('articles.edit');
Route::patch('/articles/{id}','ArticlesController@update')->name('articles.update');
Route::post('/articles','ArticlesController@store')->name('articles.store');
Route::get('/articles/{id}/destroy','ArticlesController@destroy')->name('articles.destroy');
Route::get('/articles/{id}/hidden','ArticlesController@hidden')->name('articles.hidden');
Route::get('/articles/drafts','ArticlesController@drafts')->name('articles.drafts');
Route::get('/topics/{id}','ArticlesController@topic')->name('articles.topic');