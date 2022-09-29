<template>
  <div class="bg-paper px-5 pt-4 pb-[71px] xl:px-10">
    <PageTitle
      :breadcrumb-data="breadcrumbData"
      title="Result Detail"
      :back-link="`${activityLink}/result`"
    >
      <Toast
        v-if="toastData.visibility"
        :message="toastData.message"
        :type="toastData.type"
        class="mr-3"
      />
      <a :href="`${activityLink}/result/create`">
        <Btn text="Edit Result" :link="`${resultLink}/edit`" icon="edit" />
      </a>
    </PageTitle>
    <div class="activities">
      <aside class="activities__sidebar">
        <div
          class="indicator sticky top-0 rounded-lg bg-eggshell px-6 py-4 text-n-50"
        >
          <ul class="text-sm font-bold leading-relaxed">
            <li v-for="(rData, r, ri) in resultsData" :key="ri">
              <a v-smooth-scroll :href="`#${String(r)}`" :class="linkClasses">
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
                :href="`/result/${result.id}/indicator/create`"
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
        <div></div>

        <div
          class="activities__content--elements -mx-3 -mt-3 flex-wrap xl:flex"
        >
          <template v-for="(post, key) in result.result" :key="key">
            <ResultElement
              :data="post"
              :element-name="key.toString()"
              :edit-url="`/activity/${result.activity_id}/result/${result.id}`"
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
        <a
          v-if="!hasIndicators"
          :href="`/result/${result.id}/indicator/create`"
          class="add_indicator flex w-full rounded border border-dashed border-n-40 bg-white px-4 py-3 text-xs leading-normal"
        >
          <div class="grow text-left italic">
            You haven't added any indicator yet.
          </div>
          <div
            class="flex shrink-0 items-center font-bold uppercase text-bluecoral"
          >
            <svg-vue icon="add" class="mr-1 shrink-0 text-base"></svg-vue>
            <span class="grow text-[10px]">Add new indicator</span>
          </div>
        </a>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, onMounted, reactive } from 'vue';

//component
import ResultElement from './ResultElement.vue';
import Indicator from 'Activity/results/elements/Indicator.vue';
import Btn from 'Components/buttons/Link.vue';
import PageTitle from 'Components/sections/PageTitle.vue';
import Toast from 'Components/Toast.vue';

//composable
import dateFormat from 'Composable/dateFormat';
import getActivityTitle from 'Composable/title';

export default defineComponent({
  name: 'ResultDetail',
  components: {
    ResultElement,
    Indicator,
    Btn,
    PageTitle,
    Toast,
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
    toast: {
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

    const activityId = activity.value.id,
      activityTitle = activity.value.title,
      activityLink = `/activity/${activityId}`,
      resultTitle = getActivityTitle(resultsData.title[0].narrative, 'en'),
      resultLink = `${activityLink}/result/${result.value.id}`;

    const toastData = reactive({
      visibility: false,
      message: '',
      type: true,
    });

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
        title: resultTitle,
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
      activityLink,
      resultTitle,
      resultLink,
      linkClasses,
      dateFormat,
      hasIndicators,
      resultsData,
      breadcrumbData,
      toastData,
    };
  },
});
</script>
