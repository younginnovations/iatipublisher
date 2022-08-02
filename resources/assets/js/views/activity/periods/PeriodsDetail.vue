<template>
  <div class="bg-paper px-10 pt-4 pb-[71px]">
    <PageTitle
      :breadcrumb-data="breadcrumbData"
      title="Period Detail"
      :back-link="`${indicatorLink}/period`"
    >
      <div class="flex justify-end">
        <Status class="mr-2.5" :data="false" />
        <Btn
          text="Add Period"
          icon="add"
          :link="`${indicatorLink}/period/create`"
          class="mr-2.5"
        />
        <Btn
          text="Edit Period"
          :link="`${indicatorLink}/period/${period.id}/edit`"
        />
      </div>
    </PageTitle>

    <div class="activities">
      <aside class="activities__sidebar">
        <div class="px-6 py-4 rounded-lg indicator bg-eggshell text-n-50">
          <ul class="text-sm font-bold leading-relaxed">
            <li>
              <a v-smooth-scroll href="#target" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                target
              </a>
            </li>
            <li>
              <a v-smooth-scroll href="#actual" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                actual
              </a>
            </li>
          </ul>
        </div>
      </aside>
      <div class="activities__content">
        <div></div>
        <div class="px-4 py-5 bg-white">
          <div class="elements-detail wider">
            <div class="flex category">
              {{ dateFormat(periodData.period_start[0].date) }} -
              {{ dateFormat(periodData.period_end[0].date) }}
            </div>
            <TargetValue id="target" :data="periodData.target" />
            <div class="w-full h-px my-10 border-b divider border-n-20"></div>
            <ActualValue id="actual" :data="periodData.actual" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, provide } from 'vue';

//component
import Btn from 'Components/buttons/Link.vue';
import Status from 'Components/status/Status.vue';
import PageTitle from 'Components/sections/PageTitle.vue';

import { TargetValue, ActualValue } from './elements/Index';

//composable
import dateFormat from 'Composable/dateFormat';
import getActivityTitle from 'Composable/title';

export default defineComponent({
  name: 'PeriodDetail',
  components: {
    TargetValue,
    ActualValue,
    Btn,
    Status,
    PageTitle,
  },
  props: {
    activity: {
      type: Object,
      required: true,
    },
    parentData: {
      type: Object,
      required: true,
    },
    period: {
      type: Object,
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
    let { period, activity, parentData, types } = toRefs(props);

    // vue provide
    provide('types', types.value);

    //indicator
    const periodData = period.value.period;

    //titles
    const activityId = activity.value.id,
      activityTitle = getActivityTitle(activity.value.title, 'en'),
      activityLink = `/activities/${activityId}`,
      resultId = parentData.value.result.id,
      resultTitle = getActivityTitle(parentData.value.result.title, 'en'),
      resultLink = `${activityLink}/result/${resultId}`,
      indicatorId = parentData.value.indicator.id,
      indicatorTitle = getActivityTitle(parentData.value.indicator.title, 'en'),
      indicatorLink = `${resultLink}/indicator/${indicatorId}`;

    /**
     * Breadcrumb data
     */
    const breadcrumbData = [
      {
        title: 'Your Activities',
        link: '/activities',
      },
      {
        title: activityTitle,
        link: activityLink,
      },
      {
        title: resultTitle,
        link: resultLink,
      },
      {
        title: indicatorTitle,
        link: indicatorLink,
      },
      {
        title: 'Period',
        link: '',
      },
    ];
    return {
      linkClasses,
      periodData,
      dateFormat,
      breadcrumbData,
      activityLink,
      resultLink,
      indicatorLink,
    };
  },
});
</script>
