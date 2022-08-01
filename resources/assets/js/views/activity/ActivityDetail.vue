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
              <h4 class="ellipsis__title relative mr-4 text-2xl font-bold">
                <span
                  id="activity_title"
                  class="ellipsis__title overflow-hidden"
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
        <Elements :activity-id="activity.id" :data="elementProps" />
      </aside>
      <div class="activities__content overflow-hidden">
        <div class="mb-3 inline-flex flex-wrap gap-2">
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
        <div class="activities__content--elements -mx-3 flex flex-wrap">
          <template v-for="(post, key, index) in groupedData" :key="index">
            <div
              class="
                elements-title
                relative
                mx-3
                mb-1
                mt-3
                flex
                w-full
                items-center
                text-sm
                uppercase
                text-n-40
              "
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
                <Results
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
import { defineComponent, onMounted, reactive, toRefs } from 'vue';
import { useToggle } from '@vueuse/core';
import HoverText from '../../components/HoverText.vue';
import ProgressBar from '../../components/ProgressBar.vue';
import Elements from './partials/ActivitiesElements.vue';
import ActivityElement from './partials/ActivityElement.vue';
import Results from './partials/ActivityResult.vue';
import Modal from '../../components/PopupModal.vue';
import BtnComponent from '../../components/ButtonComponent.vue';
import Toast from '../../components/Toast.vue';

export default defineComponent({
  components: {
    HoverText,
    ProgressBar,
    Elements,
    ActivityElement,
    Results,
    Modal,
    BtnComponent,
    Toast,
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
        console.log(
          k,
          activityProps[k] || typeof activityProps[k] === 'number',
          '---',
          typeof activityProps[k] === 'object' &&
            activityProps[k] &&
            Object.keys(activityProps[k]).length
        );
        if (
          typeof activityProps[k] === 'number' ||
          (typeof activityProps[k] === 'object' &&
            activityProps[k] &&
            Object.keys(activityProps[k]).length)
        ) {
          activities[key]['elements'][k]['content'] = activityProps[k];
          console.log(
            key,
            activityProps[k] || typeof activityProps[k] === 'number'
          );
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
