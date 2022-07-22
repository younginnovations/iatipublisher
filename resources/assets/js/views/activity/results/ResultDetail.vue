<template>
  <div class="bg-paper px-10 pt-4 pb-[71px]">
    <div class="mb-6 page-title">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="mb-4 text-caption-c1 text-n-40">
            <nav aria-label="breadcrumbs" class="breadcrumb">
              <p>
                <a href="/activities" class="font-bold">Your Activities</a>
                <span class="mx-4 separator">/</span>
                <span class="text-n-30">
                  <a :href="`/activities/${activity.id}`">
                    {{ activityTitle }}
                  </a>
                </span>
                <span class="mx-4 separator"> / </span>
                <span class="last text-n-30">{{ resultTitle }}</span>
              </p>
            </nav>
          </div>
          <div class="inline-flex items-center">
            <div class="mr-3">
              <a :href="`/activities/${activity.id}`">
                <svg-vue icon="arrow-short-left"></svg-vue>
              </a>
            </div>
            <h4 class="mr-4 font-bold">Result detail</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="activities">
      <aside class="activities__sidebar">
        <div class="px-6 py-4 rounded-lg indicator bg-eggshell text-n-50">
          <ul class="text-sm font-bold leading-relaxed">
            <li v-for="(rData, r, ri) in resultsData" :key="ri">
              <a v-smooth-scroll :href="`#${r}`" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                {{ r }}
              </a>
            </li>
            <li v-if="hasIndicators">
              <a v-smooth-scroll href="#indicator" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                indicator
              </a>
            </li>
            <li v-if="!hasIndicators">
              <a
                :href="`/activities/${result.activity_id}/result/${result.id}/indicator/create`"
                :class="linkClasses"
                class="border border-dashed border-n-40"
              >
                <svg-vue icon="add" class="mr-2 text-n-40"></svg-vue>
                add indicator
              </a>
            </li>
          </ul>
        </div>
      </aside>
      <div class="activities__content">
        <div class="flex justify-end mb-11">
          <a
            :href="`/activities/${result.activity_id}/result/${result.id}/edit`"
            class="edit-button mr-2.5 flex items-center text-tiny font-bold uppercase"
          >
            <svg-vue class="mr-0.5 text-base" icon="edit"></svg-vue>
            <span>Edit Result</span>
          </a>
        </div>
        <div class="flex flex-wrap -mx-3 -mt-3 activities__content--elements">
          <template v-for="(post, key) in result.result" :key="key">
            <ResultElement
              :data="post"
              :element-name="key.toString()"
              :edit-url="`/activities/${result.activity_id}/result/${result.id}`"
              :width="
                key.toString() === 'title' ||
                key.toString() === 'description' ||
                key.toString() === 'document_link' ||
                key.toString() === 'reference'
                  ? 'full'
                  : ''
              "
              :types="types"
            />
          </template>

          <!-- Indicator -->
          <template v-if="hasIndicators">
            <Indicator :result="result" :type="types" tool-tip="Example text" />
          </template>
        </div>

        <!-- indicator button -->
        <button
          v-if="!hasIndicators"
          class="flex w-full px-4 py-3 text-xs leading-normal bg-white border border-dashed rounded add_indicator border-n-40"
        >
          <div class="italic text-left grow">
            You haven't added any indicator yet.
          </div>
          <div
            class="flex items-center font-bold uppercase shrink-0 text-bluecoral"
          >
            <svg-vue icon="add" class="mr-1 text-base shrink-0"></svg-vue>
            <span class="grow text-[10px]">Add new indicator</span>
          </div>
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

//component
import ResultElement from './ResultElement.vue';
import Indicator from 'Activity/results/elements/Indicator.vue';

//composable
import dateFormat from 'Composable/dateFormat';
import getActivityTitle from 'Composable/title';

export default defineComponent({
  name: 'ResultDetail',
  components: {
    ResultElement,
    Indicator,
  },
  props: {
    activity: {
      type: Object,
      required: true,
    },
    result: {
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

    let { result, activity } = toRefs(props);
    const hasIndicators = result.value.indicators.length > 0 ? true : false;
    const resultsData = result.value.result;
    const activityTitle = getActivityTitle(activity.value.title, 'en');
    const resultTitle = getActivityTitle(resultsData.title[0].narrative, 'en');

    return {
      linkClasses,
      dateFormat,
      hasIndicators,
      resultsData,
      activityTitle,
      resultTitle,
    };
  },
});
</script>
