@extends('admin.layouts.app')

@section('content')
    <activity-template
            :toast="{{ json_encode($toast) }}"
            :default-language="{{json_encode($defaultLanguage)}}"
    ></activity-template>
@endsection
