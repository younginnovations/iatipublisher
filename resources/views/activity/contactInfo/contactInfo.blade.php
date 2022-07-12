@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden parent-collection"
    data-prototype="{{ str_replace('contact_info[0]', 'contact_info[__PARENT_NAME__]', form_row($form->contact_info->prototype())) }}">
  </div>
  <div class="hidden collection-container contact_info_organisation_narrative"
    form_type="contact_info_organisation_narrative"
    data-prototype="{{ str_replace('contact_info[0]','contact_info[__PARENT_NAME__]',form_row($form->contact_info->getChildren()[0]->getChild('organisation')->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
  <div class="hidden collection-container contact_info_department_narrative" form_type="contact_info_department_narrative"
    data-prototype="{{ str_replace('contact_info[0]','contact_info[__PARENT_NAME__]',form_row($form->contact_info->getChildren()[0]->getChild('department')->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
  <div class="hidden collection-container contact_info_person_name_narrative" form_type="contact_info_person_name_narrative"
    data-prototype="{{ str_replace('contact_info[0]','contact_info[__PARENT_NAME__]',form_row($form->contact_info->getChildren()[0]->getChild('person_name')->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
  <div class="hidden collection-container contact_info_job_title_narrative" form_type="contact_info_job_title_narrative"
    data-prototype="{{ str_replace('contact_info[0]','contact_info[__PARENT_NAME__]',form_row($form->contact_info->getChildren()[0]->getChild('job_title')->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
  <div class="hidden collection-container contact_info_telephone" form_type="contact_info_telephone"
    data-prototype="{{ str_replace('contact_info[0]','contact_info[__PARENT_NAME__]',form_row($form->contact_info->getChildren()[0]->getChild('telephone')->prototype())) }}">
  </div>
  <div class="hidden collection-container contact_info_email" form_type="contact_info_email"
    data-prototype="{{ str_replace('contact_info[0]','contact_info[__PARENT_NAME__]',form_row($form->contact_info->getChildren()[0]->getChild('email')->prototype())) }}">
  </div>
  <div class="hidden collection-container contact_info_website" form_type="contact_info_website"
    data-prototype="{{ str_replace('contact_info[0]','contact_info[__PARENT_NAME__]',form_row($form->contact_info->getChildren()[0]->getChild('website')->prototype())) }}">
  </div>
  <div class="hidden collection-container contact_info_mailing_address_narrative"
    form_type="contact_info_mailing_address_narrative"
    data-prototype="{{ str_replace('contact_info[0]','contact_info[__PARENT_NAME__]',form_row($form->contact_info->getChildren()[0]->getChild('mailing_address')->getChildren()[0]->getChild('narrative')->prototype())) }}">
  </div>
  <div class="hidden collection-container mailing_address" form_type="contact_info_mailing_address"
    data-prototype="{{ str_replace('contact_info[0]','contact_info[__PARENT_NAME__]',form_row($form->contact_info->getChildren()[0]->getChild('mailing_address')->prototype())) }}">
  </div>
@endsection
