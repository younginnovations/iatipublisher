@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection" data_name="description"
    data-prototype="{{ form_row($form->recipient_region->prototype()) }}">
  </div>
  <div class="hidden collection-container" form_type="recipient_region_narrative"
    data-prototype="{{ str_replace('recipient_region[0]','recipient_region[__PARENT_NAME__]',form_row($form->recipient_region->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
@endsection
