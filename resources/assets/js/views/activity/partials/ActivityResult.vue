<template>
  <div
    class="activities__content--element basis-full px-3 py-3 text-n-50"
    id=""
  >
    <div class="rounded-lg bg-white p-4" :id="title">
      <div class="mb-4 flex">
        <div class="title flex grow items-center">
          <svg-vue class="mr-1.5 text-xl text-bluecoral" icon="bill"></svg-vue>
          <div class="title text-sm font-bold">
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
        <div class="icons flex items-center">
          <a
            :href="`/activities/${activityId}/${title}/create`"
            class="mr-2.5 flex items-center text-tiny font-bold uppercase"
          >
            <svg-vue class="mr-0.5 text-base" icon="add"></svg-vue>
            <span>Add Result</span>
          </a>
          <svg-vue class="mr-1.5" icon="core"></svg-vue>
          <HoverText
            hover_text="example text"
            class="text-sm text-n-40"
          ></HoverText>
        </div>
      </div>
      <div class="divider mb-4 h-px w-full bg-n-20"></div>
      <div class="results">
        <template v-for="(result, r) in results" :key="r">
          <div
            class="item"
            :class="{
              'mb-4': r !== results.length - 1,
            }"
          >
            <div class="elements-detail">
              <div>
                <!-- title -->
                <div class="category flex">
                  <div class="mr-4">
                    {{ result.result.title[0].narrative[0].narrative }}
                  </div>
                  <div class="flex shrink-0">
                    <a
                      :href="`/activities/${activityId}/${title}/${result.id}`"
                      class="mr-2.5 flex items-center text-tiny font-bold uppercase text-bluecoral"
                    >
                      <svg-vue class="mr-0.5 text-base" icon="eye"></svg-vue>
                      <span>View Result</span>
                    </a>
                    <a
                      :href="`/activities/${activityId}/${title}/${result.id}/edit`"
                      class="flex items-center text-tiny font-bold uppercase"
                    >
                      <svg-vue class="mr-0.5 text-base" icon="edit"></svg-vue>
                      <span>Edit Result</span>
                    </a>
                  </div>
                </div>
                <!-- content -->
                <div class="ml-4">
                  <table class="mb-3">
                    <tr>
                      <td>Title</td>
                      <td>
                        <template
                          v-for="(title, t) in result.result.title[0].narrative"
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
                              (Language: {{ title.language }})
                            </div>
                            <div class="description text-sm">
                              {{ title.narrative }}
                            </div>
                          </div>
                        </template>
                      </td>
                    </tr>
                    <tr>
                      <td>Result Type</td>
                      <td>
                        <div class="description text-sm">
                          {{ types.resultType[result.result.type] }}
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Description</td>
                      <td>
                        <template
                          v-for="(description, t) in result.result
                            .description[0].narrative"
                          :key="t"
                        >
                          <div
                            class="description-content"
                            :class="{
                              'mb-4':
                                t !==
                                result.result.description[0].narrative.length -
                                  1,
                            }"
                          >
                            <div class="language mb-1.5">
                              (Language: {{ description.language }})
                            </div>
                            <div class="description text-sm">
                              {{ description.narrative }}
                            </div>
                          </div>
                        </template>
                      </td>
                    </tr>
                  </table>

                  <!-- indicator -->
                  <div
                    class="indicator overflow-hidden rounded-t-lg border border-n-20"
                  >
                    <div class="head flex justify-between bg-n-10 py-2.5 px-6">
                      <div class="text-xs font-bold text-n-50">Indicator</div>
                      <div>
                        <a
                          :href="`/activities/${activityId}/${title}/${result.id}/indicator/create`"
                          class="flex items-center text-tiny font-bold uppercase"
                        >
                          <svg-vue
                            class="mr-0.5 text-base"
                            icon="add"
                          ></svg-vue>
                          <span>Add New Indicator</span>
                        </a>
                      </div>
                    </div>
                    <div class="body">
                      <template
                        v-for="(indicator, i) in result.indicators"
                        :key="i"
                      >
                        <div
                          class="indicator-content flex px-6 py-2"
                          :class="{
                            'mb-2 border-b border-n-20':
                              r !== result.indicators.length - 1,
                          }"
                        >
                          <div class="elements-detail wider grow">
                            <div class="category flex">
                              <div class="mr-4">
                                {{
                                  indicator.indicator.title[0].narrative[0]
                                    .narrative
                                }}
                              </div>
                              <div class="flex shrink-0 grow justify-between">
                                <a
                                  :href="`/activities/${activityId}/${title}/${result.id}/indicator/${indicator.id}/edit`"
                                  class="mr-2.5 flex items-center text-tiny font-bold uppercase text-bluecoral"
                                >
                                  <svg-vue
                                    class="mr-0.5 text-base"
                                    icon="edit"
                                  ></svg-vue>
                                  <span>Edit Indicator</span>
                                </a>
                                <a
                                  :href="`/activities/${activityId}/${title}/${result.id}/indicator/${indicator.id}/period/create`"
                                  class="mr-2.5 flex items-center text-tiny font-bold uppercase text-bluecoral"
                                >
                                  <svg-vue
                                    class="mr-0.5 text-base"
                                    icon="add"
                                  ></svg-vue>
                                  <span>Add Period</span>
                                </a>
                              </div>
                            </div>
                            <table>
                              <tr>
                                <td>Baseline:</td>
                                <td>
                                  <div
                                    class=""
                                    v-for="(baseline, b) in indicator.indicator
                                      .baseline"
                                    :key="b"
                                    :class="{
                                      'mb-1':
                                        b !==
                                        indicator.indicator.baseline.length - 1,
                                    }"
                                  >
                                    <div class="description text-xs">
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
                                    class=""
                                    v-for="(period, p) in indicator.periods"
                                    :key="p"
                                    :class="{
                                      'mb-1':
                                        p !== indicator.periods.length - 1,
                                    }"
                                  >
                                    <div class="description text-xs">
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
import { defineComponent } from 'vue';
import HoverText from '../../../components/HoverText.vue';
import moment from 'moment';

export default defineComponent({
  name: 'activity-result',
  components: {
    HoverText,
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
    const results = props.data.content,
      format = 'MMMM DD, YYYY';

    console.log(results);
    return { results, moment, format };
  },
});
</script>
