@extends('admin.layouts.app')
@section('content')
    <json-editor
        :schema="{{ json_encode($schema) }}"
        :elements=" {{ json_encode($elements) }}"
    >
    </json-editor>
@endsection
