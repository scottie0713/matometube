<?php

use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // channels
        DB::table('channels')->insert([
            'platform'              => 'youtube',
            'platform_channel_id'   => 'UCumOEkOWBFy5ShLv3fR2rJg',
            'title'                 => 'トシゾー',
            'is_delete'             => 0,
        ]);
        DB::table('channels')->insert([
            'platform'              => 'youtube',
            'platform_channel_id'   => 'UCu0lW58jcjGRfkGTWt6GE1w',
            'title'                 => 'ナポリの男たち',
            'is_delete'             => 0,
        ]);
        DB::table('channels')->insert([
            'platform'              => 'youtube',
            'platform_channel_id'   => 'UC63qlPjUnEwAf4OkY6-D8Nw',
            'title'                 => '実況いい大人',
            'is_delete'             => 0,
        ]);
        
        // cliplist
        DB::table('cliplists')->insert([
            'channel_id'    => 2,
            'title'         => '1周年記念 24時間配信',
            'password'      => NULL,
            'is_delete'     => 0,
        ]);
        DB::table('cliplist_clips')->insert([
            'cliplist_id'   => 1,
            'movie_id'      => 'I55y5kxKAz4',
            'start_sec'     => 30,
            'end_sec'       => 35,
            'order'         => 1,
        ]);
        DB::table('cliplist_clips')->insert([
            'cliplist_id'   => 1,
            'movie_id'      => 'I55y5kxKAz4',
            'start_sec'     => 60,
            'end_sec'       => 65,
            'order'         => 2,
        ]);
        DB::table('cliplist_clips')->insert([
            'cliplist_id'   => 1,
            'movie_id'      => 'ADtPQwnid0s',
            'start_sec'     => 80,
            'end_sec'       => 85,
            'order'         => 3,
        ]);
    }
}
