@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection" data_name="other_identifier"
    data-prototype="{{ form_row($form->other_identifier->prototype()) }}">
  </div>
  <div class="hidden collection-container"
       form_type="other_identifier_owner_org_narrative"
       data-prototype="{{ str_replace('other_identifier[0][owner_org][0]','other_identifier[__PARENT_NAME__][owner_org][__WRAPPER_NAME__]',form_row($form->other_identifier->getChildren()[0]->getChild('owner_org')->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
@endsection
