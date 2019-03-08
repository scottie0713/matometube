<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cliplist;
use App\Models\CliplistClip;
use App\Http\Resources\CliplistResource;
use App\Http\Resources\ClipMovieCollection;

class CliplistController extends Controller
{
    public function index(Request $request)
    {
        $query = Clip::latest()->where('is_display', 1);
        if($request->has('q'))
        {
            $query = $query->where('title', $request->input('q'));
        }
        $clips = $query->paginate(20);
        
        return ClipResource::collection($clips);
    }
    
    public function show($cliplist_id)
    {
        $cliplists = Cliplist::where('id', $cliplist_id)->with('cliplist_clips')->get();
        return new CliplistResource($cliplists);
    }
    
    public function getByChannelId($channel_id)
    {
        $query = Cliplist::latest()->where('channel_id', $channel_id)->where('is_delete', false);
        $cliplists = $query->paginate(10);
        
        return CliplistResource::collection($cliplists);
    }

    public function create(Request $request)
    {
        $res = Cliplist::insert([
            'channel_id' => $request->input('channel_id'),
            'title'   => $request->input('title'),
//            'password' => md5('password'),
        ]);
        
        return ['success' => $res];
    }
    
    public function updateCliplistClip($cliplist_id, $clips)
    {
        $res = CliplistClip::where('cliplist_id', $cliplist_id)->delete();
        foreach($clips as $clip) {
            $res = Clip::insert([
                'cliplist_id' => $cliplist_id,
                'movie_id'    => $clip->movie_id,
                'start_sec'   => $clip->start_sec,
                'end_sec'     => $clip->end_sec,
                'order'       => $clip->order,
            ]);
        }
        return ['success' => $res];
    }
    
    public function delete(Request $request, $cliplist_id)
    {
        $res = Cliplist::where('id', $cliplist_id)->delete();
        return ['success' => $res];
    }
    
    public function update(Request $request, $cliplist_id)
    {
        $res = Cliplist::where('id', $cliplist_id)->update([
            'title' => $request->input('title')
        ]);
        return ['success' => $res];
    }
}
