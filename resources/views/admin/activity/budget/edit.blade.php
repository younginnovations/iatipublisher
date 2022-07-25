@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection" data-prototype="{{ form_row($form->budget->prototype()) }}">
  </div>
@endsection
