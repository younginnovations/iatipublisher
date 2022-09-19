<template>
  <div :class="layout" class="p-3 activities__content--element text-n-50">
    <div :id="title" class="p-4 bg-white rounded-lg">
      <div class="flex mb-4">
        <div class="flex title grow">
          <template
            v-if="
              title === 'reporting_org' ||
              title === 'default_tied_status' ||
              title === 'crs_add' ||
              title === 'fss'
            "
          >
            <svg-vue class="elements-svg" icon="activity-elements/building" />
          </template>

          <template v-else-if="title === 'iati_identifier'">
            <svg-vue
              class="elements-svg"
              icon="activity-elements/iati_identifier"
            />
          </template>

          <template v-else>
            <svg-vue
              :icon="'activity-elements/' + title"
              class="elements-svg"
            ></svg-vue>
          </template>

          <div class="text-sm font-bold title">
            {{ title.toString().replace(/_/g, '-') }}
          </div>

          <Status :data="completed" />
        </div>

        <div class="flex items-center icons">
          <template v-if="title == 'transactions'">
            <Btn
              text="Add Transaction"
              icon="add"
              :link="`/activity/${activityId}/transaction/create`"
              class="mr-2.5"
            />
            <Btn
              text="Show full transaction list"
              icon=""
              design="bgText"
              :link="`/activity/${activityId}/transaction`"
              class="mr-2.5"
            />
          </template>
          <div v-else>
            <Btn
              text="Edit"
              :link="`/activity/${activityId}/${title}`"
              class="edit-button mr-2.5"
            />
          </div>
          <svg-vue v-if="activityCoreElements().includes(title)" class="mr-1.5" icon="core"></svg-vue>
          <HoverText v-if="tooltip" :name="title.toString().replace(/_/g, '-')" :hover-text="tooltip" :show-iati-reference="true" class="text-n-40" />
        </div>
      </div>

      <div class="w-full h-px mb-4 divider bg-n-20"></div>

      <template v-if="title === 'iati_identifier'">
        <IatiIdentifier :data="data.content.iati_identifier_text" />
      </template>

      <template v-else-if="title === 'other_identifier'">
        <OtherIdentifier :data="data" />
      </template>

      <template v-else-if="title === 'title'">
        <TitleElement :data="data" />
      </template>

      <template v-else-if="title === 'description'">
        <Description :data="data.content" />
      </template>

      <template v-else-if="title === 'activity_date'">
        <ActivityDate :data="data.content" />
      </template>

      <template v-else-if="title === 'contact_info'">
        <ContactInfo :data="data.content" />
      </template>

      <template v-else-if="title === 'participating_org'">
        <ParticipatingOrg :data="data.content" />
      </template>

      <template v-else-if="title === 'recipient_country'">
        <RecipientCountry :data="data.content" />
      </template>

      <template v-else-if="title === 'recipient_region'">
        <RecipientRegion :data="data.content" />
      </template>

      <template v-else-if="title === 'location'">
        <Location :data="data.content" />
      </template>

      <template v-else-if="title === 'sector'">
        <Sector :data="data.content" />
      </template>

      <template v-else-if="title === 'policy_marker'">
        <PolicyMarker :data="data.content" />
      </template>

      <template v-else-if="title === 'tag'">
        <Tag :data="data.content" />
      </template>

      <!-- Default Aid Type -->
      <template v-else-if="title === 'default_aid_type'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="default_aid_type"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="default_aid_type-content">
            <div class="mb-2 text-sm font-bold date-type">
              <span v-if="post.default_aid_type_vocabulary">{{
                types.aidTypeVocabulary[post.default_aid_type_vocabulary]
              }}</span>
              <span v-else class="italic">Vocabulary Not Available</span>
            </div>

            <div
              v-if="post.default_aid_type_vocabulary === '2'"
              class="text-sm"
            >
              <span v-if="post.earmarking_category">{{
                types.earmarkingCategory[post.earmarking_category]
              }}</span>
              <span v-else class="italic">Code Not Available</span>
            </div>

            <div
              v-else-if="post.default_aid_type_vocabulary === '3'"
              class="text-sm"
            >
              <span v-if="post.earmarking_modality">{{
                types.earmarkingModality[post.earmarking_modality]
              }}</span>
              <span v-else class="italic">Code Not Available</span>
            </div>

            <div
              v-else-if="post.default_aid_type_vocabulary === '4'"
              class="text-sm"
            >
              <span v-if="post.cash_and_voucher_modalities">{{
                types.cashandVoucherModalities[post.cash_and_voucher_modalities]
              }}</span>
              <span v-else class="italic">Code Not Available</span>
            </div>

            <div v-else class="max-w-[887px] text-sm">
              <span v-if="post.default_aid_type">{{
                types.aidType[post.default_aid_type]
              }}</span>
              <span v-else class="italic">Code Not Available</span>
            </div>
          </div>
        </div>
      </template>

      <!-- Country Budget Items -->
      <template v-else-if="title === 'country_budget_items'">
        <div
          v-for="(post, key) in data.content.budget_item"
          :key="key"
          class="elements-detail"
          :class="{ 'mb-4': key !== data.content.budget_item.length - 1 }"
        >
          <div
            v-if="data.content.country_budget_vocabulary === '1'"
            class="text-sm"
          >
            <div v-if="post.code" class="flex space-x-1">
              <span>
                {{ types.budgetIdentifier[post.code] }}
              </span>
              <span>({{ roundFloat(post.percentage) }}%)</span>
            </div>
            <span v-else class="italic">Not Available</span>
          </div>
          <div v-else class="text-sm">
            <span v-if="post.code">{{
              types.budgetIdentifier[post.code]
            }}</span>
            <span v-else class="italic">Not Available</span>
            <span v-if="post.code"> ({{ roundFloat(post.percentage) }} %)</span>
            <span v-else class="italic">Not Available</span>
          </div>
          <template v-for="(item, i) in post.description" :key="i">
            <div
              v-for="(narrative, k) in item.narrative"
              :key="k"
              class="ml-5 elements-detail"
              :class="{ 'mb-0': k !== item.narrative - 1 }"
            >
              <table>
                <tr class="multiline">
                  <td>Vocabulary</td>
                  <td>
                    <span v-if="data.content.country_budget_vocabulary">{{
                      props.types.budgetIdentifierVocabulary[
                        data.content.country_budget_vocabulary
                      ]
                    }}</span>
                    <span v-else class="italic">Not Available</span>
                  </td>
                </tr>
                <tr class="multiline">
                  <td>Description</td>
                  <td>
                    <div v-if="narrative.narrative" class="flex flex-col">
                      <span v-if="narrative.language" class="language top"
                        >(Language:
                        {{ types.languages[narrative.language] }})</span
                      >
                      <span>{{ narrative.narrative }}</span>
                    </div>
                    <span v-else class="italic">Not Available</span>
                  </td>
                </tr>
              </table>
            </div>
          </template>
        </div>
      </template>

      <!-- Humanitarian Scope -->
      <template v-else-if="title === 'humanitarian_scope'">
        <HumanitarianScope :data="data.content" />
      </template>

      <!-- Budget -->
      <template v-else-if="title === 'budget'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="elements-detail"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="category">
            <span v-if="post.budget_type">{{
              types.budgetType[post.budget_type]
            }}</span>
            <span v-else class="italic">Type Not Available</span>
          </div>

          <div
            v-for="(item, i) in post.budget_value"
            :key="i"
            class="mb-1 elements-detail"
            :class="{ 'mb-4': i !== post.budget_value.length - 1 }"
          >
            <div class="text-sm">
              <div v-if="item.amount" class="value">
                <span>{{ item.amount }}</span>
                <span>{{ item.currency }}</span>
                <span v-if="item.value_date"
                  >(Valued at {{ formatDate(item.value_date) }})</span
                >
              </div>
              <span v-else class="italic">Budget Value Not Available</span>
            </div>
          </div>
          <div class="ml-5">
            <div
              v-for="(item, i) in post.period_start"
              :key="i"
              :class="{ 'mb-4': i !== post.period_start.length - 1 }"
            >
              <table>
                <tr>
                  <td>Period Start</td>
                  <td v-if="item.date">{{ formatDate(item.date) }}</td>
                  <td v-else class="italic">Not Available</td>
                </tr>
              </table>
            </div>
            <div
              v-for="(item, i) in post.period_end"
              :key="i"
              :class="{ 'mb-4': i !== post.period_end.length - 1 }"
            >
              <table>
                <tr>
                  <td>Period end</td>
                  <td v-if="item.date">{{ formatDate(item.date) }}</td>
                  <td v-else class="italic">Not Available</td>
                </tr>
              </table>
            </div>
            <table>
              <tr>
                <td>Status</td>
                <td>
                  <span v-if="post.budget_status">{{
                    types.budgetStatus[post.budget_status]
                  }}</span>
                  <span v-else class="italic">Not Available</span>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </template>

      <!-- Planned Disbursement -->
      <template v-else-if="title === 'planned_disbursement'">
        <PlannedDisbursement :data="data.content" />
      </template>

      <!-- Document Link -->
      <template v-else-if="title === 'document_link'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="elements-detail"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div>
            <div v-if="post.url" class="max-w-[887px] text-sm">
              <a :href="post.url" target="_blank">{{ post.url }}</a>
            </div>
            <span v-else class="italic">URL Not Available</span>
          </div>
          <div class="ml-5">
            <div>
              <div v-for="(language, i) in post.language" :key="i">
                <table>
                  <tr>
                    <td>Language</td>
                    <td>
                      <span v-if="language.code">{{
                        types.languages[language.code]
                      }}</span>
                      <span v-else class="italic">Not Available</span>
                    </td>
                  </tr>
                </table>
              </div>
              <div v-for="(document_date, i) in post.document_date" :key="i">
                <table>
                  <tr>
                    <td>Date</td>
                    <td>
                      <span v-if="document_date.date">{{
                        formatDate(document_date.date)
                      }}</span>
                      <span v-else class="italic">Not Available</span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <div v-for="(item, i) in post.title" :key="i">
              <div
                v-for="(narrative, j) in item.narrative"
                :key="j"
                class="flex items-center mb-1 space-x-1"
              >
                <table>
                  <tr class="multiline">
                    <td>Title</td>
                    <td>
                      <span v-if="narrative.language" class="language">
                        ({{ types.languages[narrative.language] }})
                      </span>
                      <div v-if="narrative.narrative" class="flex flex-col">
                        <span>
                          {{ narrative.narrative }}
                        </span>
                      </div>
                      <span v-else class="italic">Not Available</span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <div v-for="(category, i) in post.category" :key="i">
              <table>
                <tr>
                  <td>Category</td>
                  <td>
                    <span v-if="category.code">{{
                      types.documentCategory[category.code]
                    }}</span>
                    <span v-else class="italic">Not Available</span>
                  </td>
                </tr>
              </table>
            </div>
            <table>
              <tr>
                <td>Format</td>
                <td v-if="post.format">{{ post.format }}</td>
                <td v-else class="italic">Not Available</td>
              </tr>
            </table>
            <div v-for="(description, i) in post.description" :key="i">
              <div v-for="(narrative, j) in description.narrative" :key="j">
                <table>
                  <tr class="multiline">
                    <td>Description</td>
                    <td>
                      <div v-if="narrative.narrative" class="flex flex-col">
                        <span v-if="narrative.language" class="language"
                          >(Language:
                          {{ types.languages[narrative.language] }})</span
                        >
                        <span>{{ narrative.narrative }}</span>
                      </div>
                      <span v-else class="italic">Not Available</span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'related_activity'">
        <RelatedActivity :data="data.content" />
      </template>

      <template v-else-if="title === 'legacy_data'">
        <LegacyData :data="data.content" />
      </template>

      <template v-else-if="title === 'conditions'">
        <Conditions :data="data.content" />
      </template>

      <template v-else-if="title === 'transactions'">
        <Transactions :data="data.content" />
      </template>

      <template v-else>
        <!-- Activity Status -->
        <div class="text-sm content">
          <template v-if="title === 'activity_status'">
            <span v-if="data.content">{{
              props.types.activityStatus[data.content]
            }}</span>
            <span v-else class="italic">Not Available</span>
          </template>

          <!-- Activity Scope -->
          <template v-else-if="title === 'activity_scope'">
            <span v-if="data.content">{{
              props.types.activityScope[data.content]
            }}</span>
            <span v-else class="italic">Not Available</span>
          </template>

          <!-- Collaboration Type -->
          <template v-else-if="title === 'collaboration_type'">
            <span v-if="data.content">{{
              props.types.collaborationType[data.content]
            }}</span>
            <span v-else class="italic">Not Available</span>
          </template>

          <!-- Default Flow Type -->
          <template v-else-if="title === 'default_flow_type'">
            <span v-if="data.content">{{
              props.types.flowType[data.content]
            }}</span>
            <span v-else class="italic">Not Available</span>
          </template>

          <!-- Default Tied Status -->
          <template v-else-if="title === 'default_tied_status'">
            <span v-if="data.content">{{
              props.types.tiedStatus[data.content]
            }}</span>
            <span v-else class="italic">Not Available</span>
          </template>

          <!-- Capital Spend -->
          <template v-else-if="title === 'capital_spend'">
            <span v-if="data.content.toString()"
              >{{ data.content.toString() }}%</span
            >
            <span v-else class="italic">Not Available</span>
          </template>

          <!-- Default Finance Type -->
          <template v-else-if="title === 'default_finance_type'">
            <span v-if="data.content">
              {{ props.types.financeType[data.content] }}</span
            >
            <span v-else class="italic">Not Available</span>
          </template>

          <template v-else>
            <span>No content</span>
          </template>
        </div>
      </template>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import moment from 'moment';

import {activityCoreElements} from 'Composable/coreElements';

//components
import {
  IatiIdentifier,
  OtherIdentifier,
  TitleElement,
  Description,
  ActivityDate,
  ContactInfo,
  ParticipatingOrg,
  RecipientCountry,
  RecipientRegion,
  Transactions,
  Location,
  Sector,
  LegacyData,
  Conditions,
  RelatedActivity,
  PolicyMarker,
  Tag,
  HumanitarianScope,
  PlannedDisbursement,
} from 'Activity/elements/Index';

import Btn from 'Components/buttons/Link.vue';
import Status from 'Components/status/ElementStatus.vue';
import HoverText from 'Components/HoverText.vue';

const props = defineProps({
  data: {
    type: Object,
    required: true,
  },
  activityId: {
    type: Number,
    required: true,
  },
  title: {
    type: String,
    required: true,
  },
  tooltip: {
    type: String,
    required: false,
    default: '',
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
  completed: {
    type: Boolean,
    required: true,
  },
});

let layout = 'basis-6/12';
if (props.width === 'full') {
  layout = 'basis-full';
}

function formatDate(date: Date) {
  return moment(date).format('LL');
}

function roundFloat(num: string) {
  return parseFloat(num).toFixed(2);
}
</script>
