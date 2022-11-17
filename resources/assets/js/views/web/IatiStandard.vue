<template>
  <div class="smooth -mb-7 bg-[#e5e5e5] px-5 py-7 sm:px-10 sm:py-14 md:-mb-20">
    <div class="mx-auto max-w-[700px]">
      <section class="rounded bg-white py-4 shadow-textbox sm:py-8">
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <p class="text-base">
            IATI Standard The IATI Standard is a set of rules and guidance on
            how to publish useful development and humanitarian data. IATI
            Publisher will take you through all data fields (which are referred
            to as ‘elements’) of the IATI Standard, offering helpful
            explanations and links to further information and guidance. The IATI
            Standard requires organisations to publish two sets of data:
          </p>
        </article>
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <h3 class="my-2 text-2xl font-bold text-bluecoral">
            1. Organisation Data
          </h3>
          <p class="text-base">
            IATI Standard You will be asked to publish data about your entire
            organisation. This includes basic information about your
            organisation, such as your name and the type of organisation you
            are. You can also provide data on:
          </p>
          <ul class="mt-4 ml-4 list-disc text-base text-bluecoral">
            <li class="text-base">
              <span class="text-black"
                >Total spend by your organisation over the last year
              </span>
            </li>
            <li class="text-base">
              <span class="text-black"
                >Total annual planned budget for your organisation in each of
                the next three years, where available</span
              >
            </li>
            <li class="text-base">
              <span class="text-black"
                >Planned budgets broken down by individual recipient countries
                or regions</span
              >
            </li>
            <li class="text-base">
              <span class="text-black"
                >Run automatic checks (via the IATI Validator) for errors before
                publishing your data</span
              >
            </li>
            <li class="text-base">
              <span class="text-black"
                >Useful background documents, such as country action plans and
                annual reports
              </span>
            </li>
          </ul>
          <p class="mt-4 text-base">
            <a
              target="_blank"
              rel="noopener noreferrer"
              href="/organisation"
              @click="triggerModel"
              >Publish your Organisation Data</a
            >
          </p>
        </article>
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <h3 class="my-2 text-2xl font-bold text-bluecoral">
            2. Activity Data
          </h3>
          <p class="text-base">
            The IATI Standard also requires organisations to provide data about
            their development and humanitarian ‘activities’. For each activity,
            you can publish a wide range of information, including:
          </p>
          <ul class="my-4 ml-4 list-disc text-base text-bluecoral">
            <li class="text-base">
              <span class="text-black">
                <u>Basic information and identification </u>of the activity e.g.
                providing a title and a description for your activity
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                <u>Participating organisations</u> – information on which other
                organisations are involved in the activity
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                <u>Participating organisations</u> – information on which other
                organisations are involved in
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                <u>Financial data</u> – covers the budgets and the transactions
                for the activity
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                <u>Classifications</u> – helps categorise the activity using
                various development and humanitarian taxonomies. For example,
                what sector does the activity target or support (e.g. primary
                education or agriculture), or what type of aid is used to fund
                the activity (e.g. a grant or loan)
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                <u>Links to other data</u> that have already been published on
                the activity elsewhere
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                The <u>results</u> that the activity is aiming to achieve
              </span>
            </li>
          </ul>
          <h6 class="text-lg font-bold text-bluecoral">
            Publishing data at either Activity level or Transaction level
          </h6>

          <p class="my-4 text-base">
            As listed above, you will need to provide data on your activity’s
            transactions, which shows how the activity is being financed and how
            the finance is being used.
          </p>
          <p class="my-4 text-base">
            There are specific types of information that you can either publish
            about your entire activity, or about individual transactions (each
            transaction represents money flowing in or out of the activity). For
            example, you can publish data on which country/region your entire
            activity is benefitting, or you can publish data on which
            country/region each transaction is benefitting. However you must not
            publish this information at both activity and transaction levels.
          </p>
          <p class="my-4 text-base">
            IATI Publisher provides explanations for each element of the IATI
            Standard and tells you where you have a choice of which level to
            publish data for.
          </p>
          <p class="my-4 text-base">
            <a
              target="_blank"
              rel="noopener noreferrer"
              href="/organisation"
              @click="triggerModel"
              >Publish your Organisation Data</a
            >
          </p>
        </article>
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <h3 class="my-2 text-2xl font-bold text-bluecoral">
            Download PDF of IATI Standard data fields
          </h3>
          <p class="text-base">
            IATI Standard Whilst gathering and preparing your organisation’s
            IATI data, you may find it helpful to view the following
            spreadsheets that provide information on all of the data elements in
            the IATI Standard. You will also be able to view this information as
            you work your way through completing the forms for each element on
            IATI Publisher.
          </p>
          <a target="_blank" rel="noopener noreferrer" class="my-2">
            [IATI Organisation Standard data PDF]
          </a>
          <br />
          <a target="_blank" rel="noopener noreferrer" class="my-2">
            [IATI Activity Standard data PDF]
          </a>
        </article>
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <h3 class="my-2 text-2xl font-bold text-bluecoral">
            IATI Standard reference
          </h3>
          <p class="text-base">
            You can look up detailed and technical information about each
            element of the IATI Standard on the IATI Reference section of IATI’s
            main website:
          </p>
          <a
            target="_blank"
            rel="noopener noreferrer"
            href="https://iatistandard.org/en/iati-standard/203/activity-standard/"
            class="my-2"
          >
            <u>Activity Standard</u> </a
          ><br />
          <a
            target="_blank"
            rel="noopener noreferrer"
            href="https://iatistandard.org/en/iati-standard/203/organisation-standard/"
            class="my-2"
          >
            <u> Organisation Standard</u>
          </a>
        </article>
      </section>
    </div>
  </div>
</template>
<script lang="ts" setup>
function triggerModel() {
  localStorage.setItem('openAddModel', 'true');
}
</script>
