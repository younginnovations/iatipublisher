@extends('admin.layouts.app')

@section('content')
    <indicator-detail :activity="{{ json_encode($activity) }}" :result-title="{{ json_encode($resultTitle) }}"
        :indicator="{{ json_encode($indicator) }}" :types="{{ json_encode($types) }}"></indicator-detail>
@endsection
