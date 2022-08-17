<template>
  <div
    v-for="(total_expenditure, index) in content"
    :key="index"
    :class="{
      'mb-4 border-b border-n-20 pb-4': Number(index) != content.length - 1,
    }"
  >
    <div class="mb-4 elements-detail">
      <div class="flex category">Expenditure</div>
      <div class="ml-4">
        <table>
          <tbody>
            <tr>
              <td>Value Amount</td>
              <td>
                {{
                  total_expenditure.value['0'].amount ?? 'Budget Not Available'
                }}
                {{ total_expenditure.value['0'].currency }}
              </td>
            </tr>
            <tr>
              <td>Period</td>
              <td>
                {{ formatDate(total_expenditure.period_start['0'].date) }}
                -
                {{ formatDate(total_expenditure.period_end['0'].date) }}
              </td>
            </tr>
            <tr>
              <td>Value date</td>
              <td>
                {{ formatDate(total_expenditure.value['0'].value_date) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="overflow-hidden border rounded-t-lg indicator border-n-20">
      <div class="flex items-center px-6 py-2 border-b head border-n-20">
        <span class="text-xs font-bold text-n-50">Expense line</span>
      </div>
      <div
        v-for="(expense_line, j) in total_expenditure.expense_line"
        :key="j"
        class="item"
        :class="{
          'mb-2 border-b border-n-20':
            j !== total_expenditure.expense_line.length - 1,
        }"
      >
        <div class="flex px-6 py-2 indicator-content">
          <div class="elements-detail grow">
            <div class="ml-4">
              <table>
                <tbody>
                  <tr>
                    <td>Reference</td>
                    <td>
                      {{ expense_line.ref ?? 'Reference Not Available' }}
                    </td>
                  </tr>
                  <tr>
                    <td>Value Amount</td>
                    <td>
                      {{ expense_line.value['0'].amount }}
                      {{ expense_line.value['0'].currency }} ({{
                        formatDate(expense_line.value['0'].value_date)
                      }})
                    </td>
                  </tr>
                  <tr>
                    <td>Narrative</td>
                    <td>
                      <div
                        v-for="(narrative, k) in expense_line.narrative"
                        :key="k"
                        class="description-content"
                        :class="{
                          'mb-4': k != expense_line.narrative.length - 1,
                        }"
                      >
                        <div class="language mb-1.5">
                          ({{
                            narrative.language
                              ? `Language: ${
                                  types?.languages[narrative.language]
                                }`
                              : 'Language : Not Available'
                          }})
                        </div>
                        <div class="w-[500px] max-w-full text-sm">
                          {{ narrative.narrative ?? 'Narrative Not Available' }}
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

defineProps({
  content: { type: Object, required: true },
});

interface TypesInterface {
  languages: [];
  budgetType: [];
  regionVocabulary: [];
  country: [];
}

const types = inject('orgTypes') as TypesInterface;

function formatDate(date: Date) {
  return date ? moment(date).format('LL') : 'Date Not Available';
}
</script>
