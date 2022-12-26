@extends('admin.layouts.app')

@section('content')
    <user-listing :users='{{ json_encode($users) }}'></user-listing>
@endsection
