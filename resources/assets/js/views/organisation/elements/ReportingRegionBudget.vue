<template>
  <div
    v-for="(recipient_region_budget, index) in content"
    :key="index"
    :class="{
      'mb-4 border-b border-n-20 pb-4': Number(index) != content.length - 1,
    }"
  >
    <div class="elements-detail mb-4">
      <div class="category flex">
        {{
          recipient_region_budget.status
            ? types?.budgetType[recipient_region_budget.status]
            : 'Status Missing'
        }}
      </div>
      <div class="flex text-sm">
        <span v-if="recipient_region_budget.value[0].amount">
          {{
            Number(recipient_region_budget.value['0'].amount).toLocaleString()
          }}
          {{ recipient_region_budget.value['0'].currency }}
        </span>
        <span v-else> Budget Amount Missing</span>
      </div>
      <div class="ml-4">
        <table>
          <tbody>
            <tr>
              <td>Value date</td>
              <td>
                <ConditionalTextDisplay
                  :condition="recipient_region_budget.value['0'].value_date"
                  :success-text="
                    formatDate(recipient_region_budget.value['0'].value_date)
                  "
                  failure-text="value date"
                />
                {{}}
              </td>
            </tr>
            <tr>
              <td>Vocabulary</td>
              <td>
                <ConditionalTextDisplay
                  :condition="
                    types?.regionVocabulary[
                      recipient_region_budget.recipient_region['0']
                        .region_vocabulary
                    ]
                  "
                  :success-text="
                    types.regionVocabulary[
                      recipient_region_budget.recipient_region['0']
                        .region_vocabulary
                    ]
                  "
                  failure-text="vocabulary"
                />
              </td>
            </tr>
            <tr
              v-if="
                recipient_region_budget.recipient_region['0']
                  .region_vocabulary === '99'
              "
            >
              <td>Vocabulary URI</td>
              <td
                v-if="
                  recipient_region_budget.recipient_region['0'].vocabulary_uri
                "
              >
                <a
                  target="_blank"
                  :href="
                    recipient_region_budget.recipient_region['0'].vocabulary_uri
                  "
                  >{{
                    recipient_region_budget.recipient_region['0'].vocabulary_uri
                  }}</a
                >
              </td>
              <td v-else>Vocabulary URI Missing</td>
            </tr>
            <tr>
              <td>Code</td>
              <td>
                <template
                  v-if="
                    recipient_region_budget.recipient_region['0']
                      .region_vocabulary === '1'
                  "
                >
                  <ConditionalTextDisplay
                    :condition="
                      types.region[
                        recipient_region_budget.recipient_region['0']
                          .region_code
                      ]
                    "
                    :success-text="
                      types.region[
                        recipient_region_budget.recipient_region['0']
                          .region_code
                      ]
                    "
                    failure-text="code"
                  />
                </template>
                <template v-else>
                  <ConditionalTextDisplay
                    :condition="
                      recipient_region_budget.recipient_region['0'].code
                    "
                    :success-text="
                      recipient_region_budget.recipient_region['0'].code
                    "
                    failure-text="code"
                  />
                </template>
              </td>
            </tr>
            <tr>
              <td>Narrative</td>
              <td>
                <div
                  v-for="(narrative, i) in recipient_region_budget
                    .recipient_region['0'].narrative"
                  :key="i"
                  class="item"
                  :class="{
                    'mb-4':
                      i !=
                      recipient_region_budget.recipient_region['0'].narrative
                        .length -
                        1,
                  }"
                >
                  <div class="description-content">
                    <div class="language mb-1.5">
                      (Language:
                      <ConditionalTextDisplay
                        :condition="narrative.language && types.languages"
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
                </div>
              </td>
            </tr>
            <tr>
              <td>Period</td>
              <td>
                <div>
                  <ConditionalTextDisplay
                    :condition="recipient_region_budget.period_start['0'].date"
                    :success-text="
                      formatDate(recipient_region_budget.period_start['0'].date)
                    "
                    failure-text="date"
                  />
                  -
                  <ConditionalTextDisplay
                    :condition="recipient_region_budget.period_end['0'].date"
                    :success-text="
                      formatDate(recipient_region_budget.period_end['0'].date)
                    "
                    failure-text="date"
                  />
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="indicator overflow-hidden rounded-t-lg border border-n-20">
      <div class="head flex items-center border-b border-n-20 px-6 py-2">
        <span class="text-xs font-bold text-n-50">Budget line</span>
      </div>
      <div
        v-for="(budget_line, j) in recipient_region_budget.budget_line"
        :key="j"
        class="item"
        :class="{
          'mb-2 border-b border-n-20':
            j !== recipient_region_budget.budget_line.length - 1,
        }"
      >
        <div class="indicator-content flex px-6 py-2">
          <div class="elements-detail grow">
            <div class="category flex">
              <span>
                <ConditionalTextDisplay
                  :condition="budget_line.value['0'].amount"
                  :success-text="
                    Number(budget_line.value[0].amount).toLocaleString()
                  "
                  failure-text="budget"
                />
                {{ budget_line.value['0'].currency }}
              </span>
            </div>
            <div class="ml-4">
              <table>
                <tbody>
                  <tr>
                    <td class="pr-20 text-n-40">Reference</td>
                    <td>
                      <ConditionalTextDisplay
                        :condition="budget_line.ref"
                        :success-text="budget_line.ref"
                        failure-text="reference"
                      />
                    </td>
                  </tr>
                  <tr>
                    <td>Value Date</td>
                    <td>
                      <ConditionalTextDisplay
                        :condition="budget_line.value['0'].value_date"
                        :success-text="
                          formatDate(budget_line.value['0'].value_date)
                        "
                        failure-text="date"
                      />
                    </td>
                  </tr>
                  <tr>
                    <td>Narrative</td>
                    <td>
                      <div
                        v-for="(narrative, k) in budget_line.narrative"
                        :key="k"
                        class="description-content"
                        :class="{
                          'mb-4': k != budget_line.narrative.length - 1,
                        }"
                      >
                        <div class="language mb-1.5">
                          (Language:
                          <ConditionalTextDisplay
                            :condition="types.languages && narrative.language"
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
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, inject } from 'vue';
import moment from 'moment';
import ConditionalTextDisplay from 'Components/ConditionalTextDisplay.vue';

defineProps({
  content: { type: Object, required: true },
});

interface TypesInterface {
  languages: [];
  budgetType: [];
  regionVocabulary: [];
  region: [];
}

const types = inject('orgTypes') as TypesInterface;

function formatDate(date: Date) {
  return moment(date).format('LL');
}
</script>
