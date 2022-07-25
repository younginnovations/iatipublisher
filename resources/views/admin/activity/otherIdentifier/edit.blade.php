@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection" data_name="other_identifier"
    data-prototype="{{ form_row($form->owner_org->prototype()) }}">
  </div>
  <div class="hidden collection-container" form_type="owner_org_narrative"
    data-prototype="{{ str_replace('owner_org[0]','owner_org[__PARENT_NAME__]',form_row($form->owner_org->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
@endsection
