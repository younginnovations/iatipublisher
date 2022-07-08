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
                        @include('admin.activity.partial.form-title')
                        {!! form($form) !!}
                        <div class="hidden parent-collection"
                            data-prototype="{{ str_replace('participating_org[0]', 'participating_org[__PARENT_NAME__]', form_row($form->participating_org->prototype())) }}">
                        </div>
                        <div class="hidden collection-container participating_org_narrative"
                            form_type="participating_org_narrative"
                            data-prototype="{{ str_replace('participating_org[0]','participating_org[__PARENT_NAME__]',form_row($form->participating_org->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
