@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection" data_name="description"
    data-prototype="{{ form_row($form->sector->prototype()) }}">
  </div>
  <div class="hidden collection-container" form_type="sector_narrative"
    data-prototype="{{ str_replace('sector[0]','sector[__PARENT_NAME__]',form_row($form->sector->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
@endsection
