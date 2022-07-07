@extends('admin.layouts.app')

@section('content')
    <result-detail
        :activity="{{ json_encode($activity) }}"
        :result="{{ json_encode($result) }}"
    ></result-detail>
@endsection
