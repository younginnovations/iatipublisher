@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection"
    data-prototype="{{ str_replace('planned_disbursement[0]', 'planned_disbursement[__PARENT_NAME__]', form_row($form->planned_disbursement->prototype())) }}">
  </div>
  <div class="hidden collection-container" form_type="planned_disbursement_provider_org_narrative"
    data-prototype="{{ str_replace('planned_disbursement[0]','planned_disbursement[__PARENT_NAME__]',form_row($form->planned_disbursement->getChildren()[0]->getChild('provider_org')->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
  <div class="hidden collection-container" form_type="planned_disbursement_receiver_org_narrative"
    data-prototype="{{ str_replace('planned_disbursement[0]','planned_disbursement[__PARENT_NAME__]',form_row($form->planned_disbursement->getChildren()[0]->getChild('receiver_org')->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
@endsection
