@extends('admin.layouts.app')
@section('content')
    <activities-detail
        :elements="{{ json_encode($elements) }}"
        :groups="{{ json_encode($elementGroups) }}"
        :activity="{{ json_encode($activity) }}"
        :progress="{{ $progress }}"
        :lang="{{json_encode('lang file')}}"
        :types="{{json_encode($types)}}"
        :status="{{json_encode($status)}}"
        :toast="{{ json_encode($toast) }}"
        :results="{{ json_encode($results) }}"
        :has_indicator="{{ $hasIndicatorPeriod['indicator'] }}"
        :has_period="{{ $hasIndicatorPeriod['period'] }}"
        :transactions="{{ json_encode($transactions) }}"
        :core_completed="{{ $coreCompleted }}"
        :iati_validator_response="{{ json_encode($iatiValidatorResponse) }}"
    >
    </activities-detail>
@endsection
