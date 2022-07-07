@extends('admin.layouts.app')

@section('content')
    <section class="section min-h-[calc(100vh_-_60px)]">

        <div class="px-10 pt-4 pb-[71px]">
            @include('admin.layouts.activityTitle')
            <div class="activities">
                <aside class="activities__sidebar">
                    <elements-note></elements-note>
                </aside>
                <div class="activities__content">
                    <div class="py-[6.06%] px-[12%] bg-white">
                        @include('admin.activity.partial.form-title')

                        {!! form($form) !!}

                        <div class="hidden collection-container title_narrative" form_type="transaction_description_narrative"
                             data-prototype="{{ form_row($form->description->getChildren()[0]->getChild('narrative')->prototype()) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="transaction_provider_organization_narrative"
                             data-prototype="{{ form_row($form->provider_organization->getChildren()[0]->getChild('narrative')->prototype()) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="transaction_receiver_organization_narrative"
                             data-prototype="{{ form_row($form->receiver_organization->getChildren()[0]->getChild('narrative')->prototype()) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="sector"
                             data-prototype="{{ form_row($form->sector->prototype()) }}">
                        </div>
                        <div class="hidden collection-container" form_type="transaction_sector_narrative"
                             data-prototype="{{ str_replace('sector[0]','sector[__PARENT_NAME__]',form_row($form->sector->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden parent-collection" form_type="transaction_sector"
                             data-prototype="{{ str_replace('sector[0]','sector[__PARENT_NAME__]',form_row($form->sector->prototype())) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="transaction_recipient_country_narrative"
                             data-prototype="{{ form_row($form->recipient_country->getChildren()[0]->getChild('narrative')->prototype()) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="transaction_recipient_region_narrative"
                             data-prototype="{{ form_row($form->recipient_region->getChildren()[0]->getChild('narrative')->prototype()) }}">
                        </div>
                        <div class="hidden collection-container title_narrative" form_type="transaction_aid_type"
                             data-prototype="{{ form_row($form->aid_type->prototype()) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
