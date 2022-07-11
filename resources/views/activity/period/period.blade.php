@extends('admin.layouts.app')

@section('content')
    <section class="section min-h-[calc(100vh_-_60px)]">

        <div class="px-10 pt-4 pb-[71px] max-w-[1000px] mx-auto">
            @include('admin.layouts.activityTitle')
            <div class="activities">
                <div class="activities__content">
                    <div class="inline-flex flex-wrap gap-2 mb-8">
                        <a href='#period_start' class="tab-btn-anchor" v-smooth-scroll>
                            <button class="tab-btn">
                                <span>period-start</span>
                            </button>
                        </a>
                        <a href="#period_end" class="tab-btn-anchor" v-smooth-scroll>
                            <button class="tab-btn">
                                <span>period-end</span>
                            </button>
                        </a>
                        <a href="#target" class="tab-btn-anchor" v-smooth-scroll>
                            <button class="tab-btn">
                                <span>target</span>
                            </button>
                        </a>
                        <a href="#actual" class="tab-btn-anchor" v-smooth-scroll>
                            <button class="tab-btn">
                                <span>actual</span>
                            </button>
                        </a>
                    </div>
                    <div class="py-[6.06%] px-[12%] bg-white">

                        @include('admin.activity.partial.form-title')

                        {!! form($form) !!}

                        <div class="hidden collection-container title_narrative" form_type="target"
                            data-prototype="{{ form_row($form->target->prototype()) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="actual"
                            data-prototype="{{ form_row($form->actual->prototype()) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="target_comment_narrative"
                            data-prototype="{{ str_replace('target[0]','target[__PARENT_NAME__]',form_row($form->target->getChildren()[0]->getChild('comment')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="target_dimension"
                            data-prototype="{{ str_replace('target[0]','target[__PARENT_NAME__]',form_row($form->target->getChildren()[0]->getChild('dimension')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="target_location"
                            data-prototype="{{ str_replace('target[0]','target[__PARENT_NAME__]',form_row($form->target->getChildren()[0]->getChild('location')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="actual_comment_narrative"
                            data-prototype="{{ str_replace('actual[0]','actual[__PARENT_NAME__]',form_row($form->actual->getChildren()[0]->getChild('comment')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="actual_dimension"
                            data-prototype="{{ str_replace('actual[0]','actual[__PARENT_NAME__]',form_row($form->target->getChildren()[0]->getChild('dimension')->prototype())) }}">
                        </div>
                        {{-- period document link --}}
                        <div class="hidden collection-container title" form_type="target_document_link"
                            data-prototype="{{ str_replace('target[0][document_link][__NAME__]','target[__PARENT_NAME__][document_link][__WRAPPER_NAME__]',form_row($form->target->getChildren()[0]->getChild('document_link')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container target_title_narrative" form_type="target_title_narrative"
                            data-prototype="{{ str_replace('target[0][document_link][0]','target[__PARENT_NAME__][document_link][__WRAPPER_NAME__]',form_row($form->target->getChildren()[0]->getChild('document_link')->getChildren()[0]->getChild('title')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container target_description_narrative"
                            form_type="target_description_narrative"
                            data-prototype="{{ str_replace('target[0][document_link][0]','target[__PARENT_NAME__][document_link][__WRAPPER_NAME__]',form_row($form->target->getChildren()[0]->getChild('document_link')->getChildren()[0]->getChild('description')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container title" form_type="target_document_link_category"
                            data-prototype="{{ str_replace('target[0][document_link][0]','target[__PARENT_NAME__][document_link][__WRAPPER_NAME__]',form_row($form->target->getChildren()[0]->getChild('document_link')->getChildren()[0]->getChild('category')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container title" form_type="target_document_link_language"
                            data-prototype="{{ str_replace('target[0][document_link][0]','target[__PARENT_NAME__][document_link][__WRAPPER_NAME__]',form_row($form->target->getChildren()[0]->getChild('document_link')->getChildren()[0]->getChild('language')->prototype())) }}">
                        </div>
                        {{-- end period document link --}}

                        {{-- period document link --}}
                        <div class="hidden collection-container title" form_type="actual_document_link"
                            data-prototype="{{ str_replace('actual[0][document_link][__NAME__]','actual[__PARENT_NAME__][document_link][__WRAPPER_NAME__]',form_row($form->actual->getChildren()[0]->getChild('document_link')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container actual_title_narrative" form_type="actual_title_narrative"
                            data-prototype="{{ str_replace('actual[0][document_link][0]','actual[__PARENT_NAME__][document_link][__WRAPPER_NAME__]',form_row($form->actual->getChildren()[0]->getChild('document_link')->getChildren()[0]->getChild('title')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container actual_description_narrative"
                            form_type="actual_description_narrative"
                            data-prototype="{{ str_replace('actual[0][document_link][0]','actual[__PARENT_NAME__][document_link][__WRAPPER_NAME__]',form_row($form->actual->getChildren()[0]->getChild('document_link')->getChildren()[0]->getChild('description')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container title" form_type="actual_document_link_category"
                            data-prototype="{{ str_replace('actual[0][document_link][0]','actual[__PARENT_NAME__][document_link][__WRAPPER_NAME__]',form_row($form->actual->getChildren()[0]->getChild('document_link')->getChildren()[0]->getChild('category')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container title" form_type="actual_document_link_language"
                            data-prototype="{{ str_replace('actual[0][document_link][0]','actual[__PARENT_NAME__][document_link][__WRAPPER_NAME__]',form_row($form->actual->getChildren()[0]->getChild('document_link')->getChildren()[0]->getChild('language')->prototype())) }}">
                        </div>
                        {{-- end period document link --}}

                        {{-- <div class="hidden collection-container title_narrative" form_type="actual_document_link"
                            data-prototype="{{ str_replace('actual[0]','actual[__PARENT_NAME__]',form_row($form->actual->getChildren()[0]->getChild('document_link')->prototype())) }}">
                        </div> --}}
                        <div class="hidden collection-container title_narrative" form_type="actual_location"
                            data-prototype="{{ str_replace('actual[0]','actual[__PARENT_NAME__]',form_row($form->actual->getChildren()[0]->getChild('location')->prototype())) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
