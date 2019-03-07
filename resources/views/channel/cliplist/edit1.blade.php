@extends('layouts.app')

@section('content')
    <cliplist-edit1-component id="app" platform="{{ $platform }}" platform_channel_id="{{ $platform_channel_id }}" cliplist_id="{{ $cliplist_id }}"></cliplist-edit1-component>
@endsection