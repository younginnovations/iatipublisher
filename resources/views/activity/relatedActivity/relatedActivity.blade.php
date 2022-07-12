@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden collection-container" form_type="related_activity_related_activity"
    data-prototype="{{ form_row($form->related_activity->prototype()) }}">
  </div>
@endsection
