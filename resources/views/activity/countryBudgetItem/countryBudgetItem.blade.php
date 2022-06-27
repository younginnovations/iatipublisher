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
                        <div class="hidden parent-collection" data_name="condition"
                            data-prototype="{{ form_row($form->budget_item->prototype()) }}">
                        </div>
                        <div class="hidden collection-container description_narrative" form_type="description_narrative"
                            data-prototype="{{ str_replace('budget_item[0]','budget_item[__PARENT_NAME__]',form_row($form->budget_item->getChildren()[0]->getChild('description')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
