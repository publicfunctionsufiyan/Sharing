<?php

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




Route::post('register', 'UserController@register');      //register
Route::post('profile-picture/{id}', 'UserController@profilePicture')
->middleware('auth:api');      //profile picture upload
Route::post('login', 'UserController@login');            //login

// Route::post('password/email','ForgotPasswordController@sendResetLinkEmail'); //forgot password email
// Route::post('password/reset','Auth\ResetPasswordController@reset');          //reset password

Route::post('update-user/{id}','UserController@update')->middleware('auth:api');             //update user
Route::get('all-users','UserController@showAllUsers')->middleware('auth:api');          //show all users
Route::get('user-by-id/{id}','UserController@showUserById')->middleware('auth:api');  //show user by id

Route::post('create-project/{id}','ProjectController@store')->middleware('auth:api');        //create new project
Route::get('show-all-projects','ProjectController@showAllProjects')->middleware('auth:api'); //show all projects
Route::delete('delete-project/{id}','ProjectController@delete')->middleware('auth:api');     //delete project
Route::post('update-project/{id}','ProjectController@update')->middleware('auth:api');       //update project
Route::get('show-project/{id}','ProjectController@show')->middleware('auth:api');            //show project by id
Route::get('show-projects-by-user/{id}','ProjectController@showProjectsByUser')->middleware('auth:api');            //show project by id

Route::post('upload-file','FilesController@store')->middleware('auth:api');                  //upload file

Route::get('show-files-by-project/{id}','FilesController@showFilesByProject')
->middleware('auth:api');                //show files by project

Route::get('show-files-by-user/{id}','FilesController@showFilesByUser')
->middleware('auth:api');               //show files by user

Route::get('share-files/{hash}','SignedURLController@showFiles')
->name('my.file')->middleware('signed');                                                    //show shared files

Route::post('file-url/{file}','SignedURLController@store')->middleware('auth:api');         //make temporary URL

Route::get('show-links-by-file/{id}','SignedURLController@showLinksByFile')
->middleware('auth:api');                //show links by File

Route::get('show-all-links','SignedURLController@showAllLinks')
->middleware('auth:api');               //show all links

Route::delete('delete-URL/{id}','SignedURLController@delete')->middleware('auth:api');      //delete temporary URL

Route::delete('delete-file/{id}','FilesController@delete')->middleware('auth:api');      //delete file

Route::delete('delete-user/{id}','UserController@delete')->middleware('auth:api');      //delete file

Route::post('isEnable-URL/{signed_url}','SignedURLController@isEnable')->middleware('auth:api');      //delete temporary URL


Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});

Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');


// Route::post('create', 'PasswordResetController@create');
