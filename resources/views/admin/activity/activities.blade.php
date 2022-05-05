@extends('admin.layouts.app')

@section('content')
    <activity-template :activities="{{ json_encode($activities) }}" :page_count="{{ $page_count }}"></activity-template>
@endsection
