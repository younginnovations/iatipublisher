@extends('admin.layouts.app')

@section('content')
    <periods-detail :activity="{{ json_encode($activity) }}" :parent-data="{{ json_encode($parentData) }}"
        :period="{{ json_encode($period) }}" :types="{{ json_encode($types) }}">
    </periods-detail>
@endsection
