@extends('admin.layouts.app')

@section('content')
    <result-detail :activity="{{ json_encode($activity) }}" :result="{{ json_encode($result) }}"
        :types="{{ json_encode($types) }}"></result-detail>
@endsection
