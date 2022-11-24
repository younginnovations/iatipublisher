<template>
  <div class="activities__content--element px-3 py-3" :class="layout">
    <div class="rounded-lg bg-white p-4">
      <div class="mb-4 flex">
        <div :id="title" class="title flex grow text-n-50">
          <template v-if="title === 'name'">
            <svg-vue
              class="mr-1.5 text-xl text-bluecoral"
              icon="organisation-elements/building"
            ></svg-vue>
          </template>
          <template v-else-if="title === 'reporting_org'">
            <svg-vue
              class="mr-1.5 text-xl text-bluecoral"
              icon="organisation-elements/reporting_org"
            ></svg-vue>
          </template>
          <template v-else-if="title === 'recipient_org_budget'">
            <svg-vue
              class="mr-1.5 text-xl text-bluecoral"
              icon="organisation-elements/recipient_org_budget"
            ></svg-vue>
          </template>
          <template v-else>
            <svg-vue
              :icon="'organisation-elements/' + title"
              class="mr-1.5 text-xl text-bluecoral"
            ></svg-vue>
          </template>
          <div class="title text-sm font-bold">
            {{ replaceUnderscore(title) }}
          </div>
          <div
            class="status ml-2.5 flex text-xs leading-5"
            :class="{
              'text-spring-50': status,
              'text-crimson-50': !status,
            }"
          >
            <b class="mr-2 text-base leading-3">.</b>
            <span v-if="status">completed</span>
            <span v-else>not completed</span>
          </div>
        </div>
        <div class="icons flex flex-row-reverse items-center">
          <a
            class="edit-button mr-2.5 flex items-center text-xs font-bold uppercase"
            :href="'/organisation/' + title"
          >
            <svg-vue class="mr-0.5 text-base" icon="edit"></svg-vue>
            <span>Edit</span>
          </a>

          <HoverText
            v-if="tooltip"
            :name="title.toString().replace(/_/g, '-')"
            :hover-text="tooltip"
            :show-iati-reference="true"
            class="text-n-40"
          ></HoverText
          ><svg-vue
            v-if="orgMandatoryElements().includes(title)"
            class="mr-1.5"
            icon="core"
          ></svg-vue>
        </div>
      </div>
      <div class="divider mb-4 h-px w-full bg-n-20"></div>
      <div class="text-sm text-n-50">
        <!-- iati_organizational_identifier -->
        <div v-if="title == 'organisation_identifier'">
          {{ content }}
        </div>

        <!-- name -->
        <div v-if="title == 'name'">
          <div v-for="(post, i) in data.content" :key="i" class="title-content">
            <div v-if="post.narrative" class="flex flex-col">
              <span v-if="post.language" class="language mb-1.5">
                (Language: {{ types?.languages[post.language] }})
              </span>
              <span v-if="post.narrative" class="max-w-[887px] text-sm">
                {{ post.narrative }}
              </span>
            </div>
            <span v-else class="text-sm italic">Title Missing</span>
            <div v-if="i !== data.content.length - 1" class="mb-4"></div>
          </div>
        </div>
        <!-- name ends -->

        <div v-if="title == 'reporting_org'">
          <ReportingOrganisation :content="content" />
        </div>

        <div v-if="title == 'total_budget'">
          <TotalBudget :content="content" />
        </div>

        <div v-if="title == 'recipient_org_budget'">
          <ReportingOrgBudget :content="content" />
        </div>

        <div v-if="title == 'recipient_region_budget'">
          <ReportingRegionBudget :content="content" />
        </div>

        <div v-if="title == 'recipient_country_budget'">
          <RecipientCountryBudget :content="content" />
        </div>

        <div v-if="title == 'total_expenditure'">
          <TotalExpenditure :content="content" />
        </div>

        <!-- document link -->
        <div v-if="title == 'document_link'" class="document-link text-xs">
          <DocumentLink :content="content" />
        </div>
        <!-- document link ends -->
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, provide } from 'vue';
import HoverText from 'Components/HoverText.vue';
import { orgMandatoryElements } from 'Composable/coreElements';

import {
  ReportingOrganisation,
  TotalBudget,
  ReportingOrgBudget,
  ReportingRegionBudget,
  RecipientCountryBudget,
  TotalExpenditure,
  DocumentLink,
} from 'Organisation/elements/Index';

const props = defineProps({
  data: {
    type: Object,
    required: true,
  },
  title: {
    type: String,
    required: true,
  },
  tooltip: {
    type: String,
    required: true,
  },
  content: {
    type: Object || Array,
    required: true,
  },
  language: {
    type: String,
    required: false,
    default: 'en',
  },
  width: {
    type: String,
    required: false,
    default: '',
  },
  types: {
    type: Object,
    required: true,
  },
  status: {
    type: Boolean,
    required: true,
  },
});

// const status = '';

let layout = 'basis-6/12';
if (props.width === 'full') {
  layout = 'basis-full';
}

provide('orgTypes', props.types);

const replaceUnderscore = (string) => {
  let regex = /_/g;
  let result = string.replace(regex, '-');
  return result;
};
</script>
