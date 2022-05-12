@extends('admin.layouts.app')
{{--@php--}}
{{--    echo "<pre>";--}}
{{--    print_r($activity);--}}
{{--    echo "</pre>"--}}
{{--@endphp;--}}
@section('content')
    <activities-detail
        :elements="{{ json_encode($elements) }}"
        :element_group="{{ json_encode($elementGroups) }}"
        :activity="{{ json_encode($activity) }}"
        :progress="{{ $progress }}">
    </activities-detail>
@endsection
