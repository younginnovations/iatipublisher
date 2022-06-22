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
                        <div class="status flex justify-end rounded-lg mb-1.5">
                            <div class="flex status text-xs leading-relaxed text-salmon-50">
                                <b class="mr-2 text-base leading-3">.</b><span>not completed</span>
                            </div>
                        </div>
                        <div class="title flex items-center mb-4">
                            <div class="text-sm shrink-0 uppercase text-n-40 font-bold">Activity Recipient Country</div>
                            <div class="line grow h-px border-b border-n-40 ml-4"></div>
                        </div>
                        {!! form($form) !!}
                    </div>
                    <div class="hidden parent-collection" data_name="description"
                        data-prototype="{{ form_row($form->recipient_country->prototype()) }}">
                    </div>
                    <div class="hidden collection-container"
                        data-prototype="{{ str_replace('recipient_country[0]','recipient_country[__PARENT_NAME__]',form_row($form->recipient_country->getChildren()[0]->getChild('narrative')->prototype())) }}">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
