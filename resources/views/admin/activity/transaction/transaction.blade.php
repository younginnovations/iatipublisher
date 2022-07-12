@extends('admin.layouts.app')

@section('content')
    <transaction-list
            :activity="{{ json_encode($activity) }}"
            :transactions="{{ json_encode($transactions) }}"
    ></transaction-list>
@endsection
