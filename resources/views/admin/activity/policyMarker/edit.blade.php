@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection" data_name="description"
    data-prototype="{{ form_row($form->policy_marker->prototype()) }}">
  </div>
  <div class="hidden collection-container" form_type="policy_marker_narrative"
    data-prototype="{{ str_replace('policy_marker[0]','policy_marker[__PARENT_NAME__]',form_row($form->policy_marker->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
@endsection
