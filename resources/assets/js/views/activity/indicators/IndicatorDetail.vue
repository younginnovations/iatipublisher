<template>
  <div class="bg-paper px-10 pt-4 pb-[71px]">
    <PageTitle
      :breadcrumb-data="breadcrumbData"
      title="Indicator Detail"
      :back-link="`${indicatorLink}`"
    >
      <div class="mb-3">
        <Toast
          v-if="toastData.visibility"
          :message="toastData.message"
          :type="toastData.type"
        />
      </div>
      <div class="flex justify-end">
        <!-- <Status class="mr-2.5" :data="false" /> -->
        <Btn
          text="Add Indicator"
          icon="add"
          :link="`${indicatorLink}/create`"
          class="mr-2.5"
        />
        <Btn
          text="Edit Indicator"
          :link="`${indicatorLink}/${indicator.id}/edit`"
        />
      </div>
    </PageTitle>

    <div class="activities">
      <aside class="activities__sidebar">
        <div
          class="sticky top-0 px-6 py-4 rounded-lg indicator bg-eggshell text-n-50"
        >
          <ul class="text-sm font-bold leading-relaxed">
            <li v-for="(rData, r, ri) in indicatorData" :key="ri">
              <a v-smooth-scroll :href="`#${r}`" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                {{ r }}
              </a>
            </li>

            <li v-if="periodData.length === 0">
              <a
                :href="`${resultLink}/indicator/${indicator.id}/period/create`"
                :class="linkClasses"
                class="border border-dashed border-n-40"
              >
                <svg-vue icon="add" class="mr-2 text-n-40"></svg-vue>
                add period
              </a>
            </li>
            <li v-else>
              <a v-smooth-scroll href="#period" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                period
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

                  <Ascending id="ascending" :data="indicatorData.ascending" />

                  <Measure
                    id="measure"
                    :data="indicatorData.measure"
                    :measure-type="types.indicatorMeasure"
                  />

                  <AggregationStatus
                    id="aggregation_status"
                    :data="indicatorData.aggregation_status"
                  />

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

                  <Period id="period" :data="periodData" />
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
import { defineComponent, toRefs, onMounted, reactive, provide } from 'vue';

//component
import Btn from 'Components/buttons/Link.vue';
import PageTitle from 'Components/sections/PageTitle.vue';
import Toast from 'Components/Toast.vue';

import {
  TitleElement,
  Measure,
  Ascending,
  AggregationStatus,
  Description,
  Reference,
  Baseline,
  DocumentLink,
  Period,
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
    Period,
    Btn,
    PageTitle,
    Toast,
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
    toast: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const linkClasses =
      'flex items-center w-full bg-white rounded p-2 text-sm text-n-50 font-bold leading-normal mb-2 shadow-default';

    const toastData = reactive({
      visibility: false,
      message: '',
      type: true,
    });
    let { indicator, activity, period, resultTitle } = toRefs(props);

    //indicator
    const indicatorData = indicator.value.indicator;
    const periodData = period.value;

    // vue provides
    const parentData = {
      activity: activity.value.id,
      result: indicator.value.result_id,
      indicator: indicator.value.id,
    };

    provide('parentData', parentData);

    const activityId = activity.value.id,
      activityTitle = activity.value.title,
      activityLink = `/activity/${activityId}`,
      resultId = indicator.value.result_id,
      resultTitled = getActivityTitle(resultTitle.value[0].narrative, 'en'),
      resultLink = `${activityLink}/result/${resultId}`,
      indicatorLink = `/result/${resultId}/indicator`,
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

    onMounted(() => {
      if (props.toast.message !== '') {
        toastData.type = props.toast.type;
        toastData.visibility = true;
        toastData.message = props.toast.message;
      }

      setTimeout(() => {
        toastData.visibility = false;
      }, 5000);
    });

    return {
      linkClasses,
      indicatorTitle,
      indicatorData,
      activityLink,
      resultLink,
      indicatorLink,
      breadcrumbData,
      toastData,
      periodData,
    };
  },
});
</script>
