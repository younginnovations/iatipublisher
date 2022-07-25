@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection" data_name="description"
    data-prototype="{{ form_row($form->humanitarian_scope->prototype()) }}">
  </div>
  <div class="hidden collection-container" form_type="humanitarian_scope_narrative"
    data-prototype="{{ str_replace('humanitarian_scope[0]','humanitarian_scope[__PARENT_NAME__]',form_row($form->humanitarian_scope->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
@endsection
