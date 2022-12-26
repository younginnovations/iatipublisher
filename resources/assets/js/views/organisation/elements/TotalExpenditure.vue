<template>
  <div
    v-for="(total_expenditure, index) in content"
    :key="index"
    :class="{
      'mb-4 border-b border-n-20 pb-4': Number(index) != content.length - 1,
    }"
  >
    <div class="elements-detail mb-4">
      <div class="ml-2 flex text-sm">
        <span v-if="total_expenditure.value[0].amount">
          {{
            total_expenditure.value['0'].amount
              ? Number(total_expenditure.value[0].amount).toLocaleString()
              : language.common_lang.missing.element.replace(
                  ':element',
                  language.common_lang.budget
                )
          }}
          {{ total_expenditure.value['0'].currency }}
        </span>
        <span v-else>
          {{
            language.common_lang.missing.element.replace(
              ':element',
              language.common_lang.expenditure_amount
            )
          }}</span
        >
      </div>
      <div class="ml-4">
        <table>
          <tbody>
            <tr>
              <td>{{ language.common_lang.period }}</td>
              <td>
                {{ formatDate(total_expenditure.period_start['0'].date) }}
                -
                {{ formatDate(total_expenditure.period_end['0'].date) }}
              </td>
            </tr>
            <tr>
              <td>{{ language.common_lang.value_date }}</td>
              <td>
                {{ formatDate(total_expenditure.value['0'].value_date) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="indicator overflow-hidden rounded-t-lg border border-n-20">
      <div class="head flex items-center border-b border-n-20 px-6 py-2">
        <span class="text-xs font-bold text-n-50">{{
          language.common_lang.expense_line
        }}</span>
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
        <div class="indicator-content flex px-6 py-2">
          <div class="elements-detail grow">
            <div class="category flex">
              <span v-if="expense_line.value['0'].amount">
                {{ Number(expense_line.value['0'].amount).toLocaleString() }}
                {{ expense_line.value['0'].currency }}
              </span>
              <span v-else>
                {{ language.common_lang.expense_line }}
                {{ language.common_lang.missing.default }}
              </span>
            </div>
            <div class="ml-4">
              <table>
                <tbody>
                  <tr>
                    <td>{{ language.common_lang.reference_label }}</td>
                    <td>
                      {{
                        expense_line.ref ??
                        language.common_lang.missing.reference
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td>{{ language.common_lang.value_date }}</td>
                    <td>
                      {{ formatDate(expense_line.value['0'].value_date) }}
                    </td>
                  </tr>
                  <tr>
                    <td>{{ language.common_lang.narrative }}</td>
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
                              ? `${language.common_lang.language}: ${
                                  types?.languages[narrative.language]
                                }`
                              : `${language.common_lang.language} : ${language.missing_lang}`
                          }})
                        </div>
                        <div class="w-[500px] max-w-full">
                          {{
                            narrative.narrative ??
                            language.common_lang.missing.narrative
                          }}
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

const language = window['globalLang'];
const types = inject('orgTypes') as TypesInterface;

function formatDate(date: Date) {
  return date ? moment(date).format('LL') : language.common_lang.missing.date;
}
</script>
