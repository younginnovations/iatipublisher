@extends('admin.layouts.app')

@section('content')
    <transaction-detail :activity="{{ json_encode($activity) }}" :transaction="{{ json_encode($transaction) }}"
        :types="{{ json_encode($types) }}"></transaction-detail>
@endsection
