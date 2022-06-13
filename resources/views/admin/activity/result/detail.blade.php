@extends('admin.layouts.app')

@section("content")
    <div class="bg-paper px-10 pt-4 pb-[71px]">
        <div class="page-title mb-6">
            <div class="flex items-end gap-4">
                <div class="title grow-0">
                    <div class="mb-4 text-caption-c1 text-n-40">
                        <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
                            <p>
                                <a href="/activities" class="font-bold">
                                    Your Activities
                                </a>
                                <span class="separator mx-4"> / </span>
                                <span class="text-n-30">
                                    <a href="/activities/1">Activity Name</a>
                                </span>
                                <span class="separator mx-4"> / </span>
                                <span class="text-n-30"> Add Result </span>
                                <span class="separator mx-4"> / </span>
                                <span class="last text-n-30"> Result Detail </span>
                            </p>
                        </nav>
                    </div>
                    <div class="inline-flex items-center">
                        <div class="mr-3">
                            <a href="/activities">
                                <svg-vue icon="arrow-short-left"></svg-vue>
                            </a>
                        </div>
                        <h4 class="mr-4 font-bold">Result detail</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="activities">
            <aside class="activities__sidebar">
                <div class="indicator rounded-lg bg-eggshell py-4 px-6 text-n-50">
                    <ul class="text-sm leading-relaxed font-bold">
                        @php
                            $linkClasses = "flex items-center w-full bg-white rounded p-2 text-sm text-n-50 font-bold leading-relaxed mb-2 shadow-default"
                        @endphp
                        <li>
                            <a href="#"
                               class="{{ $linkClasses }}">
                                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                                title
                            </a>
                        </li>
                        <li>
                            <a href="#"
                               class="{{ $linkClasses }}">
                                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                                description
                            </a>
                        </li>
                        <li>
                            <a href="#"
                               class="{{ $linkClasses }}">
                                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                                document-link
                            </a>
                        </li>
                        <li>
                            <a href="#"
                               class="{{ $linkClasses }}">
                                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                                reference
                            </a>
                        </li>
                    </ul>
                    <button
                        class="flex w-full bg-white border border-dashed border-n-40 rounded p-2 text-sm font-bold leading-relaxed">
                        <svg-vue icon="add" class="mr-2 text-n-40"></svg-vue>
                        add indicator
                    </button>
                </div>
            </aside>
            <div class="activities__content">

            </div>
        </div>
    </div>

@endsection
