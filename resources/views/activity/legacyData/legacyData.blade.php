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
                    <div class="hidden collection-container" form_type="legacy_data_legacy_data"
                        data-prototype="{{ form_row($form->legacy_data->prototype()) }}">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
