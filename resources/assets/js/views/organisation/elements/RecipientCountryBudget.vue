<template>
  <div
    v-for="(recipient_country_budget, index) in content"
    :key="index"
    :class="{
      'mb-4 border-b border-n-20 pb-4': Number(index) != content.length - 1,
    }"
  >
    <div class="elements-detail mb-4">
      <div class="category flex">
        {{
          recipient_country_budget.status
            ? types?.budgetType[recipient_country_budget.status]
            : "Status Not Available"
        }}
      </div>
      <div class="flex text-sm">
        <span v-if="recipient_country_budget.value[0].amount">
          {{ Number(recipient_country_budget.value["0"].amount).toLocaleString() }}
          {{ recipient_country_budget.value["0"].currency }}
        </span>
        <span v-else> Budget Amount Not Available</span>
      </div>
      <div class="ml-4">
        <table>
          <tbody>
            <tr>
              <td>Value date</td>
              <td>
                {{ formatDate(recipient_country_budget.value["0"].value_date) }}
              </td>
            </tr>
            <tr>
              <td>Code</td>
              <td>
                {{
                  recipient_country_budget.recipient_country["0"].code
                    ? types.country[recipient_country_budget.recipient_country["0"].code]
                    : "Code Not Available"
                }}
              </td>
            </tr>
            <tr>
              <td>Narrative</td>
              <td>
                <div
                  v-for="(narrative, i) in recipient_country_budget.recipient_country['0']
                    .narrative"
                  :key="i"
                  class="item"
                  :class="{
                    'mb-4':
                      i !=
                      recipient_country_budget.recipient_country['0'].narrative.length -
                        1,
                  }"
                >
                  <div class="description-content">
                    <div class="language mb-1.5">
                      (
                      {{
                        narrative.language
                          ? `Language: ${types?.languages[narrative.language]}`
                          : "Language : Not Available"
                      }}
                      )
                    </div>
                    <div class="w-[500px] max-w-full">
                      {{ narrative.narrative ?? "Narrative Not Available" }}
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td>Period</td>
              <td>
                {{ formatDate(recipient_country_budget.period_start["0"].date) }}
                -
                {{ formatDate(recipient_country_budget.period_end["0"].date) }}
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
        v-for="(budget_line, j) in recipient_country_budget.budget_line"
        :key="j"
        class="item"
        :class="{
          'mb-2 border-b border-n-20':
            j !== recipient_country_budget.budget_line.length - 1,
        }"
      >
        <div class="indicator-content flex px-6 py-2">
          <div class="elements-detail grow">
            <div class="category flex">
              <span v-if="budget_line.value['0'].amount">
                {{ Number(budget_line.value["0"].amount).toLocaleString() }}
                {{ budget_line.value["0"].currency }}
              </span>
              <span v-else> Budget Amount Not Available </span>
            </div>
            <div class="ml-4">
              <table>
                <tbody>
                  <tr>
                    <td class="pr-20 text-n-40">Reference</td>
                    <td>
                      {{ budget_line.ref ?? "Reference Not Available" }}
                    </td>
                  </tr>
                  <tr>
                    <td>Value date</td>
                    <td>
                      {{ formatDate(budget_line.value["0"].value_date) }}
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
                          ({{
                            narrative.language
                              ? `Language: ${types?.languages[narrative.language]}`
                              : "Language : Not Available"
                          }})
                        </div>
                        <div class="w-[500px] max-w-full">
                          {{ narrative.narrative ?? "Narrative Not Available" }}
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
import { defineProps, inject } from "vue";
import moment from "moment";

defineProps({
  content: { type: Object, required: true },
});

interface TypesInterface {
  languages: [];
  budgetType: [];
  regionVocabulary: [];
  country: [];
}

const types = inject("orgTypes") as TypesInterface;

function formatDate(date: Date) {
  return date ? moment(date).format("LL") : "Date Not Available";
}
</script>
