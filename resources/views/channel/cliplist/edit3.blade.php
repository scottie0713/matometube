@extends('layouts.app')

@section('content')
    <cliplist-edit3-component id="app" platform="{{ $platform }}" platform_channel_id="{{ $platform_channel_id }}" cliplist_id="{{ $cliplist_id }}"></cliplist-edit3-component>
@endsection