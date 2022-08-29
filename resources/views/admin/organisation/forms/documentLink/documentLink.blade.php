@extends('admin.layouts.app')

@section('content')
    <section class="section min-h-[calc(100vh_-_60px)]">
        <div class="px-10 pt-4 pb-[71px]">
            @include('admin.layouts.organizationTitle')
            <div class="activities">
                <aside class="activities__sidebar">
                    @include('admin.organisation.partial.form-sidebar')
                </aside>
                <div class="activities__content">
                    <div class="py-[6.06%] px-[12%] bg-white max-w-[1000px]">

                        @include('admin.organisation.partial.form-title')

                        {!! form($form) !!}
                        <div class="hidden parent-collection"
                            data-prototype="{{ form_row($form->document_link->prototype()) }}">
                        </div>
                        <div class="hidden collection-container document_link_title_narrative"
                            form_type="document_link_title_narrative"
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
                        <div class="hidden collection-container" form_type="document_link_recipient_country"
                        data-prototype="{{ str_replace('document_link[0][recipient_country][__NAME__]','document_link[__PARENT_NAME__][recipient_country][__WRAPPER_NAME__]',form_row($form->document_link->getChildren()[0]->getChild('recipient_country')->prototype())) }}">
                    </div>
                    <div class="hidden collection-container" form_type="document_link_recipient_country_narrative"
                        data-prototype="{{ str_replace('document_link[0][recipient_country][0]','document_link[__PARENT_NAME__][recipient_country][__WRAPPER_NAME__]',form_row($form->document_link->getChildren()[0]->getChild('recipient_country')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
