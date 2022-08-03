@extends('admin.layouts.app')

@section('content')
    <result-detail :activity="{{ json_encode($activity) }}" :result="{{ json_encode($result) }}"
        :types="{{ json_encode($types) }}" :toast="{{ json_encode($toast) }}"></result-detail>
@endsection
