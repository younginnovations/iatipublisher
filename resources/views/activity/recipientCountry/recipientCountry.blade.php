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
                    </div>
                    <div class="hidden parent-collection" data_name="description"
                        data-prototype="{{ form_row($form->recipient_country->prototype()) }}">
                    </div>
                    <div class="hidden collection-container" form_type="recipient_country_narrative"
                        data-prototype="{{ str_replace('recipient_country[0]','recipient_country[__PARENT_NAME__]',form_row($form->recipient_country->getChildren()[0]->getChild('narrative')->prototype())) }}">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
