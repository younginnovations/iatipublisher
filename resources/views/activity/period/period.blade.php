@extends('admin.layouts.app')

@section('content')
    <section class="section min-h-[calc(100vh_-_60px)]">

        <div class="px-10 pt-4 pb-[71px]">
            @include('admin.layouts.activityTitle')
            <div class="activities">
                <aside class="activities__sidebar">
                    <elements-note></elements-note>
                </aside>
                <div class="activities__content">
                    <div class="py-[6.06%] px-[12%] bg-white">
                        <div class="status flex justify-end rounded-lg mb-1.5">
                            <div class="flex status text-xs leading-relaxed text-salmon-50">
                                <b class="mr-2 text-base leading-3">.</b><span>not completed</span>
                            </div>
                        </div>
                        <div class="title flex items-center mb-4">
                            <div class="text-sm shrink-0 uppercase text-n-40 font-bold">Indicator Period</div>
                            <div class="line grow h-px border-b border-n-40 ml-4"></div>
                        </div>

                        @include('admin.activity.partial.form-title')

                        {!! form($form) !!}

                        <div class="hidden collection-container title_narrative" form_type="target"
                             data-prototype="{{ form_row($form->target->prototype()) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="actual"
                             data-prototype="{{ form_row($form->actual->prototype()) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="target_comment_narrative"
                             data-prototype="{{ str_replace('target[0]','target[__PARENT_NAME__]', form_row($form->target->getChildren()[0]->getChild('comment')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="target_dimension"
                             data-prototype="{{ str_replace('target[0]','target[__PARENT_NAME__]', form_row($form->target->getChildren()[0]->getChild('dimension')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="target_document_link"
                             data-prototype="{{ str_replace('target[0]','target[__PARENT_NAME__]', form_row($form->target->getChildren()[0]->getChild('document_link')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="target_location"
                             data-prototype="{{ str_replace('target[0]','target[__PARENT_NAME__]', form_row($form->target->getChildren()[0]->getChild('location')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="actual_comment_narrative"
                             data-prototype="{{ str_replace('actual[0]','actual[__PARENT_NAME__]', form_row($form->actual->getChildren()[0]->getChild('comment')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="actual_dimension"
                             data-prototype="{{ str_replace('actual[0]','actual[__PARENT_NAME__]', form_row($form->target->getChildren()[0]->getChild('dimension')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="actual_document_link"
                             data-prototype="{{ str_replace('actual[0]','actual[__PARENT_NAME__]', form_row($form->actual->getChildren()[0]->getChild('document_link')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="actual_location"
                             data-prototype="{{ str_replace('actual[0]','actual[__PARENT_NAME__]', form_row($form->actual->getChildren()[0]->getChild('location')->prototype())) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
