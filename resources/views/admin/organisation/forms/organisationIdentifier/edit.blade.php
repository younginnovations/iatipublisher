@extends('admin.layouts.app')

@section('content')
    <section class="section min-h-[calc(100vh_-_60px)]">
        @include('web.components.loader')
        <div class="px-5 xl:px-10 pt-4 pb-[71px]">
            @include('admin.layouts.organizationTitle')
            <div class="activities">
                <aside class="activities__sidebar">
                    @include('admin.organisation.partial.form-sidebar')
                </aside>
                <div class="activities__content">
                    <div class="py-[6.06%] px-[6%] xl:px-[12%] bg-white max-w-[1000px]">

                        @include('admin.organisation.partial.form-title')

                        @if (Session::has('error'))
                            <p class='error'>{{ Session::get('error') }}</p>
                        @endif

                        {!! form($form) !!}

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
