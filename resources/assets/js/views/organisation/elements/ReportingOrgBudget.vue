<template>
  <div
    v-for="(recipient_org_budget, index) in content"
    :key="index"
    class="item"
    :class="{
      'mb-4 border-b border-n-20 pb-4': Number(index) != content.length - 1,
    }"
  >
    <div class="elements-detail mb-4">
      <div class="category flex">
        {{
          recipient_org_budget.status
            ? types?.budgetType[recipient_org_budget.status]
            : 'Status Missing'
        }}
      </div>
      <div class="flex text-sm">
        <span v-if="recipient_org_budget.value[0].amount">
          {{ Number(recipient_org_budget.value['0'].amount).toLocaleString() }}
          {{ recipient_org_budget.value['0'].currency }}
        </span>
        <span v-else> Budget Amount Missing</span>
      </div>
    </div>
    <div class="elements-detail mb-4">
      <div
        v-for="(
          recipient_org, recipient_org_index
        ) in recipient_org_budget.recipient_org"
        :key="recipient_org_index"
        class="item"
        :class="{
          'mb-4':
            recipient_org_index !=
            recipient_org_budget.recipient_org.length - 1,
        }"
      >
        <table>
          <tr>
            <td>Recipient Org</td>
            <td>
              <ConditionalTextDisplay
                :condition="recipient_org.ref"
                :success-text="recipient_org.ref"
                failure-text="reference"
              />
              <div
                v-for="(narrative, narrative_index) in recipient_org.narrative"
                :key="narrative_index"
                class="item"
                :class="{
                  'mb-4': narrative_index != recipient_org.narrative.length - 1,
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
            <td>Value Date</td>
            <td>
              <ConditionalTextDisplay
                :condition="recipient_org_budget.value['0'].value_date"
                :success-text="
                  formatDate(recipient_org_budget.value['0'].value_date)
                "
                failure-text="value date"
              />
            </td>
          </tr>
          <tr>
            <td>Period</td>
            <td>
              <div>
                <ConditionalTextDisplay
                  :condition="recipient_org_budget.period_start['0'].date"
                  :success-text="
                    formatDate(recipient_org_budget.period_start['0'].date)
                  "
                  failure-text="period start"
                />
                -
                <ConditionalTextDisplay
                  :condition="recipient_org_budget.period_end['0'].date"
                  :success-text="
                    formatDate(recipient_org_budget.period_end['0'].date)
                  "
                  failure-text="period end"
                />
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div class="indicator overflow-hidden rounded-t-lg border border-n-20">
      <div class="head flex items-center border-b border-n-20 px-6 py-2">
        <span class="text-xs font-bold text-n-50">budget line</span>
      </div>
      <div
        v-for="(budget_line, j) in recipient_org_budget.budget_line"
        :key="j"
        :class="{
          'mb-2 border-b border-n-20':
            j !== recipient_org_budget.budget_line.length - 1,
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
                    <td>Reference</td>
                    <td>
                      <ConditionalTextDisplay
                        :condition="budget_line.ref"
                        :success-text="budget_line.ref"
                        failure-text="reference"
                      />
                    </td>
                  </tr>
                  <tr>
                    <td>Value date</td>
                    <td>
                      <ConditionalTextDisplay
                        :condition="budget_line.value['0'].value_date"
                        :success-text="
                          formatDate(budget_line.value['0'].value_date)
                        "
                        failure-text="value date"
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
  organizationType: [];
  budgetType: [];
}

const types = inject('orgTypes') as TypesInterface;

function formatDate(date: Date) {
  return moment(date).format('LL');
}
</script>
