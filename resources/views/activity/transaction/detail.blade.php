@extends('admin.layouts.app')

@section('content')
{{json_encode($transaction)}}
    <transaction-detail
        :transaction="{{ json_encode($transaction) }}"
    ></transaction-detail>
@endsection
