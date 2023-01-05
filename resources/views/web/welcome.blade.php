@extends('web.layouts.app')

@section('content')
    <welcome-signin page="{{ json_encode($page) }}" message="{{ json_encode($message) }}"
        :intent="{{ json_encode($intent) }}"></welcome-signin>
@endsection
