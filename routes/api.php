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

// Channel
Route::get('channel/', 'Api\ChannelController@index');
Route::get('channel/{platform}/{platform_channel_id}', 'Api\ChannelController@show');
Route::post('channel/create', 'Api\ChannelController@create');

// Cliplist
Route::get('cliplist/{cliplist_id}', 'Api\CliplistController@show');
Route::get('cliplist/channel/{channel_id}', 'Api\CliplistController@getByChannelId');
Route::post('cliplist/create', 'Api\CliplistController@create');
Route::put('cliplist/{cliplist_id}', 'Api\CliplistController@update');
Route::post('cliplist/{cliplist_id}/delete', 'Api\CliplistController@delete');
// CliplistClip
Route::post('cliplist/{cliplist_id}/clip', 'Api\CliplistClipController@create');
