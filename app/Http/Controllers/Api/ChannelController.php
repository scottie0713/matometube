<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Http\Resources\ChannelResource;

class ChannelController extends Controller
{
    public function index(Request $request)
    {
        $query = Channel::latest()->where('is_delete', 0);
        if($request->has('q'))
        {
            $query = $query->where('title', $request->input('q'));
        }
        $channels = $query->paginate(20);
        
        return ChannelResource::collection($channels);
    }
    
    public function show($platform, $platform_channel_id)
    {
        $channel = Channel::where('platform', $platform)->where('platform_channel_id', $platform_channel_id)->first();
        return new ChannelResource($channel);
    }
    
    public function search(Request $request)
    {
        $search_word = $request->input('search_word');
        $type = $request->input('type');
        $sort = $request->input('sort');
        $page = $request->input('page');
        
        //$searches = ClipMovie::searchByNicovideo($search_word, $type, $sort, $page);
        //var_dump($searches);
        //return new ClipMovieCollection($searches);
        return ClipMovie::searchByNicovideo($search_word, $type, $sort, $page);
    }
    
    public function create(Request $request)
    {
        $res = Channel::insert([
            'platform' => $request->input('platform'),
            'platform_channel_id' => $request->input('platform_channel_id'),
            'title' => $request->input('title'),
        ]);
        
        return ['success' => $res];
    }
    
    public function update(Request $request, $id)
    {
        $res = Clip::where('id', $id)->update([
            'title' => $request->input('title'),
            'author' => $request->input('author'),
        ]);
        return ['success' => $res];
    }
    
    public function deleteClip(Request $request, $id)
    {
        $id = $request->input('id');
        $res = ClipMovieTime::where('id', $id)->delete();
        return ['success' => $res];
    }
}
