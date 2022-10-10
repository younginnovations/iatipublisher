@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden collection-container" data-prototype="{{ form_row($form->narrative->prototype()) }}">
  </div>
  <div class="hidden collection-container" form_type="title_narrative"
    data-prototype="{{ form_row($form->narrative->prototype()) }}">
  </div>
@endsection
