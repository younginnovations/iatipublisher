@extends('web.layouts.app')

@section('title', 'Support')

@section('content')
<div class="bg-[#e5e5e5] px-5 sm:px-10 py-7 sm:py-14  -mb-7 md:-mb-20">
  <div class=" mx-auto    max-w-[700px]"> 
    <section class=" bg-white rounded  py-4 sm:py-8 shadow-textbox " >
      <article class="sm:py-6 py-4 px-6 sm:px-12  ">
                <h3 class="font-bold text-2xl text-bluecoral ">Support</h3>

        <p class="mt-4 text-base" >
          If your organisation needs support to use IATI Publisher or has questions about what data to publish please contact IATI’s Helpdesk: <a href = "mailto:support@iatistandard.org">support@iatistandard.org.</a>
        </p>
        <p class="mt-4 text-base" >
          You may also join IATI’s online community at <a href="https://iaticonnect.org/"> IATI Connect </a> , where you can post messages about IATI publishing in the <a href="https://iaticonnect.org/data-publishing-cop/about" >Data Publishing Community of Practice.</a> 
        </p>
      </article>
    </section>
  </div>
</div>

@endsection