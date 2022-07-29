@extends('admin.layouts.app')

@section('content')
    <indicator-list :activity="{{ json_encode($activity) }}" :parent-data="{{ json_encode($parentData) }}"
        :indicators="{{ json_encode($indicators) }}" :types="{{ json_encode($types) }}"></indicator-list>
@endsection
