@extends('admin.layouts.app')

@section("content")
  <div class="bg-paper px-10 pt-4 pb-[71px]">
    {{-- title section --}}
    <div class="page-title mb-4">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="mb-4 text-caption-c1 text-n-40">
            <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
              <p>
                <a href="/" class="font-bold">Your Activities</a>
                <span class="separator mx-4"> / </span>
                <span class="last text-n-30">Partnership against child exploitation</span>
              </p>
            </nav>
          </div>
          <div class="inline-flex items-center">
            <div class="mr-3"><a href="/">{!! file_get_contents(resource_path('assets/images/svg/arrow-short-left.svg')) !!}</a></div>
            <h4 class="mr-4 font-bold">Partnership Against Child Exploitation</h4>
          </div>
        </div>
        <div class="actions flex grow justify-end">
          <div class="inline-flex justify-center">
            <button class="button secondary-btn mr-3.5 font-bold">
              {!! file_get_contents(resource_path('assets/images/svg/download-file.svg')) !!}
            </button>
            <button class="button secondary-btn mr-3.5 font-bold">
              {!! file_get_contents(resource_path('assets/images/svg/delete.svg')) !!}
            </button>
            <button class="button secondary-btn mr-3.5 font-bold">
              {!! file_get_contents(resource_path('assets/images/svg/cancel-cloud.svg')) !!}
              <span>Unpublish</span>
            </button>
            <button class="button primary-btn relative font-bold">
              {!! file_get_contents(resource_path('assets/images/svg/approved-cloud.svg')) !!}
              <span>Add Activity</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    {{--  title section ends  --}}

  </div>
@endsection
