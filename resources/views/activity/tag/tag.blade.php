@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection" data_name="description" data-prototype="{{ form_row($form->tag->prototype()) }}">
  </div>
  <div class="hidden collection-container" form_type="tag_narrative"
    data-prototype="{{ str_replace('tag[0]','tag[__PARENT_NAME__]',form_row($form->tag->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
@endsection
