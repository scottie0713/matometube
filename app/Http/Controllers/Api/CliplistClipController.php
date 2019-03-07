<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CliplistClip;
use App\Http\Resources\CliplistResource;
use App\Http\Resources\ClipMovieCollection;

class CliplistClipController extends Controller
{
    public function create(Request $request, $cliplist_id)
    {
        $cliplist_clips = $request->input('cliplist_clips');
        $res = CliplistClip::where('cliplist_id', $cliplist_id)->delete();
        $order = 1;
        foreach($cliplist_clips as $clip) {
            $res = CliplistClip::insert([
                'cliplist_id' => $cliplist_id,
                'movie_id'    => $clip['movie_id'],
                'start_sec'   => $clip['start_sec'],
                'end_sec'     => $clip['end_sec'],
                'order'       => $order,
                'comment'     => $clip['comment'],
            ]);
            $order++;
        }
        return ['success' => $res];
    }
}
