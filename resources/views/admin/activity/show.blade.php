@extends('admin.layouts.app')
@section('content')
    <activities-detail
        :elements="{{ json_encode($elements) }}"
        :element_group="{{ json_encode($elementGroups) }}"
        :activity="{{ json_encode($activity) }}"
        :progress="{{ $progress }}">
    </activities-detail>
@endsection
