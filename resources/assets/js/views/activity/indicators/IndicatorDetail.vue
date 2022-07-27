<template>
  <div class="bg-paper px-10 pt-4 pb-[71px]">
    <div class="mb-6 page-title">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="mb-4 text-caption-c1 text-n-40">
            <nav aria-label="breadcrumbs" class="breadcrumb">
              <div class="flex">
                <a href="/activities" class="font-bold">Your Activities</a>
                <span class="mx-4 separator"> / </span>
                <div class="breadcrumb__title">
                  <span class="overflow-hidden breadcrumb__title text-n-30">
                    <a :href="`/activities/${activity.id}`">
                      {{ activityTitle ?? 'Untitled' }}
                    </a>
                  </span>
                  <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">
                    {{ activityTitle ?? 'Untitled' }}
                  </span>
                </div>
                <span class="mx-4 separator"> / </span>
                <div class="breadcrumb__title">
                  <span
                    class="overflow-hidden breadcrumb__title last text-n-30"
                  >
                    {{ indicatorTitle ?? 'Untitled' }}
                  </span>
                  <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">
                    {{ indicatorTitle ?? 'Untitled' }}
                  </span>
                </div>
              </div>
            </nav>
          </div>
          <div class="inline-flex items-center">
            <div class="mr-3">
              <a
                :href="`/activities/${activity.id}/result/${indicator.result_id}`"
              >
                <svg-vue icon="arrow-short-left"></svg-vue>
              </a>
            </div>
            <h1 class="relative mr-4 text-2xl font-bold ellipsis__title">
              Indicator Detail
            </h1>
          </div>
        </div>
      </div>
    </div>

    <div class="activities">
      <aside class="activities__sidebar">
        <div class="px-6 py-4 rounded-lg indicator bg-eggshell text-n-50">
          <ul class="text-sm font-bold leading-relaxed">
            <li v-for="(rData, r, ri) in indicatorData" :key="ri">
              <a v-smooth-scroll :href="`#${r}`" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                {{ r }}
              </a>
            </li>
          </ul>
        </div>
      </aside>
      <div class="activities__content">
        <div class="flex justify-end mb-11">
          <a
            :href="`/activities/${activity.id}/result/${indicator.result_id}/indicator/${indicator.id}/edit`"
            class="
              edit-button
              mr-2.5
              flex
              items-center
              text-tiny
              font-bold
              uppercase
            "
          >
            <svg-vue class="mr-0.5 text-base" icon="edit"></svg-vue>
            <span>Edit Indicator</span>
          </a>
        </div>
        <div class="px-4 py-5 bg-white">
          <div
            class="elements-detail wider"
            :class="{ 'mb-10': indicatorData.document_link.length > 0 }"
          >
            <div class="flex category">
              {{ indicatorTitle }}
            </div>

            <div class="ml-4">
              <div class="indicators">
                <table class="mb-3">
                  <tbody>
                    <template
                      v-if="indicatorData.title[0].narrative.length > 0"
                    >
                      <TitleElement
                        id="title"
                        :data="indicatorData.title[0]"
                        :title-type="types.language"
                      />
                    </template>

                    <template v-if="indicatorData.measure">
                      <Measure
                        id="measure"
                        :data="indicatorData.measure"
                        :measure-type="types.indicatorMeasure"
                      />
                    </template>

                    <template v-if="indicatorData.aggregation_status">
                      <AggregationStatus
                        id="aggregation_status"
                        :data="indicatorData.aggregation_status"
                      />
                    </template>

                    <template
                      v-if="indicatorData.description[0].narrative.length > 0"
                    >
                      <Description
                        id="description"
                        :data="indicatorData.description[0]"
                        :desc-type="types.language"
                      />
                    </template>

                    <template v-if="indicatorData.reference.length > 0">
                      <Reference
                        id="reference"
                        :data="indicatorData.reference"
                        :ref-type="types"
                      />
                    </template>

                    <template v-if="indicatorData.baseline.length > 0">
                      <Baseline
                        id="baseline"
                        :data="indicatorData.baseline"
                        :base-type="types"
                      />
                    </template>

                    <tr v-if="!period">
                      <td></td>
                      <td>
                        <div class="mt-3">
                          <a
                            :href="`/activities/${activity.id}/result/${indicator.result_id}/indicator/${indicator.id}/period/create`"
                            class="
                              add_period
                              flex
                              w-[442px]
                              max-w-full
                              rounded
                              border border-dashed border-n-40
                              bg-white
                              px-2
                              py-2.5
                              text-xs
                              leading-normal
                            "
                          >
                            <div class="text-left grow">
                              You haven't added any periods yet.
                            </div>
                            <div
                              class="
                                flex
                                items-center
                                font-bold
                                uppercase
                                shrink-0
                                text-bluecoral
                              "
                            >
                              <svg-vue
                                icon="add"
                                class="mr-1 shrink-0"
                              ></svg-vue>
                              <span class="text-xs grow">Add period</span>
                            </div>
                          </a>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div v-if="indicatorData.document_link.length > 0" id="document_link">
            <div class="mb-4 title">
              <div class="item elements-detail wider">
                <table class="mb-5">
                  <tr>
                    <td>Document Link</td>
                    <td></td>
                  </tr>
                </table>
              </div>
              <div class="w-full h-px mb-4 border-b divider border-n-20"></div>
            </div>
            <DocumentLink :data="indicatorData.document_link" :type="types" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

//component
import {
  TitleElement,
  Measure,
  AggregationStatus,
  Description,
  Reference,
  Baseline,
  DocumentLink,
} from './elements/Index';

//composable
import getActivityTitle from 'Composable/title';

export default defineComponent({
  name: 'IndicatorDetail',
  components: {
    TitleElement,
    Measure,
    AggregationStatus,
    Description,
    Reference,
    Baseline,
    DocumentLink,
  },
  props: {
    activity: {
      type: Object,
      required: true,
    },
    resultTitle: {
      type: Object,
      required: true,
    },
    indicator: {
      type: Object,
      required: true,
    },
    // period: {
    //   type: Object,
    //   required: true,
    // },
    types: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const linkClasses =
      'flex items-center w-full bg-white rounded p-2 text-sm text-n-50 font-bold leading-normal mb-2 shadow-default';

    let { indicator, activity } = toRefs(props);

    //indicator
    const indicatorData = indicator.value.indicator;

    //titles
    const activityTitle = getActivityTitle(activity.value.title, 'en'),
      indicatorTitle = getActivityTitle(indicatorData.title[0].narrative, 'en');

    const period = false;

    return {
      linkClasses,
      activityTitle,
      indicatorTitle,
      indicatorData,
      period,
    };
  },
});
</script>
