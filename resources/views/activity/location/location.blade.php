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
                            <div class="text-sm shrink-0 uppercase text-n-40 font-bold">Activity Location</div>
                            <div class="line grow h-px border-b border-n-40 ml-4"></div>
                        </div>
                        {!! form($form) !!}
                        <div class="hidden parent-collection"
                            data-prototype="{{ str_replace('location[0]', 'location[__PARENT_NAME__]', form_row($form->location->prototype())) }}">
                        </div>
                        <div class="hidden collection-container location_location_id" form_type="location_location_id"
                            data-prototype="{{ str_replace('location[0]','location[__PARENT_NAME__]',form_row($form->location->getChildren()[0]->getChild('location_id')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container name_narrative" form_type="name_narrative"
                            data-prototype="{{ str_replace('location[0]','location[__PARENT_NAME__]',form_row($form->location->getChildren()[0]->getChild('name')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container description_narrative"
                            form_type="description_narrative"
                            data-prototype="{{ str_replace('location[0]','location[__PARENT_NAME__]',form_row($form->location->getChildren()[0]->getChild('description')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container activity_description_narrative"
                            form_type="activity_description_narrative"
                            data-prototype="{{ str_replace('location[0]','location[__PARENT_NAME__]',form_row($form->location->getChildren()[0]->getChild('activity_description')->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                        <div class="hidden collection-container administrative" form_type="administrative"
                            data-prototype="{{ str_replace('location[0]','location[__PARENT_NAME__]',form_row($form->location->getChildren()[0]->getChild('administrative')->prototype())) }}">
                        </div>
                        {{-- <div class="hidden collection-container point_pos" form_type="point_pos"
                            data-prototype="{{ str_replace('location[0]','location[__PARENT_NAME__]',form_row($form->location->getChildren()[0]->getChild('point')->getChildren()[0]->getChild('pos')->prototype())) }}">
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
