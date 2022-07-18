@extends('admin.layouts.app')

@section('content')
    <section class="section min-h-[calc(100vh_-_60px)]">
        <div class="px-10 pt-4 pb-[71px]">
            @include('admin.layouts.organizationTitle')
            <div class="activities">
                <aside class="activities__sidebar">
                    <elements-note></elements-note>
                </aside>
                <div class="activities__content">
                    <div class="py-[6.06%] px-[12%] bg-white">

                        @include('admin.organisation.partial.form-title')

                        {!! form($form) !!}
                        <div class="hidden parent-collection"
                            data-prototype="{{ form_row($form->reporting_org->prototype()) }}">
                        </div>
                        <div class="hidden collection-container" form_type="reporting_org_narrative"
                        data-prototype="{{ form_row($form->reporting_org->getChildren()[0]->getChild('narrative')->prototype()) }}">
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
