@extends('admin.layouts.app')

@section('content')

    {!! form($form) !!}
    <div class="hidden collection-container"
         data-prototype="{{ form_row($form->related_activity->prototype()) }}">
    </div>
@endsection
