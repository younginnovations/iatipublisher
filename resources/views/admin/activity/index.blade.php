@extends('admin.layouts.app')

@section('content')
    <activity-template
            :toast="{{ json_encode($toast) }}"
    ></activity-template>
@endsection
