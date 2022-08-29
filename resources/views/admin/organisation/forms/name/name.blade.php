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
                        <div class="hidden collection-container"
                            data-prototype="{{ form_row($form->narrative->prototype()) }}">
                        </div>
                    </div>
                </div>
                <div class="hidden collection-container" form_type="narrative" data-prototype="{{ form_row($form->narrative->prototype()) }}">
                </div>
            </div>
        </div>
    </section>
@endsection
