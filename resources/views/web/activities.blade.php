@extends('web.layouts.app')

@section("content")
  <div id="activity-listing-page" class="bg-paper px-[40px] pt-[16px] pb-[71px]">

    <div id="activity">
      {{--  page title  --}}
      <page-title></page-title>

      {{--   if no activity listing available show empty state layout   --}}
{{--         <empty-activity></empty-activity>--}}

      {{--  Else show table listing layout   --}}
        <table-listing></table-listing>
    </div>
{{--    {!! file_get_contents(public_path('images/arrow-right.svg')) !!}--}}

  </div>
@endsection
