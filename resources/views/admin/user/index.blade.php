@extends('admin.layouts.app')

@section('content')
    <user-listing :organizations='{{ json_encode($organizations) }}' :status='{{ json_encode($status) }}'
        :roles='{{ json_encode($roles) }}' :user-role='{{ json_encode($userRole) }}'></user-listing>
@endsection
