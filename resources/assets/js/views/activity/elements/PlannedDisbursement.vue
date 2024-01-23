<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    class="elements-detail"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="category">
      <span>
        {{ types.budgetType[post.planned_disbursement_type] ?? 'Type Missing' }}
      </span>
    </div>

    <div class="mb-4 ml-5">
      <div class="category">
        <span>Value</span>
      </div>
      <table class="ml-5">
        <tbody>
          <tr>
            <td>Value Amount</td>
            <td>
              <ConditionalTextDisplay
                :condition="post.value[0].amount"
                :success-text="
                  Number(post.value[0].amount).toLocaleString() +
                  ' ' +
                  types.currency[post.value[0].currency]
                "
                failure-text="value amount"
              />
            </td>
          </tr>
          <tr>
            <td>Value Date</td>
            <td>
              <ConditionalTextDisplay
                :condition="post.value[0].value_date"
                :success-text="formatDate(post.value[0].value_date)"
                failure-text="value date"
              />
            </td>
          </tr>
          <tr>
            <td>Period Start</td>
            <td>
              <span>
                <ConditionalTextDisplay
                  :condition="post.period_start[0].date"
                  :success-text="formatDate(post.period_start[0].date)"
                  failure-text="period start"
                />
              </span>
            </td>
          </tr>
          <tr>
            <td>Period End</td>
            <td>
              <span>
                <ConditionalTextDisplay
                  :condition="post.period_end[0].date"
                  :success-text="formatDate(post.period_end[0].date)"
                  failure-text="period end"
                />
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-if="post.provider_org" class="mb-4 ml-5">
      <div class="category">
        <span>Provider org</span>
      </div>
      <table class="ml-5">
        <tbody>
          <tr>
            <td>Type</td>
            <td>
              <ConditionalTextDisplay
                :condition="post.provider_org[0].type"
                :success-text="
                  types.organizationType[post.provider_org[0].type]
                "
                failure-text="type"
              />
            </td>
          </tr>
          <tr>
            <td>Provider Activity ID</td>
            <td>
              <ConditionalTextDisplay
                :condition="post.provider_org[0].provider_activity_id"
                :success-text="post.provider_org[0].provider_activity_id"
                failure-text="provider activity id"
              />
            </td>
          </tr>
          <tr>
            <td>Reference</td>
            <td>
              <ConditionalTextDisplay
                :condition="post.provider_org[0].ref"
                :success-text="post.provider_org[0].ref"
                failure-text="reference"
              />
            </td>
          </tr>
          <tr>
            <td>Narrative</td>
            <td>
              <div
                v-for="(narrative, k) in post.provider_org[0].narrative"
                :key="k"
                class="description-content"
                :class="{
                  'mb-4': k !== post.provider_org[0].narrative.length - 1,
                }"
              >
                <div class="language mb-1.5">
                  (Language:<ConditionalTextDisplay
                    :condition="narrative.language"
                    :success-text="types.languages[narrative.language]"
                  />)
                </div>
                <div class="w-[500px] max-w-full">
                  <ConditionalTextDisplay
                    :condition="narrative.narrative"
                    :success-text="narrative.narrative"
                    failure-text="narrative"
                  />
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-if="post.receiver_org" class="ml-5">
      <div class="category">
        <span>Receiver org</span>
      </div>
      <table class="ml-5">
        <tbody>
          <tr>
            <td>Type</td>
            <td>
              <ConditionalTextDisplay
                :condition="post.receiver_org[0].type"
                :success-text="
                  types.organizationType[post.receiver_org[0].type]
                "
                failure-text="type"
              />
            </td>
          </tr>
          <tr>
            <td>Receiver Activity ID</td>
            <td>
              <ConditionalTextDisplay
                :condition="post.receiver_org[0].receiver_activity_id"
                :success-text="post.receiver_org[0].receiver_activity_id"
                failure-text="receiver activity id"
              />
            </td>
          </tr>
          <tr>
            <td>Reference</td>
            <td>
              <ConditionalTextDisplay
                :condition="post.receiver_org[0].ref"
                :success-text="post.receiver_org[0].ref"
                failure-text="reference"
              />
            </td>
          </tr>
          <tr>
            <td>Narrative</td>
            <td>
              <div
                v-for="(narrative, k) in post.receiver_org[0].narrative"
                :key="k"
                class="description-content"
                :class="{
                  'mb-4': k !== post.receiver_org[0].narrative.length - 1,
                }"
              >
                <div class="language mb-1.5">
                  (Language:<ConditionalTextDisplay
                    :condition="narrative.language"
                    :success-text="types.languages[narrative.language]"
                  />)
                </div>
                <div class="w-[500px] max-w-full">
                  <ConditionalTextDisplay
                    :condition="narrative.narrative"
                    :success-text="narrative.narrative"
                    failure-text="narrative"
                  />
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, inject } from 'vue';
import moment from 'moment';
import ConditionalTextDisplay from 'Components/ConditionalTextDisplay.vue';

defineProps({
  data: {
    type: Object,
    required: true,
  },
});

interface Types {
  budgetType: [];
  languages: [];
  currency: [];
  organizationType: [];
}

function formatDate(date: Date) {
  return moment(date).format('LL');
}

const types = inject('types') as Types;
</script>
