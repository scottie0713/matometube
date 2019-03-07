@extends('layouts.app')

@section('content')
    <cliplist-edit2-component id="app" platform="{{ $platform }}" platform_channel_id="{{ $platform_channel_id }}" cliplist_id="{{ $cliplist_id }}"></cliplist-edit2-component>
@endsection