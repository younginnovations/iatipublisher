

@extends('admin.layouts.app')

@section("content")
    <section class="section min-h-[calc(100vh_-_60px)]">
        <div class="title-form-layout">
            <div class="pt-4 pb-6 max-w-[1000px] mx-auto">
                <div class="page-title mb-6">
                    <div class="flex items-end gap-4">
                        <div class="title grow-0">
                            <div class="mb-4 text-caption-c1 text-n-40">
                                <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
                                    <p>
                                        <a href="/activities" class="font-bold">Your Activities</a>
                                        <span class="separator mx-4"> / </span>
                                        <span class="last text-n-30"
                                        ><a href="/activities/{{$activity['id']}}">{{$activity['title'][0]['narrative']}}</a></span
                                        >
                                    </p>
                                </nav>
                            </div>
                            <div class="inline-flex items-center">
                                <div class="mr-3">
                                    <a href="/activities/1">
                                        <svg-vue icon="arrow-short-left"></svg-vue>
                                    </a>
                                </div>
                                <h4 class="mr-4 font-bold">
                                    {{$activity['title'][0]['narrative']}}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="title-form-layout__container p-8 bg-white rounded-lg overflow-y-auto max-h-[62vh]">
                    {{-- title --}}
                    <div class="flex mb-4">
                        <div class="flex title grow">
                            <span class="text-bluecoral text-xl mr-1.5">
                            @php
                                echo file_get_contents(resource_path('assets/images/svg/note.svg'))
                            @endphp
                            </span>
                            <div class="title text-sm font-bold">Activity Title</div>
                            <div class="flex status text-xs leading-5 text-crimson-50 ml-2.5 mr-2.5">
                                <b class="mr-2 text-base leading-3">.</b>
                                <span>not completed</span>
                            </div>
                            @php
                                echo file_get_contents(resource_path('assets/images/svg/core.svg'))
                            @endphp
                        </div>
                        <div class="icons flex">
                            <span class="text-xs"><sup class="text-salmon-50">*</sup> Mandatory fields</span>
                            <hover-text hover_text="tooltip" class="ml-1"/>
                        </div>
                    </div>
                    <div class="divider h-px bg-n-20 w-full mb-4"></div>

                    {{-- form section --}}
                    {!! form($form) !!}
                </div>
                <div class="hidden collection-container"
                    data-prototype="{{ form_row($form->narrative->prototype()) }}">
                </div>

            </div>
        </div>
    </section>

@endsection

