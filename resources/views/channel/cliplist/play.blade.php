@extends('layouts.app')

@section('content')
    <cliplist-play-component id="app" platform="{{ $platform }}" platform_channel_id="{{ $platform_channel_id }}" cliplist_id="{{ $cliplist_id }}"></cliplist-play-component>
@endsection