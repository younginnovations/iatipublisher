@extends('admin.layouts.app')

@section('content')
    <result-list :activity="{{ json_encode($activity) }}" :results="{{ json_encode($results) }}"
        :types="{{ json_encode($types) }}" :toast="{{ json_encode($toast) }}"></result-list>
@endsection
