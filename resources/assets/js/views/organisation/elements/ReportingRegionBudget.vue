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
            : language.common_lang.missing.status
        }}
      </div>
      <div class="flex text-sm">
        <span v-if="recipient_region_budget.value[0].amount">
          {{
            Number(recipient_region_budget.value['0'].amount).toLocaleString()
          }}
          {{ recipient_region_budget.value['0'].currency }}
        </span>
        <span v-else>
          {{
            language.common_lang.missing.element.replace(
              ':element',
              language.common_lang.budget_line
            )
          }}</span
        >
      </div>
      <div class="ml-4">
        <table>
          <tbody>
            <tr>
              <td>{{ language.common_lang.value_date }}</td>
              <td>
                {{ formatDate(recipient_region_budget.value['0'].value_date) }}
              </td>
            </tr>
            <tr>
              <td>{{ language.common_lang.vocabulary }}</td>
              <td>
                {{
                  types?.regionVocabulary[
                    recipient_region_budget.recipient_region['0']
                      .region_vocabulary
                  ] ?? language.common_lang.missing.vocabulary
                }}
              </td>
            </tr>
            <tr
              v-if="
                recipient_region_budget.recipient_region['0']
                  .region_vocabulary === '99'
              "
            >
              <td>{{ language.common_lang.vocabulary_uri }}</td>
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
              <td v-else>
                {{
                  language.common_lang.missing.element.replace(
                    ':element',
                    language.common_lang.vocabulary_uri
                  )
                }}
              </td>
            </tr>
            <tr>
              <td>{{ language.common_lang.code }}</td>
              <td>
                {{
                  recipient_region_budget.recipient_region['0']
                    .region_vocabulary === '1'
                    ? types.region[
                        recipient_region_budget.recipient_region['0']
                          .region_code
                      ] ?? language.common_lang.code
                    : recipient_region_budget.recipient_region['0'].code ??
                      language.common_lang.code
                }}
              </td>
            </tr>
            <tr>
              <td>{{ language.common_lang.narrative }}</td>
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
                      (
                      {{
                        narrative.language
                          ? `${language.common_lang.language}: ${
                              types?.languages[narrative.language]
                            }`
                          : `${language.common_lang.language} : ${language.common_lang.missing.default}`
                      }}
                      )
                    </div>
                    <div class="w-[500px] max-w-full">
                      {{
                        narrative.narrative ??
                        language.common_lang.missing.narrative
                      }}
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td>{{ language.common_lang.period }}</td>
              <td>
                {{ formatDate(recipient_region_budget.period_start['0'].date) }}
                -
                {{ formatDate(recipient_region_budget.period_end['0'].date) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="indicator overflow-hidden rounded-t-lg border border-n-20">
      <div class="head flex items-center border-b border-n-20 px-6 py-2">
        <span class="text-xs font-bold text-n-50">{{
          language.common_lang.budget_line
        }}</span>
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
                {{
                  budget_line.value['0'].amount
                    ? Number(budget_line.value[0].amount).toLocaleString()
                    : language.common_lang.missing.element.replace(
                        ':element',
                        language.common_lang.budget
                      )
                }}
                {{ budget_line.value['0'].currency }}
              </span>
            </div>
            <div class="ml-4">
              <table>
                <tbody>
                  <tr>
                    <td class="pr-20 text-n-40">
                      {{ language.common_lang.reference }}
                    </td>
                    <td>
                      {{
                        budget_line.ref ??
                        language.common_lang.missing.reference
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td>{{ language.common_lang.value_date }}</td>
                    <td>
                      {{ formatDate(budget_line.value['0'].value_date) }}
                    </td>
                  </tr>
                  <tr>
                    <td>{{ language.common_lang.narrative }}</td>
                    <td>
                      <div
                        v-for="(narrative, k) in budget_line.narrative"
                        :key="k"
                        class="description-content"
                        :class="{
                          'mb-4': k !== budget_line.narrative.length - 1,
                        }"
                      >
                        <div class="language mb-1.5">
                          ({{
                            narrative.language
                              ? `${language.common_lang.language}: ${
                                  types?.languages[narrative.language]
                                }`
                              : `${language.common_lang.language} : ${language.common_lang.missing.default}`
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
  region: [];
}

const language = window['globalLang'];
const types = inject('orgTypes') as TypesInterface;

function formatDate(date: Date) {
  return date ? moment(date).format('LL') : language.common_lang.missing.date;
}
</script>
