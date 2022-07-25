
@extends('admin.layouts.app')

@section('content')
    <section class="section min-h-[calc(100vh_-_60px)]">
        <div class="px-10 pt-4 pb-[71px]">
            @include('admin.layouts.activityTitle')
            <div class="activities">
                <aside class="activities__sidebar">
                    <div class="rounded-lg bg-white p-6 text-xs leading-relaxed text-n-40">
                        <div class="mb-3">Note</div>
                        <div class="mb-3 flex justify-between">
                          <div class="flex items-center space-x-1">
                            <svg-vue class="text-sm" icon="core" ></svg-vue>
                            <span>Core Elements</span>
                          </div>
                          <hover-text
                            hover-text="You cannot publish an activity until all the mandatory fields have been filled."
                            name=""
                          />
                        </div>

                        <div class="mb-3 flex justify-between">
                          <div class="flex items-center space-x-1">
                            <svg-vue class="text-sm" icon="star" ></svg-vue>
                            <span>Mandatory sub-elements</span>
                          </div>
                          <hover-text
                            hover-text="You cannot publish an activity until all the mandatory fields have been filled."
                            name=""
                          />
                        </div>

                        <div class="mb-3 flex justify-between">
                          <div class="flex items-center space-x-1">
                            <svg-vue class="text-sm" icon="moon" ></svg-vue>
                            <span>Recommended sub-elements</span>
                          </div>
                          <hover-text
                            hover-text="You cannot publish an activity until all the mandatory fields have been filled."
                            name=""
                          />
                        </div>
                      </div>
                </aside>
                <div class="activities__content">
                    <div class="py-[6.06%] px-[12%] bg-white max-w-[1000px]">
                        @include('admin.activity.partial.form-title')

                        @yield('form')

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
