@extends('admin.layouts.app')

@section('content')
  <section class="section min-h-[calc(100vh_-_60px)]">
    @include('web.components.loader')
    <div class="px-5 xl:px-10 pt-4 pb-[71px]">
      @include('admin.layouts.organizationTitle')
      <div class="activities">
        <aside class="activities__sidebar activities__sidebar-inner">
          @include('admin.organisation.partial.form-sidebar')
        </aside>
        <div class="activities__content">
          <div class="py-[6.06%] min-w-[300px] lg:min-w-[300px] px-[6%] xl:px-[12%] bg-white">

            @include('admin.organisation.partial.form-title')

            {!! form($form) !!}
            <div class="hidden parent-collection" data-prototype="{{ form_row($form->reporting_org->prototype()) }}">
            </div>
            <div class="hidden collection-container" form_type="reporting_org_narrative"
              data-prototype="{{ str_replace('reporting_org[0]','reporting_org[__PARENT_NAME__]',form_row($form->reporting_org->getChildren()[0]->getChild('narrative')->prototype())) }}">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
