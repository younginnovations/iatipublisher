@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection" data_name="description"
    data-prototype="{{ form_row($form->description->prototype()) }}">
  </div>
  <div class="hidden collection-container" form_type="description_narrative"
    data-prototype="{{ str_replace('description[0]','description[__PARENT_NAME__]',form_row($form->description->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
@endsection
