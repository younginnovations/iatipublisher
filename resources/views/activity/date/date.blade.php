@extends('admin.layouts.app')

@section('content')
    <section class="section min-h-[calc(100vh_-_60px)]">
        <div class="px-10 pt-4 pb-[71px]">
            <div class="mb-6 page-title">
                <div class="flex items-end gap-4">
                    <div class="title grow-0">
                        <div class="mb-4 text-caption-c1 text-n-40">
                            <nav aria-label="breadcrumbs" class="breadcrumb">
                                <p>
                                    <a class="font-bold" href="/">Your Activities</a>
                                    <span class="mx-4 separator"> / </span>
                                    <span class="last text-n-30"><a
                                            href="/activities/{{ $activity['id'] }}">{{ $activity['title'][0]['narrative'] }}</a></span>
                                </p>
                            </nav>
                        </div>
                        <div class="inline-flex items-center">
                            <div class="mr-3">
                                <a href="/activities">
                                    <svg-vue icon="arrow-short-left"></svg-vue>
                                </a>
                            </div>
                            <h4 class="mr-4 font-bold">
                                {{ $activity['title'][0]['narrative'] }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="activities">
                <aside class="activities__sidebar">
                    <elements-note></elements-note>
                </aside>
                <div class="activities__content">
                    <div class="py-[6.06%] px-[12%] bg-white">
                        @include('admin.activity.partial.form-title')
                        {!! form($form) !!}
                        <div class="hidden parent-collection" data_name="description"
                            data-prototype="{{ form_row($form->activity_date->prototype()) }}">
                        </div>
                        <div class="hidden collection-container"
                            data-prototype="{{ str_replace('activity_date[0]','activity_date[__PARENT_NAME__]',form_row($form->activity_date->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
