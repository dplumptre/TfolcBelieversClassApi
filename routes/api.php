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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('test-email','ApiAuthController@testEmail');
Route::post('reset','ApiAuthController@resetToken');
Route::get('activate-account/{token}','ApiAuthController@activateAccount');
Route::post('register', 'ApiAuthController@register');
Route::post('login', 'ApiAuthController@authenticate');
Route::post('change-password', 'ApiAuthController@changePassword');
Route::post('forget-password', 'ApiAuthController@forgetPassword');

/** Auth */
// Route::get('online-class', 'ApiController@ShowOnlineclass');
// Route::get('online-lecture/{id}', 'ApiController@ShowOnlinelec');  
// Route::get('question/{id}', 'ApiController@showQuestion');
// Route::post('question/{id}', 'ApiController@postQuestion');
// Route::get('get-answers', 'ApiController@getAnswers');

Route::post('score', 'ApiController@scoreUser');
//Route::get('get-single-answers/{id}', 'ApiController@getSingleAnswers');


Route::group(['middleware' => ['jwt.verify']], function() {
// token ones
//Route::get('one-answer/{id}', 'ApiController@oneAnswer');

Route::get('get-single-answers/{id}', 'ApiController@getSingleAnswers');
Route::post('get-user', 'ApiAuthController@getAuthenticatedUser');
Route::get('online-class', 'ApiController@ShowOnlineclass');
Route::get('online-lecture/{id}', 'ApiController@ShowOnlinelec');  
Route::get('question/{id}', 'ApiController@showQuestion');
Route::post('question/{id}', 'ApiController@postQuestion');
Route::get('get-answers', 'ApiController@getAnswers');
Route::get('notifications/{user}', 'ApiController@notification');
Route::get('get-percentage/{user}', 'ApiController@getPercentage');


});
   
