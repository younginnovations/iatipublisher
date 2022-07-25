@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection" data_name="description"
    data-prototype="{{ form_row($form->recipient_country->prototype()) }}">
  </div>
  <div class="hidden collection-container" form_type="recipient_country_narrative"
    data-prototype="{{ str_replace('recipient_country[0]','recipient_country[__PARENT_NAME__]',form_row($form->recipient_country->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
@endsection
