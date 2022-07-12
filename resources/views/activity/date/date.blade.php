@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection" data_name="description"
    data-prototype="{{ form_row($form->activity_date->prototype()) }}">
  </div>
  <div class="hidden collection-container" form_type="activity_date_narrative"
    data-prototype="{{ str_replace('activity_date[0]','activity_date[__PARENT_NAME__]',form_row($form->activity_date->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
@endsection
