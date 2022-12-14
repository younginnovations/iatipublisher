@extends('admin.layouts.app')

@section('content')
  <section class="section min-h-[calc(100vh_-_60px)]">
    @include('web.components.loader')
    <div class="px-5 xl:px-10 pt-4 pb-[71px]">
      @include('admin.layouts.activityTitle')
      <div class="activities">
        <aside class="activities__sidebar activities__sidebar-inner">
          <sidebar-help-block></sidebar-help-block>
        </aside>
        <div class="activities__content  ">
          <div class="py-[6.06%] px-[6.06%] xl:px-[12%]  max-w-[50vw] outline  min-w-[300px] bg-white">
            @include('admin.activity.partial.form-title')

            @yield('form')

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
