<template>
  <div class="activities__content--element px-3 py-3" :class="layout">
    <div class="rounded-lg bg-white p-4">
      <div class="mb-4 flex">
        <div class="title flex grow">
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
        <div class="icons flex items-center">
          <a
            :href="'organisation/' + title"
            class="
              edit-button
              mr-2.5
              flex
              items-center
              text-xs
              font-bold
              uppercase
            "
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
        <!--Organization Identifier -->
        <template v-if="title === 'organisation_identifier'">
          <div class="identifier-content">
            <div v-if="data.content.iati_identifier_text" class="text-sm">
              <span class="whitespace-pre">{{
                data.content.organization_identifer
              }}</span>
            </div>
          </div>
        </template>

        <!-- Organization Name -->
        <div v-if="title == 'name'">
          <div v-for="(post, i) in data.content" :key="i" class="title-content">
            <div v-if="post.narrative" class="flex flex-col">
              <span v-if="post.language" class="language mb-1.5">
                (Language: {{ types.languages[post.language] }})
              </span>
              <span v-if="post.narrative" class="description text-sm">
                {{ post.narrative }}
              </span>
            </div>
            <span v-else class="text-sm italic">Title Not Available</span>
            <div v-if="i !== data.content.length - 1" class="mb-4"></div>
          </div>
        </div>

        <!-- Reporting Org -->
        <div v-if="title == 'reporting_org'" class="language">
          {{ content }}
        </div>
        <div v-if="title == 'reporting_org'">
          {{ content.narrative }}
        </div>

        <!-- total budget -->
        <div v-if="title == 'total_budget'">
          <template v-for="(total_budget, index) in content" :key="index">
            <div class="item">
              <div class="elements-detail">
                <div>
                  <!-- title -->
                  <div class="flex category">
                    <div class="mr-4">
                      {{ types.budgetType[total_budget.total_budget_status] }}
                    </div>
                  </div>
                  <!-- content -->
                  <div class="ml-4">
                    <table class="mb-3">
                      <tr>
                        <td>Title</td>
                        <td>
                          <!-- <template
                          v-for="(ti, t) in result.result.title[0].narrative"
                          :key="t"
                        >
                          <div
                            class="title-content"
                            :class="{
                              'mb-4':
                                t !==
                                result.result.title[0].narrative.length - 1,
                            }"
                          >
                            <div class="language mb-1.5">
                              (Language: {{ ti.language }})
                            </div>
                            <div class="text-sm description">
                              {{ ti.narrative }}
                            </div>
                          </div>
                        </template> -->
                        </td>
                      </tr>
                      <tr>
                        <td>Period</td>
                        <td>
                          <div class="text-sm description">
                            <!-- {{
                              moment(period.period.period_start[0].date).format(
                                format
                              )
                            }}
                            -
                            {{
                                          moment(
                                            period.period.period_end[0].date
                                          ).format(format) {{
                                          moment(
                                            period.period.period_start[0].date
                                          ).format(format)
                            }}
                            -
                            {{
                              moment(period.period.period_end[0].date).format(
                                format
                              )
                            }}
                            }} -->
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Description</td>
                        <td>
                          <!-- <template
                            v-for="(description, t) in result.result
                              .description[0].narrative"
                            :key="t"
                          >
                            <div
                              class="description-content"
                              :class="{
                                'mb-4':
                                  t !==
                                  result.result.description[0].narrative
                                    .length -
                                    1,
                              }"
                            >
                              <div class="language mb-1.5">
                                (Language: {{ description.language }})
                              </div>
                              <div class="text-sm description">
                                {{ description.narrative }}
                              </div>
                            </div>
                          </template> -->
                        </td>
                      </tr>
                    </table>

                    <!-- indicator -->
                    <div
                      v-for="(budget_line, j) in total_budget.budget_line"
                      :key="j"
                      class="
                        overflow-hidden
                        border
                        rounded-t-lg
                        indicator
                        border-n-20
                      "
                    >
                      <div class="head flex justify-between py-2.5 px-6">
                        <div class="text-xs font-bold text-n-50">
                          budget_line
                        </div>
                      </div>
                      <div class="body">
                        <!-- <template
                          v-for="(indicator, i) in result.indicators"
                          :key="i"
                        >
                          <div
                            class="flex px-6 py-2 indicator-content"
                            :class="{
                              'mb-2 border-b border-n-20':
                                r !== result.indicators.length - 1,
                            }"
                          > -->
                        <div class="elements-detail wider grow">
                          <table>
                            <tr>
                              <td>Baseline:</td>
                              <td>
                                <!-- <div
                                      v-for="(baseline, b) in indicator
                                        .indicator.baseline"
                                      :key="b"
                                      class=""
                                      :class="{
                                        'mb-1':
                                          b !==
                                          indicator.indicator.baseline.length -
                                            1,
                                      }"
                                    >
                                      <div class="text-xs description">
                                        <span>
                                          Value:
                                          <template v-if="baseline.value">
                                            {{ baseline.value }},
                                          </template>
                                          <template v-else>
                                            Not Available,
                                          </template>
                                        </span>
                                        <span>
                                          Date:
                                          <template v-if="baseline.date">
                                            {{ baseline.date }}
                                          </template>
                                          <template v-else>
                                            Not Available
                                          </template>
                                        </span>
                                      </div>
                                    </div> -->
                              </td>
                            </tr>
                            <!-- <tr v-if="indicator.periods.length > 0">
                              <td>Period:</td>
                              <td>
                                <div
                                  v-for="(period, p) in indicator.periods"
                                  :key="p"
                                  class=""
                                  :class="{
                                    'mb-1': p !== indicator.periods.length - 1,
                                  }"
                                >
                                  <div class="text-xs description"></div>
                                </div>
                              </td>
                            </tr> -->
                          </table>
                        </div>
                        <!-- </div>
                        </template> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </template>
          <!-- <div v-if="title == 'total_budget'">
            <div
              v-for="(total_budget, index) in content"
              :key="index"
              class="flex flex-col"
            >
              <div
                id=""
                class="
                  px-3
                  py-3
                  activities__content--element
                  basis-full
                  text-n-50
                "
              >
                <div></div>
                <span
                  class="element-title"
                  v-if="total_budget.total_budget_status"
                >
                  {{ types.budgetType[total_budget.total_budget_status] }}
                </span>
                <span class="mb-1 text-sm"
                  >{{ total_budget.value['0'].amount }}
                  {{ total_budget.value['0'].currency }}</span
                >
                <div
                  v-for="(budget_line, j) in total_budget.budget_line"
                  :key="j"
                >
                  <table class="table-head">
                    <tr>
                      <td>Period</td>
                      <td>
                        {{ total_budget.period_start['0'].date }} -
                        {{ total_budget.period_end['0'].date }}
                      </td>
                    </tr>
                    <tr>
                      <td>Value date</td>
                      <td>{{ total_budget.value['0'].value_date }}</td>
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
                    <div class="elements-detail">
                      <div class="flex category">
                        <div>{{ budget_line.budget }}</div>
                      </div>
                      <div class="ml-4">
                        <table>
                          <tr>
                            <td>
                              {{ budget_line.budget }}
                            </td>
                          </tr>
                          <tr>
                            <td>Reference</td>
                            <td>
                              {{ budget_line.reference }}
                            </td>
                          </tr>
                          <tr>
                            <td>Value</td>
                            <td>
                              {{ budget_line.value }}
                            </td>
                          </tr>
                        </table>
                      </div>
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
                        <tr>
                          <td class="mb-1 text-n-40">Value</td>
                          <td class="mb-1 pl-2">
                            {{ budget_line.value }}
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
          </div> -->
        </div>
        <!-- total budget ends-->

        <!-- recipient organisation budget -->
        <div v-if="title == 'recipient_org_budget'">
          <!-- {{content}} -->
          <div
            v-for="(recipient_org_budget, index) in content"
            :key="index"
            class="mt-5 flex flex-col"
          >
            <!-- {{ recipient_org_budget }} -->
            <span class="element-title">{{ recipient_org_budget.status }}</span>
            <!-- <span class="mb-1 text-sm">{{ recipient_org_budget.budget }}</span> -->
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
                <!-- {{recipient_org}} -->
                <tr
                  class="recipient-organisation flex flex-col whitespace-nowrap"
                >
                  <td>Reference-{{ recipient_org.ref }}</td>
                  <!-- {{recipient_org.narrative}} -->
                  <td
                    v-for="(
                      org_narrative, narrative_index
                    ) in recipient_org.narrative"
                    :key="narrative_index"
                    class="flex flex-col"
                  >
                    <span class="language"
                      >(Language: {{ org_narrative.language }})</span
                    >
                    <span>{{ org_narrative.narrative }}</span>
                  </td>
                  <!-- <td>{{ indicative.recipient_org.cash }}</td> -->
                </tr>
              </table>
            </div>
            <table class="table-head recipient-organisation">
              <tr>
                <td>Value</td>
                <td>
                  {{ recipient_org_budget.value['0'].amount }}
                  {{ recipient_org_budget.value['0'].currency }} ({{
                    recipient_org_budget.value['0'].value_date
                  }})
                </td>
              </tr>
              <tr>
                <td>Period</td>
                <td>
                  {{ recipient_org_budget.period_start['0'].date }} -
                  {{ recipient_org_budget.period_start['0'].iso_date }}
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
                      {{ budget_line.ref }}
                    </td>
                  </tr>
                  <tr>
                    <td class="mb-1 text-n-40">Value date</td>
                    <td class="mb-1 pl-2">
                      {{ budget_line.value['0'].value_date }}
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
        <!-- recipient organisation budget ends -->

        <!-- recipient region budget -->
        <div v-if="title == 'recipient_region_budget'">
          <div v-for="(recipient_region_budget, index) in content" :key="index">
            {{ recipient_region_budget }}
            <span class="element-title">{{
              recipient_region_budget.recipient_region_budget
            }}</span>
            <span class="mb-1 text-sm">{{
              recipient_region_budget.budget
            }}</span>
            <table class="table-head recipient-organisation">
              <tr>
                <td>Value date</td>
                <td>{{ recipient_region_budget.value['0'].value_date }}</td>
              </tr>
              <tr>
                <td>Vocabulary</td>
                <td>{{ recipient_region_budget.vocabulary }}</td>
              </tr>
              <tr>
                <td>Vocabulary_URI</td>
                <td>
                  <a href="#">{{ recipient_region_budget.vocabulary_URI }}</a>
                </td>
              </tr>
              <tr>
                <td>Code</td>
                <td>{{ recipient_region_budget.code }}</td>
              </tr>
              <tr class="flex">
                <td class="pr-20 text-n-40">Description</td>
                <td class="pl-2 leading-5 lg:w-[500px]">
                  <div class="language">
                    <!-- {{ recipient_region_budget.description.language }} -->
                  </div>
                  <!-- <span class="">{{ recipient_region_budget.description.text }}</span> -->
                </td>
              </tr>
              <tr>
                <td>Period</td>
                <td>{{ recipient_region_budget.period }}</td>
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
        <!-- recipient region budget ends -->

        <!-- recipient country budget -->
        <div v-if="title == 'recipient_country_budget'">
          <div
            v-for="(recipient_country_budget, index) in content"
            :key="index"
          >
            <span class="element-title">{{
              recipient_country_budget.recipient_country_budget
            }}</span>
            <span class="mb-1 text-sm">{{
              recipient_country_budget.budget
            }}</span>
            <div class="ml-5 flex"></div>
            <table class="table-head recipient-organisation">
              <tr>
                <td>Value date</td>
                <td>{{ recipient_country_budget.value_date }}</td>
              </tr>
              <tr>
                <td>Code</td>
                <td>{{ recipient_country_budget.code }}</td>
              </tr>
              <tr class="flex">
                <td class="pr-20 text-n-40">Description</td>
                <td class="pl-2 leading-5 lg:w-[500px]">
                  <div class="language">
                    {{ recipient_country_budget.description.language }}
                  </div>
                  <span class="">{{
                    recipient_country_budget.description.text
                  }}</span>
                </td>
              </tr>
              <tr>
                <td>Period</td>
                <td>{{ recipient_country_budget.period }}</td>
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
                v-for="(budget_line, j) in indicative.budget_line"
                :key="j"
                class="mt-2 border-b border-b-n-20 pl-6 text-xs"
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
        <!-- recipient country budget ends -->

        <!-- total expenditure -->
        <div v-if="title == 'total_expenditure'">
          <div v-for="(total_expenditure, index) in content" :key="index">
            <span class="element-title">{{ total_expenditure.status }}</span>
            <!-- <span class="mb-1 text-sm">{{ total_expenditure.budget }}</span> -->
            <table class="table-head">
              <tr>
                <td>Period</td>
                <td>{{ total_expenditure.period }}</td>
              </tr>
              <tr>
                <td>Value date</td>
                <td>{{ total_expenditure.value }}</td>
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
                v-for="(budget_line, j) in total_expenditure.budget_line"
                :key="j"
                class="mt-2 border-b border-b-n-20 pl-6 text-xs"
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
        <!-- total expenditure ends -->

        <!-- document link -->
        <div v-if="title == 'document_link'" class="document-link text-xs">
          <span class="text-sm font-bold text-n-50">{{
            content.document_title
          }}</span>
          <div class="ml-5 flex">
            <div class="w-[100px] text-xs text-n-40">Title</div>
            <table>
              <tr
                v-for="(title, i) in content.title"
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
                <a href="#">{{ content.link }}</a>
              </td>
            </tr>
          </table>
          <div class="ml-5 flex">
            <div class="w-[100px] pr-20 text-xs text-n-40">Description</div>
            <table>
              <tr
                v-for="(description, i) in content.description"
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
                v-for="(category, i) in content.category"
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
              <td>{{ content.language }}</td>
            </tr>
          </table>
          <table class="table">
            <tr>
              <td>Document Date</td>
              <td>{{ content.document_date }}</td>
            </tr>
          </table>
          <div class="ml-5 flex">
            <div class="w-[100px] whitespace-nowrap pr-2 text-xs text-n-40">
              Recipient Country
            </div>
            <table>
              <tr
                v-for="(recipient_country, i) in content.recipient_country"
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
    types: {
      type: Object,
      required: true,
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

    console.log(props.content);

    return { layout, status, props };
  },
});
</script>

<!-- <style lang="scss" scoped>
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
</style> -->
