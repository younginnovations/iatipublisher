<template>
  <div class="bg-paper px-5 pt-4 pb-[71px] xl:px-10">
    <PageTitle
      :breadcrumb-data="breadcrumbData"
      title="Period Detail"
      :back-link="`${periodLink}`"
    >
      <div class="flex justify-end">
        <Toast
          v-if="toastData.visibility"
          :message="toastData.message"
          :type="toastData.type"
          class="mr-3"
        />
        <!-- <Status class="mr-2.5" :data="false" /> -->
        <Btn text="Add Period" icon="add" :link="`${periodLink}/create`" class="mr-2.5" />
        <Btn text="Edit Period" :link="`${periodLink}/${period.id}/edit`" />
      </div>
    </PageTitle>

    <div class="activities">
      <aside class="activities__sidebar">
        <div v-sticky-component>
          <div class="indicator rounded-lg bg-eggshell px-6 py-4 text-n-50">
            <ul class="text-sm font-bold leading-relaxed">
              <li>
                <a v-smooth-scroll href="#target" :class="linkClasses">
                  <svg-vue icon="core" class="mr-2 text-base"></svg-vue>
                  target
                </a>
              </li>
              <li>
                <a v-smooth-scroll href="#actual" :class="linkClasses">
                  <svg-vue icon="core" class="mr-2 text-base"></svg-vue>
                  actual
                </a>
              </li>
            </ul>
          </div>
        </div>
      </aside>
      <div class="activities__content">
        <div></div>
        <div class="bg-white px-4 py-5">
          <div class="elements-detail wider">
            <div class="category flex">
              {{ dateFormat(periodData.period_start[0].date) }} -
              {{ dateFormat(periodData.period_end[0].date) }}
            </div>
            <TargetValue id="target" :data="periodData.target" />
            <div class="divider my-10 h-px w-full border-b border-n-20"></div>
            <ActualValue id="actual" :data="periodData.actual" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, provide, onMounted, reactive } from "vue";

//component
import Btn from "Components/buttons/Link.vue";
import PageTitle from "Components/sections/PageTitle.vue";
import Toast from "Components/ToastMessage.vue";

import { TargetValue, ActualValue } from "./elements/Index";

//composable
import dateFormat from "Composable/dateFormat";
import getActivityTitle from "Composable/title";

export default defineComponent({
  name: "PeriodDetail",
  components: {
    TargetValue,
    ActualValue,
    Btn,
    PageTitle,
    Toast,
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
    toast: {
      type: Object,
      required: true,
    },
    element: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const linkClasses =
      "flex items-center w-full bg-white rounded p-2 text-sm text-n-50 font-bold leading-normal mb-2 shadow-default";
    let { period, activity, parentData, types } = toRefs(props);

    const toastData = reactive({
      visibility: false,
      message: "",
      type: true,
    });

    // vue provide
    provide("types", types.value);

    //indicator
    const periodData = period.value.period;

    //titles
    const activityId = activity.value.id,
      activityTitle = getActivityTitle(activity.value.title, "en"),
      activityLink = `/activity/${activityId}`,
      resultId = parentData.value.result.id,
      resultTitle = getActivityTitle(parentData.value.result.title, "en"),
      resultLink = `${activityLink}/result/${resultId}`,
      indicatorId = parentData.value.indicator.id,
      indicatorTitle = getActivityTitle(parentData.value.indicator.title, "en"),
      indicatorLink = `/result/${resultId}/indicator/${indicatorId}`,
      periodLink = `/indicator/${indicatorId}/period`;

    /**
     * Breadcrumb data
     */
    const breadcrumbData = [
      {
        title: "Your Activities",
        link: "/activities",
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
        title: "Period",
        link: "",
      },
    ];

    onMounted(() => {
      if (props.toast.message !== "") {
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
      periodData,
      dateFormat,
      breadcrumbData,
      activityLink,
      resultLink,
      indicatorLink,
      periodLink,
      toastData,
    };
  },
});
</script>
