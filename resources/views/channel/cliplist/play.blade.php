@extends('layouts.app')

@section('content')
    <cliplist-play-component id="app" cliplist_id="{{ $cliplist_id }}"></cliplist-play-component>
@endsection