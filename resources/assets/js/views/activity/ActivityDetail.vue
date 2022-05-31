<template>
  <div class="relative bg-paper px-10 pt-4 pb-[71px]">
    <!-- title section -->
    <div class="mb-6 page-title">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="max-w-sm pb-4 text-caption-c1 text-n-40">
            <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
              <div class="flex">
                <a class="font-bold whitespace-nowrap" href="/activities"
                  >Your Activities</a
                >
                <span class="mx-4 separator"> / </span>
                <div class="breadcrumb__title">
                  <span
                    class="overflow-hidden breadcrumb__title last text-n-30"
                    >{{ pageTitle ?? 'Untitled' }}</span
                  >
                  <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">{{
                    pageTitle ? pageTitle : 'Untitled'
                  }}</span>
                </div>
              </div>
            </nav>
          </div>
          <div class="inline-flex items-center max-w-3xl">
            <div class="mr-3">
              <a href="/activities">
                <svg-vue icon="arrow-short-left" />
              </a>
            </div>
            <div>
              <h4 class="relative mr-4 text-2xl font-bold ellipsis__title">
                <span
                  id="activity_title"
                  class="overflow-hidden ellipsis__title"
                  >{{ pageTitle ? pageTitle : 'Untitled' }}</span
                >
                <span class="ellipsis__title--hover">{{
                  pageTitle ? pageTitle : 'Untitled'
                }}</span>
              </h4>
            </div>
          </div>
        </div>
        <div class="flex flex-col items-end justify-end actions grow">
          <div class="mb-3">
            <Toast
              v-if="toastData.visibility"
              :message="toastData.message"
              :type="toastData.type"
            />
          </div>
          <div class="inline-flex justify-end">
            <!-- Download File -->
            <button
              class="button secondary-btn mr-3.5 font-bold"
              @click="downloadValue = true"
            >
              <svg-vue icon="download-file" />
            </button>
            <Modal
              :modal-active="downloadValue"
              width="583"
              @close="downloadToggle"
            >
              <div class="mb-4">
                <div class="flex mb-6 title">
                  <svg-vue
                    class="mr-1 mt-0.5 text-lg text-spring-50"
                    icon="download-file"
                  />
                  <b>Download file.</b>
                </div>
                <div class="p-4 rounded-lg bg-mint">
                  Click the download button to save the file.
                </div>
              </div>
              <div class="flex justify-end">
                <div class="inline-flex">
                  <BtnComponent
                    class="px-6 uppercase bg-white"
                    text="Go Back"
                    type=""
                    @click="downloadValue = false"
                  />
                  <BtnComponent
                    class="space"
                    text="Download"
                    type="primary"
                    @click="downloadValue = false"
                  />
                </div>
              </div>
            </Modal>

            <!-- Delete Activity -->
            <button
              class="button secondary-btn mr-3.5 font-bold"
              @click="deleteValue = true"
            >
              <svg-vue icon="delete" />
            </button>
            <Modal
              :modal-active="deleteValue"
              width="583"
              @close="deleteToggle"
            >
              <div class="mb-4">
                <div class="flex mb-6 title">
                  <svg-vue
                    class="mr-1 mt-0.5 text-lg text-crimson-40"
                    icon="delete"
                  />
                  <b>Delete activity</b>
                </div>
                <div class="p-4 rounded-lg bg-rose">
                  Are you sure you want to delete this activity?
                </div>
              </div>
              <div class="flex justify-end">
                <div class="inline-flex">
                  <BtnComponent
                    class="px-6 uppercase bg-white"
                    text="Go Back"
                    type=""
                    @click="deleteValue = false"
                  />
                  <BtnComponent
                    class="space"
                    text="Delete"
                    type="primary"
                    @click="deleteValue = false"
                  />
                </div>
              </div>
            </Modal>

            <!-- Unpublish Activity -->
            <button
              class="button secondary-btn mr-3.5 font-bold"
              @click="unpublishValue = true"
            >
              <svg-vue icon="cancel-cloud" />
              <span>Unpublish</span>
            </button>
            <Modal
              :modal-active="unpublishValue"
              width="583"
              @close="unpublishToggle"
            >
              <div class="mb-4">
                <div class="flex mb-6 title">
                  <svg-vue
                    class="mr-1 mt-0.5 text-lg text-crimson-40"
                    icon="cancel-cloud"
                  />
                  <b>Unpublish activity</b>
                </div>
                <div class="p-4 rounded-lg bg-rose">
                  Are you sure you want to unpublish this activity?
                </div>
              </div>
              <div class="flex justify-end">
                <div class="inline-flex">
                  <BtnComponent
                    class="px-6 uppercase bg-white"
                    text="Go Back"
                    type=""
                    @click="unpublishValue = false"
                  />
                  <BtnComponent
                    class="space"
                    text="Unpublish"
                    type="primary"
                    @click="unpublishValue = false"
                  />
                </div>
              </div>
            </Modal>

            <!-- Publish Activity -->
            <button
              class="relative font-bold button primary-btn"
              @click="publishValue = true"
            >
              <svg-vue icon="approved-cloud" />
              <span>Publish</span>
            </button>
            <Modal
              :modal-active="publishValue"
              width="583"
              @close="publishToggle"
            >
              <div class="mb-4">
                <div class="flex mb-6 title">
                  <svg-vue
                    class="mr-1 mt-0.5 text-lg text-spring-50"
                    icon="approved-cloud"
                  />
                  <b>Publish activity?</b>
                </div>
                <div class="p-4 rounded-lg bg-mint">
                  Are you ready to publish this activity?
                </div>
              </div>
              <div class="flex justify-end">
                <div class="inline-flex">
                  <BtnComponent
                    class="px-6 uppercase bg-white"
                    text="Go Back"
                    type=""
                    @click="publishValue = false"
                  />
                  <BtnComponent
                    class="space"
                    text="Publish"
                    type="primary"
                    @click="publishValue = false"
                  />
                </div>
              </div>
            </Modal>
          </div>
        </div>
      </div>
    </div>
    <!-- title section ends -->
    <div class="activities">
      <aside class="activities__sidebar">
        <div class="flex mb-1">
          <div class="mr-1 activities__card progress">
            <div class="flex items-center justify-between mb-2">
              <span class="mr-2">Publishing Progress</span>
              <HoverText
                hover-text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
                class="hover-text"
                position="right"
              />
            </div>
            <RadialProgressBar
              class="mb-3 h-20 text-8xl"
              :isPercent="true"
            ></RadialProgressBar>
            <span>Fill core elements to get 100% score</span>
          </div>
          <div class="activities__card elements">
            <div class="flex items-center justify-between mb-7">
              <span>Elements</span>
              <HoverText
                hover-text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
                class="hover-text"
              />
            </div>
            <div class="flex justify-between mb-3">
              <div class="flex items-center space-x-1">
                <svg-vue icon="core" />
                <span>Core</span>
              </div>
              <HoverText
                hover-text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
                class="hover-text"
              />
            </div>
            <div class="flex justify-between">
              <div class="flex items-center space-x-1">
                <svg-vue icon="double-tick" class="text-spring-50"></svg-vue>
                <span>Completed</span>
              </div>
              <HoverText
                hover-text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
                class="hover-text"
              />
            </div>
          </div>
        </div>
        <Elements
          :activity-id="activity.id"
          :data="elementProps"
          class="sticky top-0"
        />
      </aside>
      <div class="overflow-hidden activities__content">
        <div class="inline-flex flex-wrap gap-2 mb-3">
          <a
            v-for="(post, key, index) in groupedData"
            :key="index"
            v-smooth-scroll
            :href="`#${key}`"
            class="tab-btn-anchor"
          >
            <button :disabled="post.status == 'disabled'" class="tab-btn">
              <span>{{ post.label }}</span>
              <span class="hover__text">
                <HoverText
                  :name="post.label"
                  hover-text="You cannot publish an activity until all the mandatory fields have been filled."
                  icon_size="text-tiny"
                />
              </span>
            </button>
          </a>
        </div>
        <div class="flex flex-wrap -mx-3 activities__content--elements">
          <template v-for="(post, key, index) in groupedData" :key="index">
            <div
              class="relative flex items-center w-full mx-3 mt-3 mb-1 text-sm uppercase elements-title text-n-40"
            >
              <div class="mr-4 shrink-0">{{ formatTitle(key) }}</div>
            </div>
            <template v-for="(element, name, i) in post.elements" :key="i">
              <template v-if="name.toString() !== 'result'">
                <ActivityElement
                  v-if="
                    (typeof element.content === 'object'
                      ? Object.keys(element.content).length > 0
                      : element.content) || typeof element.content === 'number'
                  "
                  :id="key"
                  :data="element"
                  :types="types"
                  :title="name.toString()"
                  :activity-id="activity.id"
                  :width="
                    String(name) === 'iati_identifier' ||
                    String(name) === 'activity_status' ||
                    String(name) === 'activity_scope' ||
                    String(name) === 'collaboration_type' ||
                    String(name) === 'default_flow_type' ||
                    String(name) === 'default_tied_status' ||
                    String(name) === 'default_finance_type' ||
                    String(name) === 'capital_spend'
                      ? 'basis-6/12'
                      : 'full'
                  "
                  :completed="status[name] ?? false"
                  tooltip="Example text"
                />
              </template>
              <template v-else>
                <Result
                  :id="key"
                  :data="element"
                  :types="types"
                  :title="name.toString()"
                  :activity-id="activity.id"
                  :completed="status[name] ?? false"
                  tooltip="Example text"
                />
              </template>
            </template>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, reactive, toRefs, provide } from 'vue';
import { useToggle } from '@vueuse/core';

// components
import { Result } from './elements/Index';
import HoverText from 'Components/HoverText.vue';
import RadialProgressBar from 'Components/RadialProgressBar.vue';
import Modal from 'Components/PopupModal.vue';
import BtnComponent from 'Components/ButtonComponent.vue';
import Toast from 'Components/Toast.vue';

import Elements from 'Activity/partials/ActivitiesElements.vue';
import ActivityElement from 'Activity/partials/ActivityElement.vue';

export default defineComponent({
  components: {
    HoverText,
    Elements,
    ActivityElement,
    Result,
    Modal,
    BtnComponent,
    Toast,
    RadialProgressBar,
  },
  props: {
    elements: {
      type: Object,
      required: true,
    },
    groups: {
      type: Object,
      required: true,
    },
    activity: {
      type: Object,
      required: true,
    },
    progress: {
      type: Number,
      required: true,
    },
    toast: {
      type: Object,
      required: true,
    },
    types: {
      type: Object,
      required: true,
    },
    status: {
      type: Object,
      required: true,
    },
    results: {
      type: Array,
      required: true,
    },
    transactions: {
      type: Array,
      required: true,
    },
  },
  setup(props) {
    const { types } = toRefs(props);
    // vue provides
    provide('types', types.value);

    const toastData = reactive({
      visibility: false,
      message: '',
      type: true,
    });

    /**
     * For modal popup
     */
    const [publishValue, publishToggle] = useToggle();
    const [unpublishValue, unpublishToggle] = useToggle();
    const [deleteValue, deleteToggle] = useToggle();
    const [downloadValue, downloadToggle] = useToggle();

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
    /**
     * Grouping all the data's for scroll function
     *
     * this data is created using props.element_group and props.activity
     */

    const { groups, activity, elements, status, transactions } = toRefs(props),
      groupedData = groups.value,
      activityProps = activity.value,
      activities = groups.value,
      elementProps = elements.value,
      statusProps = status.value,
      transactionProps = transactions.value;

    const { results } = toRefs(props);
    activityProps.result = results.value;
    activityProps.transactions = transactionProps;

    // generating available elements
    Object.keys(activities).map((key) => {
      let flag = false;

      Object.keys(activities[key]['elements']).map((k) => {
        if (
          typeof activityProps[k] === 'number' ||
          (typeof activityProps[k] === 'object' &&
            activityProps[k] &&
            Object.keys(activityProps[k]).length)
        ) {
          activities[key]['elements'][k]['content'] = activityProps[k];
          flag = true;
        } else {
          delete activities[key][k];
        }
      });

      if (flag === false) {
        delete activities[key];
      }
    });

    // generating available categories of elements
    Object.keys(groupedData).map((key) => {
      if (Object.prototype.hasOwnProperty.call(activities, key)) {
        groupedData[key]['status'] = 'enabled';
      } else {
        groupedData[key]['status'] = 'disabled';
      }
    });

    /**
     * Grouping all elements and theirs completed status
     *
     * combining props.elements and props.status
     *
     * @returns object
     */
    Object.keys(elementProps).map((key) => {
      elementProps[key]['completed'] = statusProps[key] ?? false;
      elementProps[key]['has_data'] = 0;

      if (key in activityProps) {
        if (
          (typeof activityProps[key] === 'object' ||
            typeof activityProps[key] === 'number') &&
          activityProps[key]
        ) {
          if (
            Object.keys(activityProps[key]).length > 0 ||
            activityProps[key].toString.length > 0
          ) {
            elementProps[key]['has_data'] = 1;
          }
        }
      }
    });

    /**
     * Finding current language - activity title
     */
    let pageTitle = '';
    const found = activityProps.title.find((e: { language: string }) => {
      const currentLanguage = 'en';
      return e.language === currentLanguage;
    });

    // callback if language not available in data
    if (found) {
      pageTitle = found.narrative;
    } else {
      pageTitle = activityProps.title[0].narrative;
    }

    function formatTitle(title: string) {
      return title.replace(/_/gi, ' ');
    }

    return {
      groupedData,
      activities,
      publishValue,
      publishToggle,
      unpublishValue,
      unpublishToggle,
      deleteValue,
      deleteToggle,
      downloadValue,
      downloadToggle,
      toastData,
      elementProps,
      props,
      formatTitle,
      pageTitle,
    };
  },
});
</script>
