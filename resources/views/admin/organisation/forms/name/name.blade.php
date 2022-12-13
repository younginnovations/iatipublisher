@extends('admin.layouts.app')

@section('content')
  <section class="section min-h-[calc(100vh_-_60px)]">
    @include('web.components.loader')
    <div class="px-5 xl:px-10 pt-4 pb-[71px]">
      @include('admin.layouts.organizationTitle')
      <div class="activities">
        <aside class="activities__sidebar  activities__sidebar-inner">
          @include('admin.organisation.partial.form-sidebar')
        </aside>
        <div class="activities__content">
          <div class="py-[6.06%] min-w-[300px] lg:min-w-[500px] px-[6%] xl:px-[12%] bg-white">

            @include('admin.organisation.partial.form-title')

            {!! form($form) !!}
            <div class="hidden  collection-container" data-prototype="{{ form_row($form->narrative->prototype()) }}">
            </div>
          </div>
        </div>
        <div class="hidden  collection-container" form_type="name_narrative"
          data-prototype="{{ form_row($form->narrative->prototype()) }}">
        </div>
      </div>
    </div>
  </section>
@endsection
