@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection" data_name="condition"
    data-prototype="{{ form_row($form->budget_item->prototype()) }}">
  </div>
  <div class="hidden collection-container budget_item_description_narrative" form_type="budget_item_description_narrative"
    data-prototype="{{ str_replace('budget_item[0]','budget_item[__PARENT_NAME__]',form_row($form->budget_item->getChildren()[0]->getChild('description')->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
@endsection
