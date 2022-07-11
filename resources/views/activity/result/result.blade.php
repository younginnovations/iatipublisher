@extends('admin.layouts.app')

@section('content')
    <section class="section min-h-[calc(100vh_-_60px)]">

        <div class="px-10 pt-4 pb-[71px] max-w-[1000px] mx-auto">
            @include('admin.layouts.activityTitle')
            <div class="activities">
                <div class="activities__content">
                    <div class="inline-flex flex-wrap gap-2 mb-8">
                        <a href='#title' class="tab-btn-anchor" v-smooth-scroll>
                            <button class="tab-btn">
                                <span>title</span>
                            </button>
                        </a>
                        <a href="#description" class="tab-btn-anchor" v-smooth-scroll>
                            <button class="tab-btn">
                                <span>description</span>
                            </button>
                        </a>
                        <a href="#document_link" class="tab-btn-anchor" v-smooth-scroll>
                            <button class="tab-btn">
                                <span>document-link</span>
                            </button>
                        </a>
                        <a href="#reference" class="tab-btn-anchor" v-smooth-scroll>
                            <button class="tab-btn">
                                <span>reference</span>
                            </button>
                        </a>
                    </div>
                    <div class="py-[6.06%] px-[12%] bg-white">

                        @include('admin.activity.partial.form-title')


                        {!! form($form) !!}
                        <div class="hidden parent-collection" form_type="document_link"
                            data-prototype="{{ form_row($form->document_link->prototype()) }}">
                        </div>
                        <div class="hidden parent-collection" form_type="reference"
                            data-prototype="{{ form_row($form->reference->prototype()) }}">
                        </div>

                        <div class="hidden collection-container title_narrative" form_type="title_narrative"
                            data-prototype="{{ form_row($form->title->getChildren()[0]->getChild('narrative')->prototype()) }}">
                        </div>
                        <div class="hidden collection-container description_narrative" form_type="description_narrative"
                            data-prototype="{{ form_row($form->description->getChildren()[0]->getChild('narrative')->prototype()) }}">
                        </div>
                        <div class="hidden collection-container document_link_title_narrative"
                            form_type="document_link_title_narrative"
                            data-prototype="{{ str_replace('document_link[0]','document_link[__PARENT_NAME__]',form_row($form->document_link->getChildren()[0]->getChild('title')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container document_link_description_narrative"
                            form_type="document_link_description_narrative"
                            data-prototype="{{ str_replace('document_link[0]','document_link[__PARENT_NAME__]',form_row($form->document_link->getChildren()[0]->getChild('description')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container category" form_type="document_link_category"
                            data-prototype="{{ str_replace('document_link[0]','document_link[__PARENT_NAME__]',form_row($form->document_link->getChildren()[0]->getChild('category')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container language" form_type="document_link_language"
                            data-prototype="{{ str_replace('document_link[0]','document_link[__PARENT_NAME__]',form_row($form->document_link->getChildren()[0]->getChild('language')->prototype())) }}">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
