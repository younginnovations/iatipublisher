<template>
  <div
    id=""
    class="px-3 py-3 activities__content--element basis-full text-n-50"
  >
    <div :id="title" class="p-4 bg-white rounded-lg">
      <div class="flex mb-4">
        <div class="flex items-center title grow">
          <svg-vue class="mr-1.5 text-xl text-bluecoral" icon="bill"></svg-vue>
          <div class="text-sm font-bold title">
            {{ title.toString().replace(/_/g, '-') }}
          </div>
          <div
            class="status ml-2.5 flex text-xs leading-5 text-crimson-50"
            :class="{
              'text-spring-50': completed === true,
              'text-crimson-50': completed === false,
            }"
          >
            <b class="mr-2 text-base leading-3">.</b>
            <span v-if="completed">completed</span>
            <span v-else>not completed</span>
          </div>
        </div>
        <div class="flex items-center icons">
          <Btn
            text="Add New Result"
            icon="add"
            :link="`/activities/${activityId}/${title}/create`"
            class="mr-2.5"
          />
          <Btn
            text="Show full result list"
            icon=""
            design="bgText"
            :link="`/activities/${activityId}/${title}`"
            class="mr-2.5"
          />
          <svg-vue class="mr-1.5" icon="core"></svg-vue>
          <div class="help text-n-40">
            <button>
              <svg-vue icon="help"></svg-vue>
            </button>
            <div class="right-0 help__text w-60">
              <span class="font-bold text-bluecoral"></span>
              {{ tooltip }}
            </div>
          </div>
        </div>
      </div>
      <div class="w-full h-px mb-4 divider bg-n-20"></div>
      <div class="results">
        <template v-for="(result, r) in resultData" :key="r">
          <div
            class="item"
            :class="{
              'mb-4': r !== data.content.length - 1,
            }"
          >
            <div class="elements-detail">
              <div>
                <!-- title -->
                <div class="flex category">
                  <div class="mr-4">
                    {{
                      getActivityTitle(result.result.title[0].narrative, 'en')
                    }}
                  </div>
                  <div class="flex shrink-0">
                    <Btn
                      text="View Result"
                      icon="eye"
                      :link="`/activities/${activityId}/${title}/${result.id}`"
                      class="mr-2.5"
                    />
                    <Btn
                      text="Edit Result"
                      icon="edit"
                      :link="`/activities/${activityId}/${title}/${result.id}/edit`"
                    />
                  </div>
                </div>
                <!-- content -->
                <div class="ml-4">
                  <table
                    :class="{
                      'mb-3': result.indicators.length > 0,
                    }"
                  >
                    <tr>
                      <td>Result Type</td>
                      <td>
                        <div class="text-sm description">
                          {{ types.resultType[result.result.type] }}
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Description</td>
                      <td>
                        <div class="description-content">
                          <div class="language mb-1.5">(Language: en)</div>
                          <div class="w-[500px] max-w-full text-sm">
                            {{
                              getActivityTitle(
                                result.result.description[0].narrative,
                                'en'
                              )
                            }}
                          </div>
                        </div>
                      </td>
                    </tr>
                  </table>

                  <!-- indicator -->
                  <div
                    v-if="result.indicators.length > 0"
                    class="overflow-hidden border rounded-t-lg indicator border-n-20"
                  >
                    <div
                      class="flex items-center px-6 py-2 border-b head border-n-20"
                    >
                      <div class="text-xs font-bold grow text-n-50">
                        Indicator
                      </div>
                      <div class="inline-flex shrink-0">
                        <Btn
                          text="Add New Indicator"
                          icon="add"
                          :link="`/activities/${activityId}/${title}/${result.id}/indicator/create`"
                          class="mr-2.5"
                        />
                        <Btn
                          text="Show full indicator list"
                          icon=""
                          design="bgText"
                          :link="`/activities/${activityId}/${title}/${result.id}/indicator`"
                        />
                      </div>
                    </div>
                    <div class="body">
                      <template
                        v-for="(indicator, i) in result.indicators"
                        :key="i"
                      >
                        <div
                          class="flex px-6 py-2 indicator-content"
                          :class="{
                            'mb-2 border-b border-n-20':
                              i !== result.indicators.length - 1,
                          }"
                        >
                          <div class="elements-detail grow">
                            <div class="flex category">
                              <div class="mr-4">
                                {{
                                  indicator.indicator.title[0].narrative[0]
                                    .narrative
                                }}
                              </div>
                              <div class="flex justify-between shrink-0 grow">
                                <Btn
                                  text="Edit Indicator"
                                  :link="`/activities/${activityId}/${title}/${result.id}/indicator/${indicator.id}/edit`"
                                  class="mr-2.5"
                                />
                                <Btn
                                  text="Add Period"
                                  icon="add"
                                  :link="`/activities/${activityId}/${title}/${result.id}/indicator/${indicator.id}/period/create`"
                                />
                              </div>
                            </div>
                            <table>
                              <tr>
                                <td>Baseline:</td>
                                <td>
                                  <div
                                    v-for="(
                                      baseline, b
                                    ) in indicator.indicator.baseline
                                      .reverse()
                                      .slice(0, 2)"
                                    :key="b"
                                    class=""
                                    :class="{
                                      'mb-1':
                                        b !==
                                        indicator.indicator.baseline.length - 1,
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
                                  </div>
                                </td>
                              </tr>
                              <tr v-if="indicator.periods.length > 0">
                                <td>Period:</td>
                                <td>
                                  <div
                                    v-for="(period, p) in indicator.periods"
                                    :key="p"
                                    class=""
                                    :class="{
                                      'mb-1':
                                        p !== indicator.periods.length - 1,
                                    }"
                                  >
                                    <div class="text-xs description">
                                      {{
                                        moment(
                                          period.period.period_start[0].date
                                        ).format(format)
                                      }}
                                      -
                                      {{
                                        moment(
                                          period.period.period_end[0].date
                                        ).format(format)
                                      }}
                                    </div>
                                  </div>
                                </td>
                              </tr>
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

// composable
import getActivityTitle from 'Composable/title';

export default defineComponent({
  name: 'ActivityResult',
  components: {
    Btn,
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
    const format = 'MMMM DD, YYYY';

    const { data } = toRefs(props);

    let resultData = data.value.content.reverse().slice(0, 4);

    return { moment, format, resultData, getActivityTitle };
  },
});
</script>
