@extends('admin.layouts.app')
@section('content')
    <activities-detail
        :elements="{{ json_encode($elements) }}"
        :elementGroup="{{ json_encode($elementGroups) }}"
        :activity="{{ json_encode($activity) }}"
        :progress="{{ $progress }}"
        :lang="{{json_encode('lang file')}}"
        :types="{{json_encode($types)}}"
        :status="{{json_encode($status)}}"
        :toast="{{ json_encode($toast) }}">
    </activities-detail>
@endsection
