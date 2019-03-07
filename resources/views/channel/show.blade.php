@extends('layouts.app')

@section('content')
    <channel-show-component id="app" platform="{{ $platform }}" platform_channel_id="{{ $platform_channel_id }}"></channel-show-component>
@endsection