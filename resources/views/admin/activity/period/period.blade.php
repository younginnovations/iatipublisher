@extends('admin.layouts.app')

@section('content')
    <periods-list :activity="{{ json_encode($activity) }}" :parent-data="{{ json_encode($parentData) }}"
        :period="{{ json_encode($period) }}"></periods-list>
@endsection
