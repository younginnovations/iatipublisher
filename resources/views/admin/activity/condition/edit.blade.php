@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection" data_name="condition"
    data-prototype="{{ form_row($form->condition->prototype()) }}">
  </div>
  <div class="hidden collection-container" form_type="condition_narrative"
    data-prototype="{{ str_replace('condition[0]','condition[__PARENT_NAME__]',form_row($form->condition->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
@endsection
