@extends('admin.layouts.app')

@section('content')
    <section class="section min-h-[calc(100vh_-_60px)]">

        <div class="bg-paper px-10 pt-4 pb-[71px]">
            @include('admin.layouts.activityTitle')
            <div class="activities">
                <aside class="activities__sidebar">
                    <elements-note></elements-note>
                </aside>
                <div class="activities__content">
                    <div class="py-[6.06%] px-[12%] bg-white">
                        @include('admin.activity.partial.form-title')

                        {!! form($form) !!}
                        <div class="hidden parent-collection"
                            data-prototype="{{ form_row($form->document_link->prototype()) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="document_link_title_narrative"
                            data-prototype="{{ form_row($form->document_link->getChildren()[0]->getChild('title')->getChildren()[0]->getChild('narrative')->prototype()) }}">
                        </div>
                        <div class="hidden collection-container description" form_type="document_link_description_narrative"
                            data-prototype="{{ form_row($form->document_link->getChildren()[0]->getChild('description')->getChildren()[0]->getChild('narrative')->prototype()) }}">
                        </div>
                        <div class="hidden collection-container category" form_type="document_link_category"
                            data-prototype="{{ form_row($form->document_link->getChildren()[0]->getChild('category')->prototype()) }}">
                        </div>
                        <div class="hidden collection-container language" form_type="document_link_language"
                            data-prototype="{{ form_row($form->document_link->getChildren()[0]->getChild('language')->prototype()) }}">
                        </div>
                        <div class="hidden endpoint" endpoint="{{ env('AWS_ENDPOINT').'/document_link/'.$activity['id'] }}">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
