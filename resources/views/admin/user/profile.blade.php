@extends('admin.layouts.app')

@section('content')
    <user-profile :user='{{ json_encode($user) }}' :language-preference='{{ json_encode($languagePreference)}}'></user-profile>
@endsection