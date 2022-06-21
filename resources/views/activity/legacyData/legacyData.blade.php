@extends('admin.layouts.app')

@section('content')
    <section class="section min-h-[calc(100vh_-_60px)]">
        <div class="bg-paper px-10 pt-4 pb-[71px]">
            <div class="page-title mb-6">
                <div class="flex items-end gap-4">
                    <div class="title grow-0">
                        <div class="mb-4 text-caption-c1 text-n-40">
                            <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
                                <p>
                                    <a class="font-bold" href="/">Your Activities</a>
                                    <span class="separator mx-4"> / </span>
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
                        <div class="status flex justify-end rounded-lg mb-1.5">
                            <div class="flex status text-xs leading-relaxed text-salmon-50">
                                <b class="mr-2 text-base leading-3">.</b><span>not completed</span>
                            </div>
                        </div>
                        <div class="title flex items-center mb-4">
                            <div class="text-sm shrink-0 uppercase text-n-40 font-bold">Activity Legacy Data</div>
                            <div class="line grow h-px border-b border-n-40 ml-4"></div>
                        </div>
                        {!! form($form) !!}
                    </div>
                    <div class="hidden collection-container" form_type="legacy_data"
                        data-prototype="{{ form_row($form->legacy_data->prototype()) }}">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
