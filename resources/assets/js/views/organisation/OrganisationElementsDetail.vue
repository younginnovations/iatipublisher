<template>
  <div class="activities__content--element px-3 py-3" :class="layout">
    <div class="rounded-lg bg-white p-4">
      <div class="mb-4 flex">
        <div class="title flex grow text-n-50">
          <template v-if="title === 'organisation_name'">
            <svg-vue
              class="mr-1.5 text-xl text-bluecoral"
              icon="organisation-elements/building"
            ></svg-vue>
          </template>
          <template v-else-if="title === 'reporting_organisation'">
            <svg-vue
              class="mr-1.5 text-xl text-bluecoral"
              icon="organisation-elements/reporting_org"
            ></svg-vue>
          </template>
          <template v-else-if="title === 'recipient_organisation_budget'">
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
            class="edit-button mr-2.5 flex items-center text-xs font-bold uppercase"
            href="/1/title-form"
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
          <HoverText
            v-if="tooltip"
            :hover_text="tooltip"
            class="text-n-40"
          ></HoverText>
        </div>
      </div>
      <div class="divider mb-4 h-px w-full bg-n-20"></div>
      <div class="text-sm text-n-50">
        <div v-if="title == 'organisation_identifier'">
          {{ props.content.identifier }}
        </div>
        <div v-if="title == 'organisation_name'">
          {{ props.content.name }}
        </div>
        <div v-if="title == 'reporting_organisation'" class="language">
          {{ props.content.language }}
        </div>
        <div v-if="title == 'reporting_organisation'">
          {{ props.content.narrative }}
        </div>
        <!-- total budget -->
        <div v-if="title == 'total_budget'">
          <div v-for="(total_budget, index) in props.content" :key="index">
            <div
              class="mb-4 flex flex-col"
              v-for="(indicative, i) in total_budget.indicative"
              :key="i"
            >
              <span class="element-title">{{ indicative.indicative }}</span>
              <span class="mb-1 text-sm">{{ indicative.budget }}</span>
              <table class="table-head">
                <tr>
                  <td>Period</td>
                  <td>{{ indicative.period }}</td>
                </tr>
                <tr>
                  <td>Value date</td>
                  <td>{{ indicative.value_date }}</td>
                </tr>
              </table>
              <div
                class="mx-5 overflow-hidden rounded-tl-lg rounded-tr-lg border border-b-0 border-n-20"
              >
                <div class="bg-n-10 py-2 pl-6 text-left text-xs font-bold">
                  budget line
                </div>
                <div
                  class="mt-2 border-b border-b-n-20 pl-6 text-xs"
                  v-for="(budget_line, j) in indicative.budget_line"
                  :key="j"
                >
                  <table>
                    <tr>
                      <td class="mb-1 flex flex-col text-xs font-bold">
                        {{ budget_line.budget }}
                      </td>
                    </tr>
                    <tr>
                      <td class="mb-1 text-n-40">Reference</td>
                      <td class="mb-1 pl-2">
                        {{ budget_line.reference }}
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
                              {{ narrative.language }}
                            </td>
                          </tr>
                          <tr>
                            <td class="pl-2">{{ narrative.narrative }}</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="flex flex-col"
              v-for="(committed, i) in total_budget.committed"
              :key="i"
            >
              <span class="element-title">{{ committed.committed }}</span>
              <span class="mb-1 text-sm">{{ committed.budget }}</span>
              <table class="table-head">
                <tr>
                  <td>Period</td>
                  <td>{{ committed.period }}</td>
                </tr>
                <tr>
                  <td>Value date</td>
                  <td>{{ committed.value_date }}</td>
                </tr>
              </table>
              <div
                class="mx-5 overflow-hidden rounded-tl-lg rounded-tr-lg border border-b-0 border-n-20"
              >
                <div class="bg-n-10 py-2 pl-6 text-left text-xs font-bold">
                  budget line
                </div>
                <div
                  class="mt-2 border-b border-b-n-20 pl-6 text-xs"
                  v-for="(budget_line, j) in committed.budget_line"
                  :key="j"
                >
                  <table>
                    <tr>
                      <td class="mb-1 flex flex-col text-xs font-bold">
                        {{ budget_line.budget }}
                      </td>
                    </tr>
                    <tr>
                      <td class="mb-1 text-n-40">Reference</td>
                      <td class="mb-1 pl-2">
                        {{ budget_line.reference }}
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
                              {{ narrative.language }}
                            </td>
                          </tr>
                          <tr>
                            <td class="pl-2">{{ narrative.narrative }}</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- total budget ends-->

        <!-- recipient organisation budget -->
        <div v-if="title == 'recipient_organisation_budget'">
          <div
            v-for="(recipient_organisation_budget, index) in props.content"
            :key="index"
          >
            <div
              class="mb-4 flex flex-col"
              v-for="(
                indicative, i
              ) in recipient_organisation_budget.indicative"
              :key="i"
            >
              <span class="element-title">{{ indicative.indicative }}</span>
              <span class="mb-1 text-sm">{{ indicative.budget }}</span>
              <div class="ml-5 flex">
                <div class="w-[118px] text-xs font-normal text-n-40">
                  Recipient Organisation
                </div>
                <table
                  class="mb-1 flex border-collapse flex-col space-y-1 pl-2 text-xs text-n-50"
                >
                  <tr
                    class="recipient-organisation flex flex-col whitespace-nowrap"
                  >
                    <td>{{ indicative.recipient_organisation.reference }}</td>
                    <td class="language">
                      {{ indicative.recipient_organisation.language }}
                    </td>
                    <td>{{ indicative.recipient_organisation.cash }}</td>
                  </tr>
                </table>
              </div>
              <table class="table-head recipient-organisation">
                <tr>
                  <td>Value date</td>
                  <td>{{ indicative.value_date }}</td>
                </tr>
                <tr>
                  <td>Period</td>
                  <td>{{ indicative.period }}</td>
                </tr>
              </table>
              <div
                class="mx-5 overflow-hidden rounded-tl-lg rounded-tr-lg border border-b-0 border-n-20"
              >
                <div class="bg-n-10 py-2 pl-6 text-left text-xs font-bold">
                  budget line
                </div>
                <div
                  class="mt-2 border-b border-b-n-20 pl-6 text-xs"
                  v-for="(budget_line, j) in indicative.budget_line"
                  :key="j"
                >
                  <table>
                    <tr>
                      <td class="mb-1 flex flex-col text-xs font-bold">
                        {{ budget_line.budget }}
                      </td>
                    </tr>
                    <tr>
                      <td class="mb-1 text-n-40">Reference</td>
                      <td class="mb-1 pl-2">
                        {{ budget_line.reference }}
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
                              {{ narrative.language }}
                            </td>
                          </tr>
                          <tr>
                            <td class="pl-2">{{ narrative.narrative }}</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="flex flex-col"
              v-for="(committed, i) in recipient_organisation_budget.committed"
              :key="i"
            >
              <span class="element-title">{{ committed.committed }}</span>
              <span class="mb-1 text-sm">{{ committed.budget }}</span>
              <div class="ml-5 flex">
                <div class="w-[118px] text-xs font-normal text-n-40">
                  Recipient Organisation
                </div>
                <table
                  class="mb-1 flex border-collapse flex-col space-y-1 pl-2 text-xs"
                >
                  <tr
                    class="recipient-organisation flex flex-col whitespace-nowrap text-n-50"
                  >
                    <td>{{ committed.recipient_organisation.reference }}</td>
                    <td class="language">
                      {{ committed.recipient_organisation.language }}
                    </td>
                    <td>{{ committed.recipient_organisation.cash }}</td>
                  </tr>
                </table>
              </div>
              <table class="table-head recipient-organisation">
                <tr>
                  <td>Value date</td>
                  <td>{{ committed.value_date }}</td>
                </tr>
                <tr>
                  <td>Period</td>
                  <td>{{ committed.period }}</td>
                </tr>
              </table>
              <div
                class="mx-5 overflow-hidden rounded-tl-lg rounded-tr-lg border border-b-0 border-n-20"
              >
                <div class="bg-n-10 py-2 pl-6 text-left text-xs font-bold">
                  budget line
                </div>
                <div
                  class="mt-2 border-b border-b-n-20 pl-6 text-xs"
                  v-for="(budget_line, j) in committed.budget_line"
                  :key="j"
                >
                  <table>
                    <tr>
                      <td class="mb-1 flex flex-col text-xs font-bold">
                        {{ budget_line.budget }}
                      </td>
                    </tr>
                    <tr>
                      <td class="mb-1 text-n-40">Reference</td>
                      <td class="mb-1 pl-2">
                        {{ budget_line.reference }}
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
                              {{ narrative.language }}
                            </td>
                          </tr>
                          <tr>
                            <td class="pl-2">{{ narrative.narrative }}</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- recipient organisation budget ends -->

        <!-- recipient region budget -->
        <div v-if="title == 'recipient_region_budget'">
          <div
            v-for="(recipient_region_budget, index) in props.content"
            :key="index"
          >
            <div
              class="mb-4 flex flex-col"
              v-for="(indicative, i) in recipient_region_budget.indicative"
              :key="i"
            >
              <span class="element-title">{{ indicative.indicative }}</span>
              <span class="mb-1 text-sm">{{ indicative.budget }}</span>
              <table class="table-head recipient-organisation">
                <tr>
                  <td>Value date</td>
                  <td>{{ indicative.value_date }}</td>
                </tr>
                <tr>
                  <td>Vocabulary</td>
                  <td>{{ indicative.vocabulary }}</td>
                </tr>
                <tr>
                  <td>Vocabulary_URI</td>
                  <td>
                    <a href="#">{{ indicative.vocabulary_URI }}</a>
                  </td>
                </tr>
                <tr>
                  <td>Code</td>
                  <td>{{ indicative.code }}</td>
                </tr>
                <tr class="flex">
                  <td class="pr-20 text-n-40">Description</td>
                  <td class="pl-2 leading-5 lg:w-[500px]">
                    <div class="language">
                      {{ indicative.description.language }}
                    </div>
                    <span class="">{{ indicative.description.text }}</span>
                  </td>
                </tr>
                <tr>
                  <td>Period</td>
                  <td>{{ indicative.period }}</td>
                </tr>
              </table>
              <div
                class="mx-5 overflow-hidden rounded-tl-lg rounded-tr-lg border border-b-0 border-n-20"
              >
                <div class="bg-n-10 py-2 pl-6 text-left text-xs font-bold">
                  budget line
                </div>
                <div
                  class="mt-2 border-b border-b-n-20 pl-6 text-xs"
                  v-for="(budget_line, j) in indicative.budget_line"
                  :key="j"
                >
                  <table>
                    <tr>
                      <td class="mb-1 flex flex-col text-xs font-bold">
                        {{ budget_line.budget }}
                      </td>
                    </tr>
                    <tr>
                      <td class="mb-1 text-n-40">Reference</td>
                      <td class="mb-1 pl-2">
                        {{ budget_line.reference }}
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
                              {{ narrative.language }}
                            </td>
                          </tr>
                          <tr>
                            <td class="pl-2">{{ narrative.narrative }}</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="flex flex-col"
              v-for="(committed, i) in recipient_region_budget.committed"
              :key="i"
            >
              <span class="element-title">{{ committed.committed }}</span>
              <span class="mb-1 text-sm">{{ committed.budget }}</span>
              <table class="table-head recipient-organisation">
                <tr>
                  <td>Value date</td>
                  <td>{{ committed.value_date }}</td>
                </tr>
                <tr>
                  <td>Vocabulary</td>
                  <td>{{ committed.vocabulary }}</td>
                </tr>
                <tr>
                  <td>Vocabulary_URI</td>
                  <td>
                    <a href="#">{{ committed.vocabulary_URI }}</a>
                  </td>
                </tr>
                <tr>
                  <td>Code</td>
                  <td>{{ committed.code }}</td>
                </tr>
                <tr class="flex">
                  <td class="pr-20 text-n-40">Description</td>
                  <td class="pl-2 leading-5 lg:w-[500px]">
                    <div class="language">
                      {{ committed.description.language }}
                    </div>
                    <span class="">{{ committed.description.text }}</span>
                  </td>
                </tr>
                <tr>
                  <td>Period</td>
                  <td>{{ committed.period }}</td>
                </tr>
              </table>
              <div
                class="mx-5 overflow-hidden rounded-tl-lg rounded-tr-lg border border-b-0 border-n-20"
              >
                <div class="bg-n-10 py-2 pl-6 text-left text-xs font-bold">
                  budget line
                </div>
                <div
                  class="mt-2 border-b border-b-n-20 pl-6 text-xs"
                  v-for="(budget_line, j) in committed.budget_line"
                  :key="j"
                >
                  <table>
                    <tr>
                      <td class="mb-1 flex flex-col text-xs font-bold">
                        {{ budget_line.budget }}
                      </td>
                    </tr>
                    <tr>
                      <td class="mb-1 text-n-40">Reference</td>
                      <td class="mb-1 pl-2">
                        {{ budget_line.reference }}
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
                              {{ narrative.language }}
                            </td>
                          </tr>
                          <tr>
                            <td class="pl-2">{{ narrative.narrative }}</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- recipient region budget ends -->

        <!-- recipient country budget -->
        <div v-if="title == 'recipient_country_budget'">
          <div
            v-for="(recipient_country_budget, index) in props.content"
            :key="index"
          >
            <div
              class="mb-4 flex flex-col"
              v-for="(indicative, i) in recipient_country_budget.indicative"
              :key="i"
            >
              <span class="element-title">{{ indicative.indicative }}</span>
              <span class="mb-1 text-sm">{{ indicative.budget }}</span>
              <div class="ml-5 flex"></div>
              <table class="table-head recipient-organisation">
                <tr>
                  <td>Value date</td>
                  <td>{{ indicative.value_date }}</td>
                </tr>
                <tr>
                  <td>Code</td>
                  <td>{{ indicative.code }}</td>
                </tr>
                <tr class="flex">
                  <td class="pr-20 text-n-40">Description</td>
                  <td class="pl-2 leading-5 lg:w-[500px]">
                    <div class="language">
                      {{ indicative.description.language }}
                    </div>
                    <span class="">{{ indicative.description.text }}</span>
                  </td>
                </tr>
                <tr>
                  <td>Period</td>
                  <td>{{ indicative.period }}</td>
                </tr>
              </table>
              <div
                class="mx-5 overflow-hidden rounded-tl-lg rounded-tr-lg border border-b-0 border-n-20"
              >
                <div class="bg-n-10 py-2 pl-6 text-left text-xs font-bold">
                  budget line
                </div>
                <div
                  class="mt-2 border-b border-b-n-20 pl-6 text-xs"
                  v-for="(budget_line, j) in indicative.budget_line"
                  :key="j"
                >
                  <table>
                    <tr>
                      <td class="mb-1 flex flex-col text-xs font-bold">
                        {{ budget_line.budget }}
                      </td>
                    </tr>
                    <tr>
                      <td class="mb-1 text-n-40">Reference</td>
                      <td class="mb-1 pl-2">
                        {{ budget_line.reference }}
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
                              {{ narrative.language }}
                            </td>
                          </tr>
                          <tr>
                            <td class="pl-2">{{ narrative.narrative }}</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="flex flex-col"
              v-for="(committed, i) in recipient_country_budget.committed"
              :key="i"
            >
              <span class="element-title">{{ committed.committed }}</span>
              <span class="mb-1 text-sm">{{ committed.budget }}</span>
              <table class="table-head recipient-organisation">
                <tr>
                  <td>Value date</td>
                  <td>{{ committed.value_date }}</td>
                </tr>
                <tr>
                  <td>Code</td>
                  <td>{{ committed.code }}</td>
                </tr>
                <tr class="flex">
                  <td class="pr-20 text-n-40">Description</td>
                  <td class="pl-2 leading-5 lg:w-[500px]">
                    <div class="language">
                      {{ committed.description.language }}
                    </div>
                    <span class="">{{ committed.description.text }}</span>
                  </td>
                </tr>
                <tr>
                  <td>Period</td>
                  <td>{{ committed.period }}</td>
                </tr>
              </table>
              <div
                class="mx-5 overflow-hidden rounded-tl-lg rounded-tr-lg border border-b-0 border-n-20"
              >
                <div class="bg-n-10 py-2 pl-6 text-left text-xs font-bold">
                  budget line
                </div>
                <div
                  class="mt-2 border-b border-b-n-20 pl-6 text-xs"
                  v-for="(budget_line, j) in committed.budget_line"
                  :key="j"
                >
                  <table>
                    <tr>
                      <td class="mb-1 flex flex-col text-xs font-bold">
                        {{ budget_line.budget }}
                      </td>
                    </tr>
                    <tr>
                      <td class="mb-1 text-n-40">Reference</td>
                      <td class="mb-1 pl-2">
                        {{ budget_line.reference }}
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
                              {{ narrative.language }}
                            </td>
                          </tr>
                          <tr>
                            <td class="pl-2">{{ narrative.narrative }}</td>
                          </tr>
                        </table>
                      </div>
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
          <div v-for="(total_expenditure, index) in props.content" :key="index">
            <div
              class="mb-4 flex flex-col"
              v-for="(indicative, i) in total_expenditure.indicative"
              :key="i"
            >
              <span class="element-title">{{ indicative.indicative }}</span>
              <span class="mb-1 text-sm">{{ indicative.budget }}</span>
              <table class="table-head">
                <tr>
                  <td>Period</td>
                  <td>{{ indicative.period }}</td>
                </tr>
                <tr>
                  <td>Value date</td>
                  <td>{{ indicative.value_date }}</td>
                </tr>
              </table>
              <div
                class="mx-5 overflow-hidden rounded-tl-lg rounded-tr-lg border border-b-0 border-n-20"
              >
                <div class="bg-n-10 py-2 pl-6 text-left text-xs font-bold">
                  budget line
                </div>
                <div
                  class="mt-2 border-b border-b-n-20 pl-6 text-xs"
                  v-for="(budget_line, j) in indicative.budget_line"
                  :key="j"
                >
                  <table>
                    <tr>
                      <td class="mb-1 flex flex-col text-xs font-bold">
                        {{ budget_line.budget }}
                      </td>
                    </tr>
                    <tr>
                      <td class="mb-1 text-n-40">Reference</td>
                      <td class="mb-1 pl-2">
                        {{ budget_line.reference }}
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
                              {{ narrative.language }}
                            </td>
                          </tr>
                          <tr>
                            <td class="pl-2">{{ narrative.narrative }}</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="flex flex-col"
              v-for="(committed, i) in total_expenditure.committed"
              :key="i"
            >
              <span class="element-title">{{ committed.committed }}</span>
              <span class="mb-1 text-sm">{{ committed.budget }}</span>
              <table class="table-head">
                <tr>
                  <td>Period</td>
                  <td>{{ committed.period }}</td>
                </tr>
                <tr>
                  <td>Value date</td>
                  <td>{{ committed.value_date }}</td>
                </tr>
              </table>
              <div
                class="mx-5 overflow-hidden rounded-tl-lg rounded-tr-lg border border-b-0 border-n-20"
              >
                <div class="bg-n-10 py-2 pl-6 text-left text-xs font-bold">
                  budget line
                </div>
                <div
                  class="mt-2 border-b border-b-n-20 pl-6 text-xs"
                  v-for="(budget_line, j) in committed.budget_line"
                  :key="j"
                >
                  <table>
                    <tr>
                      <td class="mb-1 flex flex-col text-xs font-bold">
                        {{ budget_line.budget }}
                      </td>
                    </tr>
                    <tr>
                      <td class="mb-1 text-n-40">Reference</td>
                      <td class="mb-1 pl-2">
                        {{ budget_line.reference }}
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
                              {{ narrative.language }}
                            </td>
                          </tr>
                          <tr>
                            <td class="pl-2">{{ narrative.narrative }}</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- total expenditure ends -->

        <!-- document link -->
        <div class="document-link text-xs" v-if="title == 'document_link'">
          <span class="text-sm font-bold text-n-50">{{
            props.content.document_title
          }}</span>
          <div class="ml-5 flex">
            <div class="w-[100px] text-xs text-n-40">Title</div>
            <table>
              <tr
                v-for="(title, i) in props.content.title"
                :key="i"
                class="flex flex-col pl-2"
              >
                <td class="language">
                  {{ title.language }}
                </td>
                <td>{{ title.document_link_title }}</td>
              </tr>
            </table>
          </div>
          <table class="table">
            <tr>
              <td>Document Link</td>
              <td>
                <a href="#">{{ props.content.link }}</a>
              </td>
            </tr>
          </table>
          <div class="ml-5 flex">
            <div class="w-[100px] pr-20 text-xs text-n-40">Description</div>
            <table>
              <tr
                v-for="(description, i) in props.content.description"
                :key="i"
                class="flex flex-col pl-2"
              >
                <td class="language">{{ description.language }}</td>
                <td class="lg:w-[500px]">
                  <p>{{ description.text }}</p>
                </td>
              </tr>
            </table>
          </div>
          <div class="ml-5 flex">
            <div class="w-[100px] text-xs text-n-40">Category</div>
            <div>
              <div
                v-for="(category, i) in props.content.category"
                :key="i"
                class="mb-1 pl-2"
              >
                <span>{{ category.A }}</span>
                <span>{{ category.B }}</span>
              </div>
            </div>
          </div>
          <table class="table">
            <tr>
              <td>Language</td>
              <td>{{ props.content.language }}</td>
            </tr>
          </table>
          <table class="table">
            <tr>
              <td>Document Date</td>
              <td>{{ props.content.document_date }}</td>
            </tr>
          </table>
          <div class="ml-5 flex">
            <div class="w-[100px] whitespace-nowrap pr-2 text-xs text-n-40">
              Recipient Country
            </div>
            <table>
              <tr
                v-for="(recipient_country, i) in props.content
                  .recipient_country"
                :key="i"
                class="flex flex-col pl-2"
              >
                <td>{{ recipient_country.country }}</td>
                <td class="language">{{ recipient_country.language }}</td>
                <td class="lg:w-[500px]">
                  <p>{{ recipient_country.text }}</p>
                </td>
              </tr>
            </table>
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

export default defineComponent({
  name: 'organisation-element',
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
      required: false,
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
  },
  setup(props) {
    const status = '';
    let layout = 'basis-6/12';
    if (props.width === 'full') {
      layout = 'basis-full';
    }

    return { layout, status, props };
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
