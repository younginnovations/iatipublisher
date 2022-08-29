@extends('admin.layouts.app')

@section('content')
    <organisation-data :elements="{{ json_encode($elements) }}" :groups="{{ json_encode($elementGroups) }}"
        :organization="{{ json_encode($organization) }}" :progress="{{ $progress }}" :toast="{{ json_encode($toast) }}"
        :types="{{ json_encode($types) }}" v-bind:mandatory-completed="{{ $mandatoryCompleted?1:0 }}" :status="{{ json_encode($status) }}"/>
@endsection
