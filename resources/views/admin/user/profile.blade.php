@extends('admin.layouts.app')

@section('content')
    <user-profile :user='{{ json_encode($user) }}'></user-profile>
@endsection
