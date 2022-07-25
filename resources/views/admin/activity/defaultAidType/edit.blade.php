@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden collection-container" form_type="default_aid_type_default_aid_type"
    data-prototype="{{ form_row($form->default_aid_type->prototype()) }}">
  </div>
@endsection
