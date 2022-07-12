@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection" data-prototype="{{ form_row($form->document_link->prototype()) }}">
  </div>
  <div class="hidden collection-container document_link_title_narrative" form_type="document_link_title_narrative"
    data-prototype="{{ str_replace('document_link[0]','document_link[__PARENT_NAME__]',form_row($form->document_link->getChildren()[0]->getChild('title')->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
  <div class="hidden collection-container document_link_description_narrative"
    form_type="document_link_description_narrative"
    data-prototype="{{ str_replace('document_link[0]','document_link[__PARENT_NAME__]',form_row($form->document_link->getChildren()[0]->getChild('description')->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
  <div class="hidden collection-container title" form_type="document_link_category"
    data-prototype="{{ str_replace('document_link[0]','document_link[__PARENT_NAME__]',form_row($form->document_link->getChildren()[0]->getChild('category')->prototype())) }}">
  </div>
  <div class="hidden collection-container title" form_type="document_link_language"
    data-prototype="{{ str_replace('document_link[0]','document_link[__PARENT_NAME__]',form_row($form->document_link->getChildren()[0]->getChild('language')->prototype())) }}">
  </div>
  <div class="hidden endpoint" endpoint="{{ env('AWS_ENDPOINT') . '/iati/document_link/' . $activity['id'] }}">
  </div>
@endsection
