<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ChannelResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'title'                 => $this->title,
            'platform'              => $this->platform,
            'platform_channel_id'   => $this->platform_channel_id,
        ];
    }
}
