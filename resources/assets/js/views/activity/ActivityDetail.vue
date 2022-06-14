<template>
  <div class="bg-paper px-10 pt-4 pb-[71px]">
    <!-- title section -->
    <div class="page-title mb-6">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="mb-4 text-caption-c1 text-n-40">
            <nav
              aria-label="breadcrumbs"
              class="rank-math-breadcrumb"
            >
              <p>
                <a
                  class="font-bold"
                  href="/activities"
                >Your Activities</a>
                <span class="separator mx-4"> / </span>
                <span class="last text-n-30">{{ pageTitle }}</span>
              </p>
            </nav>
          </div>
          <div class="inline-flex items-center">
            <div class="mr-3">
              <a href="/activities">
                <svg-vue icon="arrow-short-left" />
              </a>
            </div>
            <h4 class="mr-4 font-bold">
              {{ pageTitle }}
            </h4>
          </div>
        </div>
        <div class="actions flex grow justify-end">
          <div class="inline-flex justify-center">
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
                <div class="title mb-6 flex">
                  <svg-vue
                    class="mr-1 mt-0.5 text-lg text-spring-50"
                    icon="download-file"
                  />
                  <b>Download file.</b>
                </div>
                <div class="rounded-lg bg-mint p-4">
                  Click the download button to save the file.
                </div>
              </div>
              <div class="flex justify-end">
                <div class="inline-flex">
                  <BtnComponent
                    class="bg-white px-6 uppercase"
                    text="Go Back"
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
                <div class="title mb-6 flex">
                  <svg-vue
                    class="mr-1 mt-0.5 text-lg text-crimson-40"
                    icon="delete"
                  />
                  <b>Delete activity</b>
                </div>
                <div class="rounded-lg bg-rose p-4">
                  Are you sure you want to delete this activity?
                </div>
              </div>
              <div class="flex justify-end">
                <div class="inline-flex">
                  <BtnComponent
                    class="bg-white px-6 uppercase"
                    text="Go Back"
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
                <div class="title mb-6 flex">
                  <svg-vue
                    class="mr-1 mt-0.5 text-lg text-crimson-40"
                    icon="cancel-cloud"
                  />
                  <b>Unpublish activity</b>
                </div>
                <div class="rounded-lg bg-rose p-4">
                  Are you sure you want to unpublish this activity?
                </div>
              </div>
              <div class="flex justify-end">
                <div class="inline-flex">
                  <BtnComponent
                    class="bg-white px-6 uppercase"
                    text="Go Back"
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
              class="button primary-btn relative font-bold"
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
                <div class="title mb-6 flex">
                  <svg-vue
                    class="mr-1 mt-0.5 text-lg text-spring-50"
                    icon="approved-cloud"
                  />
                  <b>Publish activity?</b>
                </div>
                <div class="rounded-lg bg-mint p-4">
                  Are you ready to publish this activity?
                </div>
              </div>
              <div class="flex justify-end">
                <div class="inline-flex">
                  <BtnComponent
                    class="bg-white px-6 uppercase"
                    text="Go Back"
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
        <div class="mb-1 flex">
          <div class="activities__card progress mr-1">
            <div class="mb-2 flex items-center justify-between">
              <span class="mr-2">Publishing Progress</span>
              <HoverText
                hover-text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
                position="right"
              />
            </div>
            <ProgressBar
              :percent="progress"
              class="mb-3"
            />
            <span>Fill core elements to get 100% score</span>
          </div>
          <div class="activities__card elements">
            <div class="mb-7 flex items-center justify-between">
              <span>Elements</span>
              <HoverText
                hover-text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
              />
            </div>
            <div class="mb-3 flex justify-between">
              <div class="flex items-center space-x-1">
                <svg-vue icon="core" />
                <span>Core</span>
              </div>
              <HoverText
                hover-text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
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
              />
            </div>
          </div>
        </div>
        <Elements :data="elements" />
      </aside>
      <div class="activities__content">
        <div class="inline-flex flex-wrap gap-2">
          <a
            v-for="(post, key) in groupedData"
            :key="key"
            v-smooth-scroll
            :href="`#${key}`"
            class="tab-btn-anchor"
          >
            <button
              :disabled="post.status == 'disabled'"
              class="tab-btn"
            >
              <span>{{ post.label }}</span>
              <span class="hover__text">
                <HoverText
                  :name="post.label"
                  hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                  icon_size="text-tiny"
                />
              </span>
            </button>
          </a>
        </div>

        <div class="activities__content--elements -mx-3 flex flex-wrap">
          <template v-for="(post, key) in activities">
            <template v-for="(element, name, index) in post.elements">
              <ActivityElement
                v-if="Object.keys(element.content).length > 0"
                :id="key"
                :key="index"
                :content="element.content"
                :data="element"
                :title="name"
                :width="
                  name === 'title' || name === 'description' ? 'full' : ''
                "
                tooltip="Example text"
              />
            </template>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
/* eslint-disable vue/no-setup-props-destructure */
import { defineComponent } from 'vue';
import { useToggle } from '@vueuse/core';
import HoverText from '../../components/HoverText.vue';
import ProgressBar from '../../components/ProgressBar.vue';
import Elements from './partials/ActivitiesElements.vue';
import ActivityElement from './partials/ActivityElement.vue';
import Modal from '../../components/PopupModal.vue';
import BtnComponent from '../../components/ButtonComponent.vue';

export default defineComponent({
  components: {
    HoverText,
    ProgressBar,
    Elements,
    ActivityElement,
    Modal,
    BtnComponent,
  },
  props: {
    elements: {
      type: Object,
      required: true,
    },
    elementGroup: {
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
  },
  setup(props) {
    /**
     * For modal popup
     */
    const [publishValue, publishToggle] = useToggle();
    const [unpublishValue, unpublishToggle] = useToggle();
    const [deleteValue, deleteToggle] = useToggle();
    const [downloadValue, downloadToggle] = useToggle();

    /**
     * Finding current language - activity title
     */
    let pageTitle = '';
    const found = props.activity.title.find(
      (e: { language: string }) => {
        const currentLanguage = 'en';
        return e.language === currentLanguage;
      }
    );

    // callback if language not available in data
    if (found) {
      pageTitle = found.narrative;
    } else {
      pageTitle = props.activity.title[0].narrative;
    }

    /**
     * Grouping all the data's for scroll function
     *
     * this data is created using props.element_group and props.activity
     */
    const groupedData = { ...props.element_group },
      detailData = props.activity,
      activities = { ...props.element_group };

    // generating available elements
    Object.keys(activities).map((key) => {
      let flag = false;
      Object.keys(activities[key]['elements']).map((k) => {
        if (detailData[k]) {
          activities[key]['elements'][k]['content'] = detailData[k];
          flag = true;
        } else {
          activities[key]['elements'][k]['content'] = [];
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

    return {
      groupedData,
      activities,
      pageTitle,
      publishValue,
      publishToggle,
      unpublishValue,
      unpublishToggle,
      deleteValue,
      deleteToggle,
      downloadValue,
      downloadToggle,
    };
  },
});
</script>

<style lang="scss">
.activities {
  @apply flex gap-7;

  &__sidebar {
    width: 280px;
  }

  &__content {
    @apply grow;
  }

  &__card {
    @apply flex flex-col bg-white text-center text-xs text-n-40;
    padding: 13px;
  }

  .progress {
    @apply items-center;
    border-radius: 8px 0px 0px 8px;
    width: 151px;
    height: 174px;
  }

  .tab-btn:disabled {
    @apply pointer-events-none text-n-20;

    svg {
      @apply text-n-20;
    }
  }
}
</style>
