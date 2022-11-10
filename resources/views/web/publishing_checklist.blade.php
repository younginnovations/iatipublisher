@extends('web.layouts.app')

@section('title', 'Publisher Checklist')

@section('content')
<div class="bg-[#e5e5e5] px-5 sm:px-10 py-7 sm:py-14  -mb-7 md:-mb-20">
  <div class=" mx-auto    max-w-[700px]"> 
    <section class=" bg-white rounded px-6 sm:px-12 py-4 sm:py-8 shadow-textbox " >
        <h3 class="font-bold text-lg text-bluecoral ">
            Organisations using IATI Publisher need to take the following steps to publish your data:
        </h3>
        <article class="py-4 sm:py-6   ">
                <h3 class="font-bold text-2xl text-bluecoral ">
                    1. Register a Publisher Account
                </h3>
                <p class="my-2 text-base">
                    Organisations who publish data to IATI are referred to as 'Publishers'. Before publishing data, organisations need their own 'Publisher Account' on the IATI Registry (iatiregistry.org). If your organisation does not yet have a Publisher Account on the IATI Registry, IATI Publisher will ask you for additional details and create one for you (so you don’t have to visit IATI Registry to do this). 
                </p>
                <a href="#">
                    Create your IATI Registry Publisher Account
                </a>
                <p class="my-2 text-base">
                    If your organisation has already registered a Publisher Account on the IATI Registry, IATI Publisher will ask you to provide your organisation’s account details.
                </p>
                <a href="#">
                    Provide your organisations existing IATI Registry Publisher Account details  
                </a>
        </article>
        <article class="py-4 sm:py-6   ">
            <h3 class="font-bold text-2xl text-bluecoral ">
                2. Publish your Organisation Data
            </h3>
            <p class="my-2 text-base">
                The IATI Standard requires you to provide data about your entire organisation. For example, basic information about your organisation, such as its name and financial data about your entire organisation’s budgets and expenditure.
            </p>
            <p class="my-2 text-base">
                The IATI Standard contains a wide range of data fields. Data fields are referred to as ‘elements’ and they represent a basic unit of information in the IATI Standard. For each element you will find its technical definition, which is labelled as “IATI Standard Reference” and helpful guidance on the data you are required to provide. Your organisation is encouraged to (at least) publish data in fields marked as “Core” in IATI Publisher. Core elements include IATI’s "mandatory and recommended" elements and it is important to provide this data to ensure your data is usable and useful.            </p>
            <a href="/iati-standerd">
                Discover what Activity Data is required by the IATI Standard
            </a>
           <br/>
            <a href="#">
                Publish you Activity Data
            </a>
        </article>
        <article class="py-4 sm:py-6   ">
            <h3 class="font-bold text-2xl text-bluecoral ">
                3. Publish your Activity Data
            </h3>
            <p class="my-2 text-base">
                You also need to provide data about your organisation’s development and humanitarian ‘activities’. The unit of work described by an ‘activity’ is determined by the organisation that is publishing the data. For example, an activity could be a donor government providing US$ 50 million to a recipient country’s government to implement basic education over 5 years. Or an activity could be an NGO spending US$ 500,000 to deliver clean drinking water to 1000 households over 6 months.             
            </p>
            <p class="mt-2 text-base">
                Therefore your organisation will need to determine how it will divide its work internally into activities. You could consider one activity to be:   
            </p>
            <ul class="mt-4 ml-4 list-disc text-bluecoral text-base" >
                <li class="text-base  " ><span class="text-black">a large programme at country or region level</span></li>
                <li class="text-base " ><span class="text-black">a smaller project in a local area</span></li>
                <li class="text-base " ><span class="text-black">the work relating to a particular grant or contract</span></li>
            </ul>
            <p class="mt-2 text-base">
                Therefore your organisation will need to determine how it will divide its work internally into activities. You could consider one activity to be:   
            </p>
            <ul class="mt-4 ml-4 list-disc text-bluecoral text-base" >
                <li class="text-base  " ><span class="text-black">fill out the data fields in the Activity Data form for each Activity that you create</span></li>
                <li class="text-base " ><span class="text-black">If you have multiple activities, you can use the <strong>Bulk Upload</strong> feature to upload a spreadsheet of the core fields of your data then you can edit them further using the online Activity Data form.</span></li>
            </ul>
            <p class="my-2 text-base">
                When publishing your Activity Data you are encouraged to (at least) publish data in fields marked as “Core” in IATI Publisher. They include IATI’s "mandatory and recommended" elements and it is important to provide this data to ensure your data is usable and useful.
            </p>

           <a href="/iati-standerd">
                Discover what Activity Data is required by the IATI Standard
            </a>
           <br/>
            <a href="#">
                Publish you Activity Data
            </a>
        </article>
        <article class="py-4 sm:py-6   ">
            <h3 class="font-bold text-2xl text-bluecoral ">
                4. Understand further data requirements

            </h3>
            <p class="my-2 text-base">
                If your organisation receives funding from the UK, Dutch or Belgian governments, you may also need to report IATI data according to their specific requirements. You are advised to understand the specific IATI data requirements of each government if you are receiving a grant from them.See <a href="https://iatistandard.org/en/guidance/standard-overview/donors-reporting-requirements/">  more information</a>.
            </p>
            <p class="my-2 text-base">
                You will also need to consider if your organisation needs to exclude data that it publishes. For example an organisation may not be able to publish data because of political sensitivity issues or if information is commercially restricted. See information on creating an <a href="https://iatistandard.org/en/guidance/preparing-organisation/organisation-data-publication/information-and-data-you-cant-publish-exclusions/"> Exclusion Policy </a>. 
            </p>

        </article>
        <article class="py-4 sm:py-6   ">
            <h3 class="font-bold text-2xl text-bluecoral ">
                5. Run automatic checks on your data for errors

            </h3>
            <p class="my-2 text-base">
                After you have added your data to IATI Publisher, it will run automatic checks for errors. You will receive information about any errors that you need to fix. Make sure you fix these errors before publishing your data.
            </p>

        </article>
        <article class="py-4 sm:py-6   ">
            <h3 class="font-bold text-2xl text-bluecoral ">
                6. Publish your data to the IATI Registry
            </h3>
            <p class="my-2 text-base">
                Once you are happy with the data that you have provided, you can instruct IATI Publisher to publish it.
            </p>
            <p class="my-2 text-base">
                IATI Publisher converts your data files into XML, the format that is required by the IATI Standard. IATI Publisher will store your XML data files online, and provide a link to these files on the IATI Registry. The IATI Registry stores links to every IATI data file published and you can search for your organisation’s IATI XML files here: <br/>
                <a href="https://iatiregistry.org/publisher/"> https://iatiregistry.org/publisher/ </a> . 
            </p>

        </article>
        <article class="py-4 sm:py-6   ">
            <h3 class="font-bold text-2xl text-bluecoral ">
                7. Access your data
            </h3>
            <p class="my-2 text-base">
                IATI data is open data and can be accessed by anyone. It is pulled from the IATI Registry and used for many purposes. For example, IATI data can be used by governments to monitor development resources going into their countries, by donors and civil society to enable coordination, by analysts and academics to inform research and policy, or by organisations who include IATI data in their own online data portals.
            </p>
            <p class="my-2 text-base">
                There are many online data tools and platforms that share and visualise IATI data. You can start by looking at your organisation’s data on IATI’s simple platform called <a href="http://d-portal.org/ctrack.html#view=search" >d-portal</a>. Within 24 hours of publishing your data, it will be displayed there. Simply search for your organisation in the “Publisher’ drop-down menu. And to see your data in a format that is used by governments and other data users, visit the <a href="https://countrydata.iatistandard.org/"> Country Development Finance Data </a>tool            
            </p>       
             <p class="my-2 text-base">
                See more information on <a href="https://iatistandard.org/en/iati-tools-and-resources/">IATI tools and resources</a>.

             </p>  
        </article>
        <article class="py-4 sm:py-6   ">
            <h3 class="font-bold text-2xl text-bluecoral ">
                8. Update and improve your data
            </h3>
            <p class="my-2 text-base">
                Once your organisation has published its first dataset, you are encouraged to <Strong>update and improve</strong> your data over time. You should update your data at least every quarter. You should also aim to expand the number of data fields that you provide information for. Read more about <a href="https://iatistandard.org/en/guidance/standard-overview/preparing-your-organisation-data-publication/key-qualities-of-iati-data/">improving the quality of IATI data</a>.
            </p>

        </article>
        <article class="py-4 sm:py-6">
            For more information about publishing IATI data please visit IATI’s main website: <a href="https://iatistandard.org/en/guidance/">iatistandard.org/guidance</a>.

        </article>
    </section>
  </div>
</div>

@endsection