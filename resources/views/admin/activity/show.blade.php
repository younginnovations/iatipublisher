@extends('admin.layouts.app')
@section('content')
    <activities-detail :elements="{{ json_encode($elements) }}" :groups="{{ json_encode($elementGroups) }}"
        :activity="{{ json_encode($activity) }}" :progress="{{ $progress }}" :toast="{{ json_encode($toastData) }}" :lang="{{ json_encode('lang file') }}"
        :types="{{ json_encode($types) }}" :status="{{ json_encode($status) }}" >
    </activities-detail>
@endsection
