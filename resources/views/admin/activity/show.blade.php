@extends('admin.layouts.app')
@section('content')
    <activities-detail
        :elements="{{ json_encode($elements) }}"
        :element_group="{{ json_encode($elementGroups) }}"
        :activity="{{ json_encode($activity) }}"
        :progress="{{ $progress }}"
        :lang="{{json_encode('lang file')}}"
        :types="{{json_encode($types)}}"
        :toast="{{ json_encode($toast) }}">
    </activities-detail>
@endsection
