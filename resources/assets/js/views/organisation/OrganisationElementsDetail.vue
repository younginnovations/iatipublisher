<template>
  <div class="activities__content--element px-3 py-3" :class="layout">
    <div class="rounded-lg bg-white p-4">
      <div class="mb-4 flex">
        <div class="title flex grow text-n-50">
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
          <div class="title text-sm font-bold">{{ title }}</div>
          <div
            v-if="'completed' in data"
            class="status ml-2.5 flex text-xs leading-5"
            :class="{
              'text-spring-50': data.completed === true,
              'text-crimson-50': data.completed === false,
            }"
          >
            <b class="mr-2 text-base leading-3">.</b>
            <span v-if="data.completed">completed</span>
            <span v-else>not completed</span>
          </div>
        </div>
        <div class="icons flex">
          <a
            class="
              edit-button
              mr-2.5
              flex
              items-center
              text-xs
              font-bold
              uppercase
            "
            :href="'/organisation/' + title"
          >
            <svg-vue class="mr-0.5 text-base" icon="edit"></svg-vue>
            <span>Edit</span>
          </a>
          <template v-if="'core' in data">
            <svg-vue v-if="data.core" class="mr-1.5" icon="core"></svg-vue>
          </template>
          <template v-if="'moon' in data">
            <svg-vue v-if="data.moon" class="mr-1.5" icon="moon"></svg-vue>
          </template>
          <hover-text
            v-if="tooltip"
            :hover_text="tooltip"
            class="text-n-40"
          ></hover-text>
        </div>
      </div>
      <div class="divider mb-4 h-px w-full bg-n-20"></div>
      <div class="text-sm text-n-50">
        <!-- iati_organizational_identifier -->
        <div v-if="title == 'organisation_identifier'">
          {{ content }}
        </div>
        <!-- iati_organization_identifier ends -->

        <!-- name -->
        <div v-if="title == 'name'">
          <div v-for="(name, i) in data.content" :key="i">
            <div v-if="name.narrative" class="flex flex-col">
              <span v-if="name.language" class="language mb-1.5">
                (Language: {{ types.languages[name.language]??'Not Available' }})
              </span>
              <span v-if="name.narrative" class="description text-sm">
                {{ name.narrative }}
              </span>
            </div>
            <span v-else class="text-sm italic">Title Not Available</span>
            <div v-if="i !== data.content.length - 1" class="mb-4"></div>
          </div>
        </div>
        <!-- name ends -->

        <!-- reporting_org -->
        <div v-if="title == 'reporting_org'">
          <div
            v-for="(reporting_org, index) in content"
            :key="index"
            class="flex flex-col"
          >
            <span class="element-title">{{
              reporting_org.type
                ? types.organizationType[reporting_org.type]
                : 'Type Not Available'
            }}</span>
            <table class="table-head">
              <tr>
                <td>Reference</td>
                <td>
                  {{ reporting_org.ref ?? 'Reference Not Available' }}
                </td>
              </tr>
              <tr>
                <td>Secondary Reporter</td>
                <td>
                  {{ reporting_org.secondary_reporter ? 'True' : 'False' }}
                </td>
              </tr>
              <tr>
                <td>Narrative</td>
                <td>
                  <div
                    v-for="(narrative, j) in reporting_org.narrative"
                    :key="j"
                  >
                    <div class="language">
                      {{
                        narrative.language
                          ? `Language: ${types.languages[narrative.language]}`
                          : 'Language Not Available'
                      }}
                    </div>
                    <span class="">{{
                      narrative.narrative ?? 'Narrative Not Available'
                    }}</span>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <!-- reporting_org ends -->

        <!-- total budget -->
        <div v-if="title == 'total_budget'">
          <div
            v-for="(total_budget, index) in content"
            :key="index"
            class="flex flex-col mb-2"
          >
            <span class="element-title">{{
              types.budgetType[total_budget.total_budget_status] ??
              'Budget Status Not Available'
            }}</span>
            <span class="mb-1 text-sm"
              >{{ total_budget.value['0'].amount }}
              {{ total_budget.value['0'].currency }}</span
            >
            <table class="table-head">
              <tr>
                <td>Period</td>
                <td>
                  {{
                    formatDate(total_budget.period_start['0'].date) ??
                    'Period Start Date Not Available'
                  }}
                  -
                  {{
                    formatDate(total_budget.period_end['0'].date) ??
                    'Period End Date Not Available'
                  }}
                </td>
              </tr>
              <tr>
                <td>Value date</td>
                <td>
                  {{
                    formatDate(total_budget.value['0'].value_date) ??
                    'Value Date Not Available'
                  }}
                </td>
              </tr>
            </table>
            <div
              class="
                mx-5
                overflow-hidden
                rounded-tl-lg rounded-tr-lg
                border border-b-0 border-n-20
              "
            >
              <div class="bg-n-10 py-2 pl-6 text-left text-xs font-bold">
                budget line
              </div>
              <div
                v-for="(budget_line, j) in total_budget.budget_line"
                :key="j"
              >
                <div class="mt-2 border-b border-b-n-20 pl-6 text-xs">
                  <table>
                    <tr>
                      <td class="mb-1 flex flex-col text-xs font-bold">
                        {{ budget_line.value['0'].amount }}
                        {{ budget_line.value['0'].currency }}
                      </td>
                    </tr>
                    <tr>
                      <td class="mb-1 text-n-40">Reference</td>
                      <td class="mb-1 pl-2">
                        {{ budget_line.ref ?? 'Reference Not Available' }}
                      </td>
                    </tr>
                    <tr>
                      <td class="mb-1 text-n-40">Value</td>
                      <td class="mb-1 pl-2">
                        {{ budget_line.value['0'].amount }}
                        {{ budget_line.value['0'].currency }} ({{
                          formatDate(budget_line.value['0'].value_date) ??
                          'Value Date Not Available'
                        }})
                      </td>
                    </tr>
                    <tr>
                      <td class="mb-1 text-n-40">Narrative</td>
                      <td class="mb-1 pl-2">
                        <div
                          v-for="(narrative, k) in budget_line.narrative"
                          :key="k"
                        >
                          <table class="mb-2 whitespace-nowrap">
                            <tr class="mb-1">
                              <td class="language pl-2">
                                {{
                                  narrative.language
                                    ? `Language: ${
                                        types.languages[narrative.language]
                                      } `
                                    : 'Language Not Available'
                                }}
                              </td>
                            </tr>
                            <tr>
                              <td class="pl-2">
                                {{
                                  narrative.narrative ??
                                  'Narrative Not Available'
                                }}
                              </td>
                            </tr>
                          </table>
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- total budget ends-->

        <!-- recipient organisation budget -->
        <div v-if="title == 'recipient_org_budget'">
          <div
            v-for="(recipient_org_budget, index) in content"
            :key="index"
            class="mt-5 flex flex-col"
          >
            <span class="element-title">{{
              recipient_org_budget.status
                ? types.budgetType[recipient_org_budget.status]
                : 'Status Not Available'
            }}</span>
            <span class="mb-1 text-sm">
              {{ recipient_org_budget.value['0'].amount }}
              {{ recipient_org_budget.value['0'].currency }}
              {{ formatDate(recipient_org_budget.value['0'].value_date) }}
            </span>
            <div
              v-for="(
                recipient_org, recipient_org_index
              ) in recipient_org_budget.recipient_org"
              :key="recipient_org_index"
              class="ml-5 flex"
            >
              <div class="w-[118px] text-xs font-normal text-n-40">
                Recipient Organisation
              </div>

              <table
                class="
                  mb-1
                  flex
                  border-collapse
                  flex-col
                  space-y-1
                  pl-2
                  text-xs text-n-50
                "
              >
                <tr
                  class="recipient-organisation flex flex-col whitespace-nowrap"
                >
                  <td>
                    {{
                      recipient_org.ref
                        ? `Reference-${recipient_org.ref}`
                        : 'Reference Not Available'
                    }}
                  </td>
                  <td
                    v-for="(
                      narrative, narrative_index
                    ) in recipient_org.narrative"
                    :key="narrative_index"
                    class="flex flex-col"
                  >
                    <span class="language"
                      >(
                      {{
                        narrative.language
                          ? `Language: ${types.languages[narrative.language]}`
                          : 'Language Not Available'
                      }}
                      )</span
                    >
                    <span>{{ narrative.narrative }}</span>
                  </td>
                </tr>
              </table>
            </div>
            <table class="table-head recipient-organisation">
              <tr>
                <td>Value</td>
                <td>
                  {{ recipient_org_budget.value['0'].amount }}
                  {{ recipient_org_budget.value['0'].currency }} ({{
                    formatDate(
                      recipient_org_budget.value['0'].value_date ??
                        'Value Date Not Available'
                    )
                  }})
                </td>
              </tr>
              <tr>
                <td>Period</td>
                <td>
                  {{
                    recipient_org_budget.period_start['0'].date ??
                    'Period Start Not Available'
                  }}
                  -
                  {{
                    recipient_org_budget.period_start['0'].iso_date ??
                    'Period End Not Available'
                  }}
                </td>
              </tr>
            </table>
            <div
              class="
                mx-5
                overflow-hidden
                rounded-tl-lg rounded-tr-lg
                border border-b-0 border-n-20
              "
            >
              <div class="bg-n-10 py-2 pl-6 text-left text-xs font-bold">
                budget line
              </div>
              <div
                v-for="(budget_line, j) in recipient_org_budget.budget_line"
                :key="j"
                class="mt-2 border-b border-b-n-20 pl-6 text-xs"
              >
                <span class="mb-1 flex flex-col text-xs font-bold">
                  {{ budget_line.value['0'].amount ?? 'Budget Not Available' }}
                  {{ budget_line.value['0'].currency }}
                </span>
                <table>
                  <tr>
                    <td class="mb-1 text-n-40">Reference</td>
                    <td class="mb-1 pl-2">
                      {{ budget_line.ref ?? 'Reference Not Available' }}
                    </td>
                  </tr>
                  <tr>
                    <td class="mb-1 text-n-40">Value date</td>
                    <td class="mb-1 pl-2">
                      {{
                        formatDate(budget_line.value['0'].value_date) ??
                        'Value Date Not Available'
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td class="mb-1 text-n-40">Narrative</td>
                    <td class="mb-1 pl-2">
                      <div
                        v-for="(narrative, k) in budget_line.narrative"
                        :key="k"
                        class="flex flex-col"
                      >
                        <table class="mb-2 whitespace-nowrap">
                          <tr class="mb-1">
                            <td class="language pl-2">
                              ({{
                                narrative.language
                                  ? `Language: ${
                                      types.languages[narrative.language]
                                    }`
                                  : 'Language Not Available'
                              }})
                            </td>
                          </tr>
                          <tr>
                            <td class="pl-2">
                              {{
                                narrative.narrative ?? 'Narrative Not Available'
                              }}
                            </td>
                          </tr>
                        </table>
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- recipient organisation budget ends -->

        <!-- recipient region budget -->
        <div v-if="title == 'recipient_region_budget'">
          <div v-for="(recipient_region_budget, index) in content" :key="index">
            <span class="element-title">
              {{
                recipient_region_budget.status
                  ? types.budgetType[recipient_region_budget.status]
                  : 'Status Not Available'
              }}
            </span>
            <span class="mb-1 text-sm">{{
              recipient_region_budget.budget
            }}</span>
            <table class="table-head recipient-organisation">
              <tr>
                <td>Value date</td>
                <td>
                  {{
                    formatDate(recipient_region_budget.value['0'].value_date)
                  }}
                </td>
              </tr>
              <tr>
                <td>Vocabulary</td>
                <td>
                  {{
                    recipient_region_budget.recipient_region['0']
                      .region_vocabulary ?? 'Vocabulary Not Available'
                  }}
                </td>
              </tr>
              <tr
                v-if="
                  recipient_region_budget.recipient_region['0']
                    .region_vocabulary === '99'
                "
              >
                <td>Vocabulary_URI</td>
                <td>
                  <a href="#">{{
                    recipient_region_budget.recipient_region['0']
                      .region_vocabulary_URI
                  }}</a>
                </td>
              </tr>
              <tr
                v-if="
                  recipient_region_budget.recipient_region['0']
                    .region_vocabulary != '99'
                "
              >
                <td>Code</td>
                <td>
                  {{
                    recipient_region_budget.recipient_region['0']
                      .region_vocabulary != '1'
                      ? recipient_region_budget.recipient_region['0']
                          .region_code ?? 'Code Not Available'
                      : recipient_region_budget.recipient_region['0'].code ??
                        'Code Not Available'
                  }}
                </td>
              </tr>
              <tr class="flex">
                <td class="pr-20 text-n-40">Description</td>
                <td class="pl-2 leading-5 lg:w-[500px]">
                  <div
                    v-for="(narrative, i) in recipient_region_budget
                      .recipient_region['0'].narrative"
                    :key="i"
                  >
                    <div class="language">
                      ({{
                        narrative.language
                          ? `Language: ${types.languages[narrative.language]}`
                          : 'Language Not Available'
                      }})
                    </div>
                    <span class="">{{
                      narrative.narrative ?? 'Narrative Not Available'
                    }}</span>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Period</td>
                <td>
                  {{
                    recipient_region_budget.period_start['0'].date ??
                    'Period Start Date Not Available'
                  }}
                  -
                  {{
                    recipient_region_budget.period_end['0'].date ??
                    'Period End Date Not Available'
                  }}
                </td>
              </tr>
            </table>
            <div
              class="
                mx-5
                overflow-hidden
                rounded-tl-lg rounded-tr-lg
                border border-b-0 border-n-20
              "
            >
              <div class="bg-n-10 py-2 pl-6 text-left text-xs font-bold">
                budget line
              </div>
              <div
                v-for="(budget_line, j) in recipient_region_budget.budget_line"
                :key="j"
                class="mt-2 border-b border-b-n-20 pl-6 text-xs"
              >
                <span class="mb-1 flex text-xs font-bold">
                  {{ budget_line.value['0'].amount ?? 'Budget Not Available' }}
                  {{ budget_line.value['0'].currency }}
                  ({{ formatDate(budget_line.value['0'].value_date) }})
                </span>
                <table class="table-head recipient-organisation">
                  <tr>
                    <td class="pr-20 text-n-40">Reference</td>
                    <td>
                      {{ budget_line.ref ?? 'Reference Not Available' }}
                    </td>
                  </tr>
                  <tr class="flex leading-5">
                    <td class="mb-1 w-[100px] text-n-40">Narrative</td>
                    <td class="flex flex-col">
                      <div
                        v-for="(narrative, k) in budget_line.narrative"
                        :key="k"
                      >
                        <div class="mb-2 whitespace-nowrap flex flex-col">
                          <span class="language pl-2 mb-1">
                            ({{
                              narrative.language
                                ? `Language: ${
                                    types.languages[narrative.language]
                                  }`
                                : 'Language Not Available'
                            }})
                          </span>
                          <span class="pl-2">{{
                            narrative.narrative ?? 'Narrative Not Available'
                          }}</span>
                        </div>
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- recipient region budget ends -->

        <!-- recipient country budget -->
        <div v-if="title == 'recipient_country_budget'">
          <div
            v-for="(recipient_country_budget, index) in content"
            :key="index"
            class="flex flex-col"
          >
            <span class="element-title">
              {{
                recipient_country_budget.status
                  ? types.budgetType[recipient_country_budget.status]
                  : 'Status Not Available'
              }}
            </span>
            <span class="mb-1 text-sm">{{
              recipient_country_budget.value['0'].amount ??
              'Budget Not Available'
            }}</span>
            <div class="ml-5 flex"></div>
            <table class="table-head recipient-organisation">
              <tr>
                <td>Value date</td>
                <td>
                  {{
                    formatDate(recipient_country_budget.value['0'].value_date)
                  }}
                </td>
              </tr>
              <tr>
                <td>Code</td>
                <td>
                  {{
                    recipient_country_budget.recipient_country['0'].code ??
                    'Code Not Available'
                  }}
                </td>
              </tr>
              <tr class="flex">
                <td class="pr-20 text-n-40">Description</td>
                <td class="pl-2 leading-5 lg:w-[500px]">
                  <div
                    v-for="(narrative, j) in recipient_country_budget
                      .recipient_country['0'].narrative"
                    :key="j"
                  >
                    <div class="language">
                      {{ narrative.language ?? 'Language Not Available' }}
                    </div>
                    <span class="">{{
                      narrative.narrative ?? 'Narrative Not Available'
                    }}</span>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Period</td>
                <td>
                  {{
                    recipient_country_budget.period_start['0'].iso_date ??
                    'Period Start Date Not Available'
                  }}
                  -
                  {{
                    recipient_country_budget.period_end['0'].iso_date ??
                    'Period End Date Not Available'
                  }}
                </td>
              </tr>
            </table>
            <div
              class="
                mx-5
                overflow-hidden
                rounded-tl-lg rounded-tr-lg
                border border-b-0 border-n-20
              "
            >
              <div class="bg-n-10 py-2 pl-6 text-left text-xs font-bold">
                budget line
              </div>
              <div
                v-for="(budget_line, j) in recipient_country_budget.budget_line"
                :key="j"
                class="mt-2 border-b border-b-n-20 pl-6 text-xs"
              >
                <span class="mb-1 flex flex-col text-xs font-bold">
                  {{ budget_line.value['0'].amount ?? 'Budget Not Available' }}
                </span>
                <table>
                  <tr>
                    <td class="mb-1 text-n-40">Reference</td>
                    <td class="mb-1 pl-2">
                      {{ budget_line.ref ?? 'Reference Not Available' }}
                    </td>
                  </tr>
                </table>
                <div class="flex leading-5">
                  <div class="mb-1 w-[100px] text-n-40">Narrative</div>
                  <div class="flex flex-col">
                    <div
                      v-for="(narrative, k) in budget_line.narrative"
                      :key="k"
                    >
                      <table class="mb-2 whitespace-nowrap">
                        <tr class="mb-1">
                          <td class="language pl-2">
                            {{
                              narrative.language
                                ? `Language: ${
                                    types.languages[narrative.language]
                                  }`
                                : 'Language Not Available'
                            }}
                          </td>
                        </tr>
                        <tr>
                          <td class="pl-2">
                            {{
                              narrative.narrative ?? 'Narrative Not Available'
                            }}
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- recipient country budget ends -->

        <!-- total expenditure -->
        <div v-if="title == 'total_expenditure'">
          <div
            v-for="(total_expenditure, index) in content"
            :key="index"
            class="flex flex-col"
          >
            <span class="element-title">{{
              total_expenditure.ref ?? 'Reference Not Available'
            }}</span>
            <span class="mb-1 text-sm"
              >{{
                total_expenditure.value['0'].amount ?? 'Budget Not Available'
              }}
              {{ total_expenditure.value['0'].currency }}</span
            >
            <table class="table-head">
              <tr>
                <td>Period</td>
                <td>
                  {{
                    total_expenditure.period_start['0'].date ??
                    'Period Start Date Not Available'
                  }}
                  -
                  {{
                    total_expenditure.period_end['0'].date ??
                    'Period End Date Not Available'
                  }}
                </td>
              </tr>
              <tr>
                <td>Value date</td>
                <td>
                  {{ formatDate(total_expenditure.value['0'].value_date) }}
                </td>
              </tr>
            </table>
            <div
              class="
                mx-5
                overflow-hidden
                rounded-tl-lg rounded-tr-lg
                border border-b-0 border-n-20
              "
            >
              <div class="bg-n-10 py-2 pl-6 text-left text-xs font-bold">
                expense line
              </div>
              <div
                v-for="(expense_line, j) in total_expenditure.expense_line"
                :key="j"
              >
                <div class="mt-2 border-b border-b-n-20 pl-6 text-xs">
                  <table>
                    <tr>
                      <td class="mb-1 flex flex-col text-xs font-bold">
                        {{
                          expense_line.value['0'].amount ??
                          'Expense Not Available'
                        }}
                        {{ expense_line.value['0'].currency }}
                      </td>
                    </tr>
                    <tr>
                      <td class="mb-1 flex flex-col text-xs font-bold">
                        {{ expense_line.budget }}
                      </td>
                    </tr>

                    <tr>
                      <td class="mb-1 text-n-40">Value</td>
                      <td class="mb-1 pl-2">
                        {{ expense_line.value['0'].amount }}
                        {{ expense_line.value['0'].currency }} ({{
                          formatDate(expense_line.value['0'].value_date)
                        }})
                      </td>
                    </tr>
                    <tr class="multiline">
                      <td class="mb-1 text-n-40">Narrative</td>
                      <td class="mb-1 pl-2">
                        <div
                          v-for="(narrative, k) in expense_line.narrative"
                          :key="k"
                          class="flex flex-col"
                        >
                          <span class="language pl-2">
                            ({{
                              narrative.language
                                ? `Language: ${
                                    types.languages[narrative.language]
                                  }`
                                : 'Language Not Available'
                            }})
                          </span>
                          <span>
                            {{
                              narrative.narrative ?? 'Narrative Not Available'
                            }}
                          </span>
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- total expenditure ends -->

        <!-- document link -->
        <div v-if="title == 'document_link'" class="document-link text-xs">
          <div
            v-for="(document_link, key) in data.content"
            :key="key"
            class="elements-detail"
            :class="{ 'mb-4': key !== data.content.length - 1 }"
          >
            <div>
              <div v-if="document_link.url" class="max-w-[887px] text-sm">
                <a :href="document_link.url" target="_blank">{{
                  document_link.url
                }}</a>
              </div>
              <span v-else class="italic">URL Not Available</span>
            </div>
            <div class="ml-5">
              <div>
                <div v-for="(language, i) in document_link.language" :key="i">
                  <table>
                    <tr>
                      <td>Language</td>
                      <td>
                        <span v-if="language.code">({{
                          language.code? `Language: ${types.languages[language.code]}`:'Language Not Available'
                        }})</span>
                        <span v-else class="italic">Not Available</span>
                      </td>
                    </tr>
                  </table>
                </div>
                <div
                  v-for="(document_date, i) in document_link.document_date"
                  :key="i"
                >
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
              <div class="mb-1 flex items-center space-x-1">
                <table>
                  <tr class="multiline">
                    <td>Title</td>
                    <td>
                      <div
                        v-for="(narrative, j) in document_link.title['0']
                          .narrative"
                        :key="j"
                      >
                        <span v-if="narrative.language" class="language">
                          ({{
                            narrative.language
                              ? `Language: ${
                                  types.languages[narrative.language]
                                }`
                              : 'Language Not Available'
                          }})
                        </span>
                        <div v-if="narrative.narrative" class="flex flex-col">
                          <span>
                            {{ narrative.narrative }}
                          </span>
                        </div>
                        <span v-else class="italic">Not Available</span>
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
              <table>
                <tr>
                  <td>Category</td>
                  <td>
                    <div
                      v-for="(category, i) in document_link.category"
                      :key="i"
                    >
                      <span v-if="category.code">{{ category.code }}</span>
                      <span v-else class="italic">Not Available</span>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Format</td>
                  <td v-if="document_link.format">
                    {{ document_link.format }}
                  </td>
                  <td v-else class="italic">Not Available</td>
                </tr>
                <tr class="multiline">
                  <td>Description</td>
                  <td>
                    <div
                      v-for="(narrative, j) in document_link.description['0']
                        .narrative"
                      :key="j"
                    >
                      <div v-if="narrative.narrative" class="flex flex-col">
                        <span v-if="narrative.language" class="language"
                          >(
                          {{
                            narrative.language
                              ? `Language: ${
                                  types.languages[narrative.language]
                                }`
                              : 'Language Not Available'
                          }}
                          )
                        </span>
                        <span class="description">{{
                          narrative.narrative
                        }}</span>
                      </div>
                      <span v-else class="italic">Not Available</span>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Recipient Country</td>
                  <td>
                    <div
                      v-for="(
                        recipient_country, i
                      ) in document_link.recipient_country"
                      :key="i"
                    >
                      <span class="mb-1 flex flex-col text-xs font-bold">
                        {{ recipient_country.code ?? 'Code Not Available' }}
                      </span>
                      <div
                        v-for="(narrative, j) in recipient_country.narrative"
                        :key="j"
                      >
                        <div class="language">
                          ({{
                            narrative.language
                              ? `Language: ${
                                  types.languages[narrative.language]
                                } `
                              : 'Language Not Available'
                          }})
                        </div>
                        <span class="">{{
                          narrative.narrative ?? 'Narrative Not Available'
                        }}</span>
                      </div>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <!-- document link ends -->
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import HoverText from '../../components/HoverText.vue';
import moment from 'moment';

export default defineComponent({
  name: 'OrganisationElement',
  components: { HoverText },
  props: {
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
    },
    width: {
      type: String,
      required: false,
    },
    types: {
      type: Object,
      required: false,
    },
  },
  setup(props) {
    const status = '';
    let layout = 'basis-6/12';
    if (props.width === 'full') {
      layout = 'basis-full';
    }

    function formatDate(date: Date) {
      return moment(date).format('LL');
    }

    return { layout, status, props, formatDate };
  },
});
</script>

<style lang="scss" scoped>
.activities__content--element > div {
  .edit-button {
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s ease;
  }

  &:hover .edit-button {
    opacity: 1;
    visibility: visible;
  }
  .language {
    @apply mb-1 text-xs italic text-n-30;
  }
  .element-title {
    @apply mb-2 text-sm font-bold text-n-50;
  }
  td:nth-child(1) {
    width: 100px;
  }
  .recipient-organisation {
    td:nth-child(1) {
      width: 118px;
    }
  }
  :is(tr, td) * {
    @apply mb-1;
  }

  .document-link {
    @apply leading-5;

    table {
      @apply whitespace-nowrap;

      p {
        @apply mb-0 whitespace-normal;
      }
    }
    .table {
      @apply ml-5 mb-1;

      td:nth-child(1) {
        @apply text-n-40;
      }
      td:nth-child(2) {
        @apply pl-2;
      }
    }
  }
  .table-head {
    @apply mb-2 ml-5 flex border-collapse flex-col space-y-1 text-xs text-n-50;

    td:nth-child(1) {
      @apply text-n-40;
    }
    td:nth-child(2) {
      @apply pl-2;
    }
  }
}
</style>
