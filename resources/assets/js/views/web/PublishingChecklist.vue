<template>
  <div class="smooth -mb-7 bg-[#e5e5e5] px-5 py-7 sm:px-10 sm:py-14 md:-mb-20">
    <div class="mx-auto max-w-[700px]">
      <section class="rounded bg-white px-6 py-4 shadow-textbox sm:px-12 sm:py-8">
        <h3 class="text-lg font-bold text-bluecoral">
          {{language.web_lang.publishing_checklist_page.organisations_using_iati_label}}
        </h3>
        <article class="py-4 sm:py-6">
          <h3 class="py-2 text-2xl font-bold text-bluecoral">
            1. {{ language.web_lang.publishing_checklist_page.register_a_publisher_header }}
          </h3>
          <p class="my-2 text-base">
            {{language.web_lang.publishing_checklist_page.register_a_publisher_description.one }}
          </p>
          <a target="_blank" href="https://www.iatiregistry.org/register_publisher/">
            {{ language.web_lang.publishing_checklist_page.register_a_publisher_description.two }}
          </a>
          <p class="my-2 text-base">
            {{ language.web_lang.publishing_checklist_page.register_a_publisher_description.three }}
          </p>
          <a target="_blank" href="/register">
            {{ language.web_lang.publishing_checklist_page.register_a_publisher_description.four }}
          </a>
        </article>
        <article class="py-4 sm:py-6">
          <h3 class="py-2 text-2xl font-bold text-bluecoral">
            2. {{ language.web_lang.publishing_checklist_page.publish_your_organisation_header }}

          </h3>
          <p class="my-2 text-base">
            {{language.web_lang.publishing_checklist_page.publish_your_organisation_description.one}}
          </p>
          <p class="my-2 text-base">
            {{ language.web_lang.publishing_checklist_page.publish_your_organisation_description.two }}
          </p>
          <a target="_blank" href="/iati-standard">
            {{ language.web_lang.publishing_checklist_page.publish_your_organisation_description.three }}
          </a>
          <br />
          <a target="_blank" href="/activities" @click="triggerModel">
            {{ language.web_lang.publishing_checklist_page.publish_your_organisation_description.four }}
          </a>
        </article>
        <article class="py-4 sm:py-6">
          <h3 class="py-2 text-2xl font-bold text-bluecoral">
            3. {{ language.web_lang.publishing_checklist_page.publish_your_activity_header }}
          </h3>
          <p class="my-2 text-base">
            {{ language.web_lang.publishing_checklist_page.publish_your_activity_description.one }}
          </p>
          <p class="mt-2 text-base">
            {{ language.web_lang.publishing_checklist_page.publish_your_activity_description.two.list_items.header }}
          </p>
          <ul class="mt-4 ml-4 list-disc text-base text-bluecoral">
            <li class="text-base">
              <span class="text-black">
                {{ language.web_lang.publishing_checklist_page.publish_your_activity_description.two.list_items.one }}
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                {{ language.web_lang.publishing_checklist_page.publish_your_activity_description.two.list_items.two }}
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                {{ language.web_lang.publishing_checklist_page.publish_your_activity_description.two.list_items.three }}
              </span>
            </li>
          </ul>
          <p class="mt-2 text-base">
            {{ language.web_lang.publishing_checklist_page.publish_your_activity_description.three.list_items.header }}
          </p>
          <ul class="mt-4 ml-4 list-disc text-base text-bluecoral">
            <li class="text-base">
              <span class="text-black">
                {{ language.web_lang.publishing_checklist_page.publish_your_activity_description.three.list_items.one }}
              </span
              >
            </li>
            <li class="text-base">
              <span class="text-black">
                {{ language.web_lang.publishing_checklist_page.publish_your_activity_description.three.list_items.two }}
              </span>
            </li>
          </ul>
          <p class="my-2 text-base">
            {{ language.web_lang.publishing_checklist_page.publish_your_activity_description.four }}
          </p>

          <a target="_blank" href="/iati-standard">
            {{ language.web_lang.publishing_checklist_page.publish_your_activity_description.five }}
          </a>
          <br />
          <a target="_blank" href="/activities" @click="triggerModel">
            {{ language.web_lang.publishing_checklist_page.publish_your_activity_description.six }}
          </a>
        </article>
        <article class="py-4 sm:py-6">
          <h3 class="py-2 text-2xl font-bold text-bluecoral">
            4. {{ language.web_lang.publishing_checklist_page.understand_further_data_header }}
          </h3>
          <p class="my-2 text-base">
            <span v-html=language.web_lang.publishing_checklist_page.understand_further_data_description.one></span>
          </p>
          <p class="my-2 text-base">
            <span v-html=language.web_lang.publishing_checklist_page.understand_further_data_description.two></span>
          </p>
        </article>
        <article class="py-4 sm:py-6">
          <h3 class="py-2 text-2xl font-bold text-bluecoral">
            5. {{ language.web_lang.publishing_checklist_page.run_automatic_checks_header }}
          </h3>
          <p class="my-2 text-base">
            {{ language.web_lang.publishing_checklist_page.run_automatic_checks_description.one }}
          </p>
        </article>
        <article class="py-4 sm:py-6">
          <h3 class="py-2 text-2xl font-bold text-bluecoral">
            6. {{ language.web_lang.publishing_checklist_page.publish_your_data_header }}
          </h3>
          <p class="my-2 text-base">
            {{ language.web_lang.publishing_checklist_page.publish_your_data_description.one }}
          </p>
          <p class="my-2 text-base">
            {{ language.web_lang.publishing_checklist_page.publish_your_data_description.two }}
            <br />
            <a target="_blank" href="https://iatiregistry.org/publisher/">
              https://iatiregistry.org/publisher/
            </a>
            .
          </p>
        </article>
        <article class="py-4 sm:py-6">
          <h3 class="py-2 text-2xl font-bold text-bluecoral">7. {{ language.web_lang.publishing_checklist_page.access_your_data_header }}</h3>
          <p class="my-2 text-base">
            <span v-html=language.web_lang.publishing_checklist_page.access_your_data_description.one></span>
          </p>
          <p class="my-2 text-base">
            <span v-html=language.web_lang.publishing_checklist_page.access_your_data_description.two></span>
          </p>
          <p class="my-2 text-base">
            <span v-html=language.web_lang.publishing_checklist_page.access_your_data_description.three></span>
          </p>
        </article>
        <article class="py-4 sm:py-6">
          <h3 class="py-2 text-2xl font-bold text-bluecoral">
            8. <span v-html=language.web_lang.publishing_checklist_page.update_and_improve_header></span>
          </h3>
          <p class="my-2 text-base">
            <span v-html=language.web_lang.publishing_checklist_page.update_and_improve_description.one></span>
          </p>
        </article>
        <article class="py-4 sm:py-6">
          <span v-html=language.web_lang.publishing_checklist_page.update_and_improve_description.two></span>
        </article>
      </section>
    </div>
  </div>
</template>
<script lang="ts" setup>
function triggerModel() {
  localStorage.setItem('openAddModel', 'true');
}
const language = window["global_lang"];
</script>
