<template>
  <div class="bg-paper px-10 pt-4 pb-[71px]">
    <PageTitle
      :breadcrumb-data="breadcrumbData"
      title="Indicator Detail"
      :back-link="`${activityLink}/result/`"
    >
      <div class="flex justify-end">
        <Status class="mr-2.5" :data="false" />
        <Btn
          text="Add Indicator"
          icon="add"
          :link="`${resultLink}/indicator/create`"
          class="mr-2.5"
        />
        <Btn
          text="Edit Indicator"
          :link="`${resultLink}/indicator/${indicator.id}/edit`"
        />
      </div>
    </PageTitle>

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
        <div></div>
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
                <table>
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

                    <!-- <template v-if="indicatorData.ascending != null"> -->
                      <Ascending
                        id="ascending"
                        :data="indicatorData.ascending"
                      />
                    <!-- </template> -->

                    <template v-if="indicatorData.measure">
                      <Measure
                        id="measure"
                        :data="indicatorData.measure"
                        :measure-type="types.indicatorMeasure"
                      />
                    </template>

                    <!-- <template v-if="indicatorData.aggregation_status"> -->
                      <AggregationStatus
                        id="aggregation_status"
                        :data="indicatorData.aggregation_status"
                      />
                    <!-- </template> -->

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

                    <tr v-if="period.length === 0">
                      <td></td>
                      <td>
                        <div>
                          <NotYet
                            :link="`/activities/${activity.id}/result/${indicator.result_id}/indicator/${indicator.id}/period/create`"
                            description="You haven't added any periods yet."
                            btn-text="Add period"
                            class="max-w-[442px]"
                          />
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
            <div class="ml-4">
              <DocumentLink :data="indicatorData.document_link" :type="types" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

//component
import Btn from 'Components/buttons/Link.vue';
import Status from 'Components/status/Status.vue';
import NotYet from 'Components/sections/HaveNotAddedYet.vue';
import PageTitle from 'Components/sections/PageTitle.vue';

import {
  TitleElement,
  Measure,
  Ascending,
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
    Ascending,
    AggregationStatus,
    Description,
    Reference,
    Baseline,
    DocumentLink,
    Btn,
    Status,
    NotYet,
    PageTitle,
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
    period: {
      type: Array,
      required: true,
    },
    types: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const linkClasses =
      'flex items-center w-full bg-white rounded p-2 text-sm text-n-50 font-bold leading-normal mb-2 shadow-default';

    let { indicator, activity, resultTitle } = toRefs(props);

    //indicator
    const indicatorData = indicator.value.indicator;

    const activityId = activity.value.id,
      activityTitle = activity.value.title,
      activityLink = `/activities/${activityId}`,
      resultId = indicator.value.result_id,
      resultTitled = getActivityTitle(resultTitle.value[0].narrative, 'en'),
      resultLink = `${activityLink}/result/${resultId}`,
      indicatorTitle = getActivityTitle(indicatorData.title[0].narrative, 'en');

    /**
     * Breadcrumb data
     */
    const breadcrumbData = [
      {
        title: 'Your Activities',
        link: '/activities',
      },
      {
        title: getActivityTitle(activityTitle, 'en'),
        link: activityLink,
      },
      {
        title: resultTitled,
        link: resultLink,
      },
      {
        title: indicatorTitle,
        link: '',
      },
    ];

    return {
      linkClasses,
      indicatorTitle,
      indicatorData,
      activityLink,
      resultLink,
      breadcrumbData,
    };
  },
});
</script>
