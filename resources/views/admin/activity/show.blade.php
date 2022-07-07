@extends('admin.layouts.app')
@section('content')
    <activities-detail
        :elements="{{ json_encode($elements) }}"
        :element_group="{{ json_encode($elementGroups) }}"
        :activity="{{ json_encode($activity) }}"
        :progress="{{ $progress }}"
        :lang="{{json_encode('lang file')}}"
        :types="{{json_encode($types)}}"
        :status="{{json_encode($status)}}"
        :toast="{{ json_encode($toast) }}"
        :results="{{ json_encode($results) }}"
        :has_indicator="{{ $hasIndicator }}"
        :has_period="{{ $hasPeriod }}">
    </activities-detail>
@endsection
