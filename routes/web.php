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
    //return view('welcome');
    return redirect('channel/');
});

// -------- Youtubeチャンネル系
Route::get('channel/', function(){
    return view('channel.index');
})->name('channel.index');
// チャンネルトップ
Route::get('youtube/{platform_channel_id}/', function($platform_channel_id){
    return view('channel.show', ['platform'=>'youtube', 'platform_channel_id'=>$platform_channel_id]);
});
// チャンネルクリップリスト再生
Route::get('youtube/{platform_channel_id}/cliplist/{cliplist_id}/play', function($platform_channel_id, $cliplist_id){
    return view('channel.cliplist.play', ['platform'=>'youtube', 'platform_channel_id'=>$platform_channel_id, 'cliplist_id'=>$cliplist_id]);
});
// チャンネルクリップリスト編集
Route::get('youtube/{platform_channel_id}/cliplist/{cliplist_id}/edit1', function($platform_channel_id, $cliplist_id){
    return view('channel.cliplist.edit1', ['platform'=>'youtube', 'platform_channel_id'=>$platform_channel_id, 'cliplist_id'=>$cliplist_id]);
});
Route::get('youtube/{platform_channel_id}/cliplist/{cliplist_id}/edit2', function($platform_channel_id, $cliplist_id){
    return view('channel.cliplist.edit2', ['platform'=>'youtube', 'platform_channel_id'=>$platform_channel_id, 'cliplist_id'=>$cliplist_id]);
});
Route::get('youtube/{platform_channel_id}/cliplist/{cliplist_id}/edit3', function($platform_channel_id, $cliplist_id){
    return view('channel.cliplist.edit3', ['platform'=>'youtube', 'platform_channel_id'=>$platform_channel_id, 'cliplist_id'=>$cliplist_id]);
});
// チャンネルクリップリスト一覧（削除済み）
Route::get('youtube/{platform_channel_id}/cliplist/dust', function($platform_channel_id){
    return view('channel.cliplist.dust', ['platform'=>'youtube', 'platform_channel_id'=>$platform_channel_id]);
});
// チャンネルクリップリスト 変更履歴
Route::get('youtube/{platform_channel_id}/cliplist/{cliplist_id}/history', function($platform_channel_id, $cliplist_id){
    return view('cliplist.show', ['platform'=>'youtube', 'platform_channel_id'=>$platform_channel_id, 'cliplist_id'=>$cliplist_id]);
});
    
Auth::routes();
