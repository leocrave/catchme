<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/catchme', 'CampaignController@index');

Route::get('/catchme/user/existence', 'CampaignController@userExistence');

Route::get('/catchme/clear_session', 'CampaignController@clearSession');

Route::post('/catchme', 'CampaignController@createParticipant');

Route::post('/catchme/user/register', 'CampaignController@registerUser');

Route::post('/catchme/user/isRegistered', 'CampaignController@checkUserRegistrationStatus');

Route::post('/catchme/user/isUploaded', 'CampaignController@checkUserUploadingPhotoStatus');*/

Route::get('/catchme', 'CampaignController@indexV2');

Route::get('/catchme/clearSession', 'CampaignController@clearSession');

Route::get('/catchme/random_instant_reward', 'CampaignController@randomInstantReward');

Route::post('/catchme/user/login', 'CampaignController@login');

Route::post('/catchme/user/register', 'CampaignController@register');

Route::get('/catchme/user/reg_status', 'CampaignController@checkUserRegStatus');