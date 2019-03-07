<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;

class Cliplist extends Model
{
    //
    public function cliplist_clips()
    {
        return $this->hasMany('App\Models\CliplistClip')->orderBy('order');
    }
}
