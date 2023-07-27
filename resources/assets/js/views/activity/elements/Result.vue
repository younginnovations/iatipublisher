<template>
  <div
    id=""
    class="activities__content--element basis-full px-3 py-3 text-n-50"
  >
    <div :id="title" class="rounded-lg bg-white p-4">
      <div class="mb-4 flex">
        <div class="title flex grow items-center">
          <svg-vue class="mr-1.5 text-xl text-bluecoral" icon="bill"></svg-vue>
          <div class="title result-translate-text text-sm font-bold">
            {{ translate.elementFromElementName(title.toString()) }}
          </div>
          <div
            class="status ml-2.5 flex text-xs leading-5"
            :class="{
              'text-spring-50': completed,
              'text-crimson-50': !completed,
            }"
          >
            <b class="mr-2 text-base leading-3">.</b>
            <span v-if="completed" class="result-translate-text">{{
              translate.commonText('completed')
            }}</span>
            <span v-else class="result-translate-text">{{
              translate.commonText('not_completed')
            }}</span>
          </div>
        </div>
        <div class="icons flex items-center">
          <Btn
            :text="translate.button('add_element', 'common.new_result')"
            icon="add"
            :link="`/activity/${activityId}/${title}/create`"
            class="mr-2.5"
          />
          <Btn
            :text="translate.button('show_element', 'common.full_result')"
            icon=""
            design="bgText"
            :link="`/activity/${activityId}/${title}`"
            class="mr-2.5"
          />
          <svg-vue class="mr-1.5" icon="core"></svg-vue>
          <HoverText
            :name="title.toString().replace(/_/g, '-')"
            :hover-text="tooltip"
            :show-iati-reference="true"
            class="text-sm text-n-40"
          ></HoverText>
        </div>
      </div>
      <div class="divider mb-4 h-px w-full bg-n-20"></div>
      <div class="results">
        <template v-for="(result, r) in resultData" :key="r">
          <div class="item">
            <div class="elements-detail">
              <div>
                <!-- title -->
                <div class="category flex">
                  <div
                    class="mr-4 max-w-[500px] overflow-x-hidden text-ellipsis whitespace-nowrap"
                  >
                    {{
                      getActivityTitle(result.result.title[0].narrative, 'en')
                    }}
                  </div>
                  <div class="flex shrink-0">
                    <Btn
                      :text="translate.button('view_element', 'common.result')"
                      icon="eye"
                      :link="`/activity/${activityId}/${title}/${result.id}`"
                      class="mr-2.5"
                    />
                    <Btn
                      :text="translate.button('edit_element', 'common.result')"
                      icon="edit"
                      :link="`/activity/${activityId}/${title}/${result.id}/edit`"
                    />
                  </div>
                </div>
                <!-- content -->
                <div class="ml-4">
                  <table class="mb-3">
                    <tbody>
                      <tr>
                        <td class="result-translate-text">
                          {{ translate.commonText('result_type') }}
                        </td>
                        <td>
                          <div class="result-translate-text">
                            {{
                              types.resultType[result.result.type] ??
                              translate.missingText()
                            }}
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="result-translate-text">
                          {{ translate.commonText('description') }}
                        </td>
                        <td>
                          <div class="description-content">
                            <div class="language mb-1.5">
                              ({{ translate.commonText('language') }}:
                              {{
                                getActivityTitle(
                                  result.result.description[0].narrative,
                                  currentLanguage
                                ) === 'Untitled'
                                  ? translate.missingText()
                                  : types.languages[
                                      result?.result?.description?.[0]
                                        ?.narrative?.[0]?.language ??
                                        defaultLanguage ??
                                        'en'
                                    ]
                              }})
                            </div>
                            <div class="w-[500px] max-w-full">
                              {{
                                getActivityTitle(
                                  result.result.description[0].narrative,
                                  currentLanguage
                                )
                              }}
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr v-if="result.indicators.length === 0">
                        <td></td>
                        <td>
                          <div>
                            <NotYet
                              :link="`/${title}/${result.id}/indicator/create`"
                              :description="
                                translate.button('not_yet_added_period')
                              "
                              :btn-text="
                                translate.button('not_yet_added_period_btn')
                              "
                            />
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>

                  <!-- indicator -->
                  <div
                    v-if="result.indicators.length > 0"
                    class="indicator overflow-hidden rounded-t-lg border border-n-20"
                  >
                    <div
                      class="head flex items-center border-b border-n-20 px-6 py-2"
                    >
                      <div
                        class="result-translate-text grow text-xs font-bold text-n-50"
                      >
                        {{ translate.commonText('indicator') }}
                      </div>
                      <div class="inline-flex shrink-0">
                        <Btn
                          :text="
                            translate.button(
                              'add_element',
                              'common.new_indicator'
                            )
                          "
                          icon="add"
                          :link="`/${title}/${result.id}/indicator/create`"
                          class="mr-2.5"
                        />
                        <Btn
                          :text="
                            translate.button(
                              'show_element',
                              'common.full_indicator'
                            )
                          "
                          icon=""
                          design="bgText"
                          :link="`/${title}/${result.id}/indicator`"
                        />
                      </div>
                    </div>
                    <div>
                      <template
                        v-for="(indicator, i) in result.indicators"
                        :key="i"
                      >
                        <div
                          class="indicator-content flex px-6 py-2"
                          :class="{
                            'mb-2 border-b border-n-20':
                              i !== result.indicators.length - 1,
                          }"
                        >
                          <div class="elements-detail grow">
                            <div class="category flex">
                              <div class="mr-4">
                                {{
                                  indicator.indicator.title[0].narrative[0]
                                    .narrative ??
                                  translate.commonText('untitled')
                                }}
                              </div>
                              <div class="flex shrink-0 grow justify-between">
                                <span class="flex">
                                  <Btn
                                    :text="
                                      translate.button(
                                        'view_element',
                                        'common.indicator'
                                      )
                                    "
                                    icon="eye"
                                    :link="`/${title}/${result.id}/indicator/${indicator.id}`"
                                    class="mr-2.5"
                                  />
                                  <Btn
                                    :text="
                                      translate.button(
                                        'edit_element',
                                        'common.indicator'
                                      )
                                    "
                                    :link="`/${title}/${result.id}/indicator/${indicator.id}/edit`"
                                    class="mr-2.5"
                                  />
                                </span>
                                <Btn
                                  :text="
                                    translate.button(
                                      'add_element',
                                      'common.period'
                                    )
                                  "
                                  icon="add"
                                  :link="`/indicator/${indicator.id}/period/create`"
                                />
                              </div>
                            </div>
                            <table>
                              <tbody>
                                <tr>
                                  <td class="result-translate-text">
                                    {{ translate.commonText('baseline') }}:
                                  </td>
                                  <td>
                                    <div
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
                                      <div class="description text-xs">
                                        <span class="result-translate-text">
                                          {{ translate.commonText('value') }}:
                                          <template v-if="baseline.value">
                                            {{ baseline.value }},
                                          </template>
                                          <template v-else>
                                            {{ translate.missingText() }},
                                          </template>
                                        </span>
                                        <span>
                                          {{ translate.commonText('date') }}:
                                          <template v-if="baseline.date">
                                            {{ baseline.date }}
                                          </template>
                                          <template v-else>
                                            {{ translate.missingText() }}
                                          </template>
                                        </span>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                                <tr v-if="indicator.periods.length > 0">
                                  <td class="result-translate-text">
                                    {{ translate.commonText('period') }}:
                                  </td>
                                  <td>
                                    <div class="inline-flex gap-4">
                                      <div>
                                        <div
                                          v-for="(
                                            period, p
                                          ) in indicator.periods"
                                          :key="p"
                                          class="flex"
                                          :class="{
                                            'mb-1':
                                              p !==
                                              indicator.periods.length - 1,
                                          }"
                                        >
                                          <div class="text-xs">
                                            <a
                                              class="text-xs text-n-50"
                                              :href="`/indicator/${indicator.id}/period/${period.id}`"
                                            >
                                              {{
                                                dateFormat(
                                                  period.period.period_start[0]
                                                    .date,
                                                  format
                                                )
                                              }}
                                              -
                                              {{
                                                dateFormat(
                                                  period.period.period_end[0]
                                                    .date,
                                                  format
                                                )
                                              }}
                                            </a>
                                          </div>
                                          <div class="ml-2">
                                            <Btn
                                              :text="translate.button('edit')"
                                              icon="edit"
                                              :link="`/indicator/${indicator.id}/period/${period.id}/edit`"
                                            />
                                          </div>
                                        </div>
                                      </div>
                                      <div class="shrink-0">
                                        <Btn
                                          class="-mt-1"
                                          :text="
                                            translate.button('show_full_period')
                                          "
                                          icon=""
                                          design="bgText"
                                          :link="`/indicator/${indicator.id}/period`"
                                        />
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                                <tr v-else>
                                  <td></td>
                                  <td>
                                    <div>
                                      <NotYet
                                        :link="`/indicator/${indicator.id}/period/create`"
                                        :description="
                                          translate.button(
                                            'not_yet_added_period'
                                          )
                                        "
                                      />
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </template>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div
            v-if="r !== data.content.length - 1"
            class="divider my-5 h-px w-full border-b border-n-20"
          ></div>
        </template>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import moment from 'moment';

//components
import Btn from 'Components/buttons/Link.vue';
import NotYet from 'Components/sections/HaveNotAddedYet.vue';

// composable
import getActivityTitle from 'Composable/title';
import dateFormat from 'Composable/dateFormat';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  name: 'ActivityResult',
  components: {
    Btn,
    NotYet,
  },
  props: {
    data: {
      type: Object,
      required: true,
    },
    activityId: {
      type: Number,
      required: true,
    },
    title: {
      type: String,
      required: true,
    },
    tooltip: {
      type: String,
      required: false,
      default: '',
    },
    defaultLanguage: {
      type: String,
      required: false,
      default: '',
    },
    types: {
      type: Object,
      required: true,
    },
    completed: {
      type: Boolean,
      required: true,
    },
  },
  setup(props) {
    const translate = new Translate();
    const format = 'MMMM DD, YYYY';

    const { data } = toRefs(props);

    let resultData = data.value.content;

    const currentLanguage = 'en';

    return {
      moment,
      format,
      resultData,
      getActivityTitle,
      currentLanguage,
      dateFormat,
      translate,
    };
  },
});
</script>
