<template>
  <div class="bg-paper px-10 pt-4 pb-[71px]">
    <div class="mb-6 page-title">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="pb-4 text-caption-c1 text-n-40">
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
                    <a
                      :href="`/activities/${activity.id}/result/${parentData.result.id}`"
                    >
                      {{ resultTitle ?? 'Untitled' }}
                    </a>
                  </span>
                  <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">
                    {{ resultTitle ?? 'Untitled' }}
                  </span>
                </div>
                <span class="mx-4 separator"> / </span>
                <div class="breadcrumb__title">
                  <span
                    class="overflow-hidden breadcrumb__title last text-n-30"
                  >
                    <a
                      :href="`/activities/${activity.id}/result/${parentData.result.id}/indicator/${parentData.indicator.id}`"
                    >
                      {{ indicatorTitle ?? 'Untitled' }}
                    </a>
                  </span>
                  <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">
                    {{ indicatorTitle ?? 'Untitled' }}
                  </span>
                </div>
                <span class="mx-4 separator"> / </span>
                <div class="breadcrumb__title">Period Detail</div>
              </div>
            </nav>
          </div>
          <div class="inline-flex items-center">
            <div class="mr-3">
              <a
                :href="`/activities/${activity.id}/result/${parentData.result.id}/indicator/${parentData.indicator.id}`"
              >
                <svg-vue icon="arrow-short-left"></svg-vue>
              </a>
            </div>
            <h1 class="relative mr-4 text-2xl font-bold ellipsis__title">
              Period Detail
            </h1>
          </div>
        </div>
        <div class="flex flex-col items-end justify-end actions grow">
          <div class="flex justify-end">
            <Status class="mr-2.5" :data="false" />
            <Btn
              text="Add Period"
              icon="add"
              :link="`/activities/${activity.id}/result/${parentData.result.id}/indicator/create`"
              class="mr-2.5"
            />
            <Btn
              text="Edit Period"
              :link="`/activities/${activity.id}/result/${parentData.result.id}/indicator/${parentData.indicator.id}/period/${period.id}/edit`"
            />
          </div>
        </div>
      </div>
    </div>

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
    const activityTitle = getActivityTitle(activity.value.title, 'en'),
      resultTitle = getActivityTitle(parentData.value.result.title, 'en'),
      indicatorTitle = getActivityTitle(parentData.value.indicator.title, 'en');
    return {
      linkClasses,
      activityTitle,
      resultTitle,
      indicatorTitle,
      periodData,
      dateFormat,
    };
  },
});
</script>
