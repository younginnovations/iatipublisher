@extends('web.layouts.app')

@section('title', 'About IATI Publisher')

@section('content')
<div class="bg-[#e5e5e5] px-5 sm:px-10 py-7 sm:py-14  -mb-7 md:-mb-20">
  <div class=" mx-auto    max-w-[700px]"> 
    <section class=" bg-white rounded  py-4 sm:py-8 shadow-textbox " >
      <article class="sm:py-6 py-4 px-6 sm:px-12  ">
        <h3 class="font-bold text-2xl text-bluecoral ">What is IATI Publisher?</h3>
        <p class="mt-4 text-base" >IATI Publisher enables organisations to publish data on activities and resource flows according to the IATI Standard. The IATI Standard is a set of rules and guidance on how to publish useful development and humanitarian data.</p>
      </article>
      <article class="sm:py-6 py-4 px-6 sm:px-12  ">
        <h3 class="font-bold text-2xl text-bluecoral ">Use IATI Publisher to:</h3>
        <ul class="mt-4 ml-4 list-disc text-bluecoral text-base" >
          <li class="text-base  " ><span class="text-black">Register your organisation with an IATI Publisher account</span></li>
          <li class="text-base " ><span class="text-black">Understand the data fields in the IATI Standard (with IATI Standard Reference definitions, helpful explanations and links to guidance)</span></li>
          <li class="text-base " ><span class="text-black">Provide your organisation’s data easily by completing online forms. Or upload data on multiple activities on a CSV or .xml file with the Bulk Upload feature</span></li>
          <li class="text-base " ><span class="text-black">Run automatic checks (via the IATI Validator) for errors before publishing your data</span></li>
          <li class="text-base " ><span class="text-black">Publish your data. IATI Publisher will add your data to the IATI Registry (where links to all IATI data is found)</span></li>

        </ul>
        <p class="mt-4 text-base" >
          IATI Publisher has been built to support organisations that publish a limited number of development and humanitarian activities. An ‘activity’ is an individual project or another unit of development and humanitarian work, which is determined by the organisation that is publishing the data. Organisations who publish a limited number of activities tend to represent small and medium sized organisations.
        </p>
        <p class="mt-4 text-base" >
          Large organisations, such as donor governments or UN agencies delivering 100+ activities are advised not to use IATI Publisher. Instead these organisations likely need to use an alternative technical solution that enables the publication of large volumes of data. Please email the IATI Helpdesk for more information:    </p>

      </article>
      <article class="sm:py-6 py-4 px-6 sm:px-12 ounded ">
          <h3 class="font-bold text-2xl text-bluecoral ">
            Development of IATI Publisher
          </h3> 
          <p class="mt-4 text-base" >
            IATI Publisher was first launched in December 2022 by the IATI Secretariat and has been developed by Young Innovations, a software development firm based in Nepal. IATI Publisher is fully aligned with the IATI Standard XML schema and rulesets.
        </p>
      </article>
    </section>
  </div>
</div>

@endsection