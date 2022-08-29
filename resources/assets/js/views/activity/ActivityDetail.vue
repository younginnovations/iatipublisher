<template>
  <div class="relative bg-paper px-10 pt-4 pb-[71px]">
    <!-- title section -->
    <div class="mb-6 page-title">
      <div class="pb-4 text-caption-c1 text-n-40">
        <div>
          <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
            <div class="flex">
              <a class="font-bold whitespace-nowrap" href="/activities">
                Your Activities
              </a>
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
      </div>

      <div class="flex items-end gap-4">
        <div class="title max-w-[50%] basis-6/12">
          <div class="inline-flex items-center w-full">
            <div class="mr-3">
              <a href="/activities">
                <svg-vue icon="arrow-short-left" />
              </a>
            </div>
            <div class="inline-flex flex-wrap grow">
              <h4 class="relative text-2xl font-bold ellipsis__title">
                <span class="overflow-hidden ellipsis__title">
                  {{ pageTitle ? pageTitle : 'Untitled' }}
                </span>
                <span class="ellipsis__title--hover">
                  {{ pageTitle ? pageTitle : 'Untitled' }}
                </span>
              </h4>
            </div>
          </div>
        </div>
        <div class="relative flex flex-col items-end justify-end actions grow">
          <div class="inline-flex justify-end">
            <!-- toast msg for publishing -->
            <Toast
              v-if="toastData.visibility"
              :message="toastData.message"
              :type="toastData.type"
              class="mr-3"
            />

            <div class="inline-flex items-center justify-end gap-3">
              <!-- Delete Activity -->
              <DeleteButton />

              <!-- Unpublish Activity -->
              <UnPublish
                v-if="store.state.unPublished"
                :activity-id="activityProps.id"
              />

              <!-- Publish Activity -->
              <Publish
                v-if="store.state.showPublished"
                :already-published="activityProps.already_published"
                :linked-to-iati="activityProps.linked_to_iati"
                :status="activityProps.status"
                :core-completed="coreCompleted"
                :activity-id="activityProps.id"
              />
            </div>
          </div>

          <Errors
            v-if="store.state.publishErrors.length > 0"
            :error-data="store.state.publishErrors"
            class="absolute right-0 -mr-10 bottom-full"
          />
        </div>
      </div>
    </div>
    <!-- title section ends -->
    <div class="activities">
      <aside class="activities__sidebar">
        <div v-if="publishStatus.already_published" class="mb-2">
          <PreviouslyPublished />
        </div>
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
            <ProgressBar :percent="progress" class="mb-3" />
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
                <svg-vue icon="double-tick" />
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
      <div class="activities__content">
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
import ProgressBar from 'Components/ProgressBar.vue';
import Publish from 'Components/sections/PublishButton.vue';
import UnPublish from 'Components/sections/UnPublishButton.vue';
import DeleteButton from 'Components/sections/DeleteButton.vue';
import Errors from 'Components/sections/StickyErrors.vue';
import Toast from 'Components/Toast.vue';

// Activity Components
import Elements from 'Activity/partials/ActivitiesElements.vue';
import ActivityElement from 'Activity/partials/ActivityElement.vue';
import PreviouslyPublished from 'Components/status/PreviouslyPublished.vue';

// Vuex Store
import { useStore } from 'Store/activities/show';

export default defineComponent({
  components: {
    HoverText,
    ProgressBar,
    Elements,
    ActivityElement,
    Result,
    Toast,
    Publish,
    Errors,
    UnPublish,
    DeleteButton,
    PreviouslyPublished,
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
    coreCompleted: {
      type: Boolean,
      required: true,
    },
    iatiValidatorResponse: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { types, coreCompleted } = toRefs(props);

    const store = useStore();

    const toastData = reactive({
      visibility: false,
      message: '',
      type: true,
    });

    /**
     * For modal popup
     */
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

    const toastMessage = reactive({
      message: '',
      type: false,
    });

    interface PublishStatusTypeface {
      already_published: boolean;
      linked_to_iati: boolean;
      status: string;
    }

    const publishStatus: PublishStatusTypeface = reactive({
      already_published: activityProps.already_published,
      linked_to_iati: activityProps.linked_to_iati,
      status: activityProps.status,
    });

    // vue provides
    provide('types', types.value);
    provide('coreCompleted', coreCompleted.value);
    provide('activityID', activity.value.id);
    provide('toastMessage', toastMessage);

    /**
     * Breadcrumb data
     */
    const breadcrumbData = [
      {
        title: 'Your Activities',
        link: '/activities',
      },
      {
        title: pageTitle,
        link: '',
      },
    ];

    /**
     *  Global State
     */
    let { iatiValidatorResponse } = toRefs(props);
    const validationResult = iatiValidatorResponse.value;

    if (validationResult && validationResult.errors.length > 0) {
      store.dispatch('updatePublishErrors', validationResult.errors);
    }

    if (publishStatus.linked_to_iati) {
      store.dispatch('updateUnPublished', true);
    } else {
      store.dispatch('updateUnPublished', false);
    }

    if (
      !(publishStatus.linked_to_iati && publishStatus.status === 'published')
    ) {
      store.dispatch('updateShowPublished', true);
    } else {
      store.dispatch('updateShowPublished', false);
    }

    return {
      groupedData,
      activities,
      deleteValue,
      deleteToggle,
      downloadValue,
      downloadToggle,
      toastData,
      elementProps,
      props,
      formatTitle,
      pageTitle,
      toastMessage,
      publishStatus,
      breadcrumbData,
      store,
      activityProps,
    };
  },
});
</script>
