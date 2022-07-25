@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection"
    data-prototype="{{ str_replace('participating_org[0]', 'participating_org[__PARENT_NAME__]', form_row($form->participating_org->prototype())) }}">
  </div>
  <div class="hidden collection-container participating_org_narrative" form_type="participating_org_narrative"
    data-prototype="{{ str_replace('participating_org[0]','participating_org[__PARENT_NAME__]',form_row($form->participating_org->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
@endsection
