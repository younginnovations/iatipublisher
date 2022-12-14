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
            <div class="hidden parent-collection" data-prototype="{{ form_row($form->total_budget->prototype()) }}">
            </div>
            <div class="hidden collection-container" form_type="total_budget_budget_line"
              data-prototype="{{ str_replace('total_budget[0][budget_line][__NAME__]','total_budget[__PARENT_NAME__][budget_line][__WRAPPER_NAME__]',form_row($form->total_budget->getChildren()[0]->getChild('budget_line')->prototype())) }}">
            </div>
            <div class="hidden collection-container" form_type="total_budget_budget_line_narrative"
              data-prototype="{{ str_replace('total_budget[0][budget_line][0]','total_budget[__PARENT_NAME__][budget_line][__WRAPPER_NAME__]',form_row($form->total_budget->getChildren()[0]->getChild('budget_line')->getChildren()[0]->getChild('narrative')->prototype())) }}">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
