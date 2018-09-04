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

Route::get('/', function () {
//    return view('welcome');
    return redirect('/blog');
});
//首页、文章页
Route::get('blog','BlogController@index');
Route::get('blog/{slug}','BlogController@showPost');
//ContactMe
Route::get('contact', 'ContactController@showForm');
Route::post('contact', 'ContactController@sendContactInfo');
//RSS待修复
//Route::get('rss', 'BlogController@rss');
//Admin
Route::get('admin',function (){
    return redirect('/admin/post');
});
Route::group(['namespace'=>'admin','middleware'=>'auth'],function (){
    Route::resource('admin/post','PostController');
    Route::resource('admin/tag','TagController');
    Route::get('admin/upload','UploadController@index');
    Route::post('admin/upload/file', 'UploadController@uploadFile');
    Route::delete('admin/upload/file', 'UploadController@deleteFile');
    Route::post('admin/upload/folder', 'UploadController@createFolder');
    Route::delete('admin/upload/folder', 'UploadController@deleteFolder');
});
//login in/out
Route::get('auth/login','Auth\AuthController@getLogin')->name('login');
Route::post('auth/login','Auth\AuthController@login');
Route::get('auth/logout','Auth\AuthController@getLogout');
Route::get('view',function (){
    return view('blog.layouts.index');
});
//站点地图
Route::get('sitemap.xml', 'BlogController@siteMap');
//
Route::get('time', 'ContactController@jobTest');