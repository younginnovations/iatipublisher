@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection"
    data-prototype="{{ str_replace('location[0]', 'location[__PARENT_NAME__]', form_row($form->location->prototype())) }}">
  </div>
  <div class="hidden collection-container location_location_id" form_type="location_location_id"
    data-prototype="{{ str_replace('location[0]','location[__PARENT_NAME__]',form_row($form->location->getChildren()[0]->getChild('location_id')->prototype())) }}">
  </div>
  <div class="hidden collection-container location_name_narrative" form_type="location_name_narrative"
    data-prototype="{{ str_replace('location[0]','location[__PARENT_NAME__]',form_row($form->location->getChildren()[0]->getChild('name')->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
  <div class="hidden collection-container location_description_narrative" form_type="location_description_narrative"
    data-prototype="{{ str_replace('location[0]','location[__PARENT_NAME__]',form_row($form->location->getChildren()[0]->getChild('description')->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
  <div class="hidden collection-container location_activity_description_narrative"
    form_type="location_activity_description_narrative"
    data-prototype="{{ str_replace('location[0]','location[__PARENT_NAME__]',form_row($form->location->getChildren()[0]->getChild('activity_description')->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
  <div class="hidden collection-container administrative" form_type="administrative"
    data-prototype="{{ str_replace('location[0]','location[__PARENT_NAME__]',form_row($form->location->getChildren()[0]->getChild('administrative')->prototype())) }}">
  </div>
  {{-- <div class="hidden collection-container point_pos" form_type="point_pos"
    data-prototype="{{ str_replace('location[0]','location[__PARENT_NAME__]',form_row($form->location->getChildren()[0]->getChild('point')->getChildren()[0]->getChild('pos')->prototype())) }}">
</div> --}}
@endsection
