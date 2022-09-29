@extends('admin.layouts.app')

@section('content')
  <section class="section min-h-[calc(100vh_-_60px)]">
    @include('web.components.loader')
    <div class="px-5 xl:px-10 pt-4 pb-[71px]">
      @include('admin.layouts.activityTitle')
      <div class="activities">
        <aside class="activities__sidebar">
          <elements-note></elements-note>
          <sidebar-help-block></sidebar-help-block>
        </aside>
        <div class="activities__content">
          <div class="py-[6.06%] px-[6%] xl:px-[12%] bg-white max-w-[1000px]">
            @include('admin.activity.partial.form-title')

            {!! form($form) !!}

            <div class="hidden collection-container description_narrative" form_type="description_narrative"
              data-prototype="{{ form_row($form->description->getChildren()[0]->getChild('narrative')->prototype()) }}">
            </div>
            <div class="hidden collection-container provider_organization_narrative"
              form_type="provider_organization_narrative"
              data-prototype="{{ form_row($form->provider_organization->getChildren()[0]->getChild('narrative')->prototype()) }}">
            </div>
            <div class="hidden collection-container receiver_organization_narrative"
              form_type="receiver_organization_narrative"
              data-prototype="{{ form_row($form->receiver_organization->getChildren()[0]->getChild('narrative')->prototype()) }}">
            </div>
            <div class="hidden parent-collection sector" form_type="sector" has_children="true"
              data-prototype="{{ form_row($form->sector->prototype()) }}">
            </div>
            <div class="hidden collection-container sector_narrative" form_type="sector_narrative"
              data-prototype="{{ str_replace('sector[0]','sector[__PARENT_NAME__]',form_row($form->sector->getChildren()[0]->getChild('narrative')->prototype())) }}">
            </div>
            <div class="hidden parent-collection" form_type="transaction_sector"
              data-prototype="{{ str_replace('sector[0]', 'sector[__PARENT_NAME__]', form_row($form->sector->prototype())) }}">
            </div>
            <div class="hidden collection-container recipient_country_narrative" form_type="recipient_country_narrative"
              data-prototype="{{ form_row($form->recipient_country->getChildren()[0]->getChild('narrative')->prototype()) }}">
            </div>
            <div class="hidden collection-container recipient_region_narrative" form_type="recipient_region_narrative"
              data-prototype="{{ form_row($form->recipient_region->getChildren()[0]->getChild('narrative')->prototype()) }}">
            </div>
            <div class="hidden parent-collection aid_type" form_type="aid_type"
              data-prototype="{{ form_row($form->aid_type->prototype()) }}">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
