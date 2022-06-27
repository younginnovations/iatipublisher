@extends('admin.layouts.app')

@section('content')
    <section class="section min-h-[calc(100vh_-_60px)]">

        <div class="px-10 pt-4 pb-[71px]">
            < @include('admin.layouts.activityTitle') <div class="activities">
                <aside class="activities__sidebar">
                    <elements-note></elements-note>
                </aside>
                <div class="activities__content">
                    <div class="py-[6.06%] px-[12%] bg-white">
                        
                        @include('admin.activity.partial.form-title')

                        {!! form($form) !!}
                        <div class="hidden parent-collection"
                            data-prototype="{{ str_replace('contact_info[0]', 'contact_info[__PARENT_NAME__]', form_row($form->contact_info->prototype())) }}">
                        </div>
                        <div class="hidden collection-container organisation_narrative" form_type="organisation_narrative"
                            data-prototype="{{ str_replace('contact_info[0]','contact_info[__PARENT_NAME__]',form_row($form->contact_info->getChildren()[0]->getChild('organisation')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container department_narrative" form_type="department_narrative"
                            data-prototype="{{ str_replace('contact_info[0]','contact_info[__PARENT_NAME__]',form_row($form->contact_info->getChildren()[0]->getChild('department')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container person_name_narrative" form_type="person_name_narrative"
                            data-prototype="{{ str_replace('contact_info[0]','contact_info[__PARENT_NAME__]',form_row($form->contact_info->getChildren()[0]->getChild('person_name')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container job_title_narrative" form_type="job_title_narrative"
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
                        <div class="hidden collection-container mailing_address_narrative"
                            form_type="mailing_address_narrative"
                            data-prototype="{{ str_replace('contact_info[0]','contact_info[__PARENT_NAME__]',form_row($form->contact_info->getChildren()[0]->getChild('mailing_address')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container mailing_address" form_type="mailing_address"
                            data-prototype="{{ str_replace('contact_info[0]','contact_info[__PARENT_NAME__]',form_row($form->contact_info->getChildren()[0]->getChild('mailing_address')->prototype())) }}">
                        </div>
                    </div>
                </div>
        </div>
        </div>
    </section>
@endsection
