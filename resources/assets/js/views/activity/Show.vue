<template>
  <div class="bg-paper px-10 pt-4 pb-[71px]">
    <!-- title section -->
    <div class="page-title mb-6">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="mb-4 text-caption-c1 text-n-40">
            <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
              <p>
                <a class="font-bold" href="/">Your Activities</a>
                <span class="separator mx-4"> / </span>
                <span class="last text-n-30"
                  >Partnership against child exploitation</span
                >
              </p>
            </nav>
          </div>
          <div class="inline-flex items-center">
            <div class="mr-3">
              <a href="/">
                <svg-vue icon="arrow-short-left"></svg-vue>
              </a>
            </div>
            <h4 class="mr-4 font-bold">
              Partnership Against Child Exploitation
            </h4>
          </div>
        </div>
        <div class="actions flex grow justify-end">
          <div class="inline-flex justify-center">
            <button class="button secondary-btn mr-3.5 font-bold">
              <svg-vue icon="download-file"></svg-vue>
            </button>
            <button class="button secondary-btn mr-3.5 font-bold">
              <svg-vue icon="delete"></svg-vue>
            </button>
            <button class="button secondary-btn mr-3.5 font-bold">
              <svg-vue icon="cancel-cloud"></svg-vue>
              <span>Unpublish</span>
            </button>
            <button class="button primary-btn relative font-bold">
              <svg-vue icon="approved-cloud"></svg-vue>
              <span>Publish</span>
            </button>
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
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
              ></HoverText>
            </div>
            <ProgressBar :percent="progress" class="mb-3"></ProgressBar>
            <span>Fill core elements to get 100% score</span>
          </div>
          <div class="activities__card elements">
            <div class="mb-7 flex items-center justify-between">
              <span>Elements</span>
              <HoverText
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
              ></HoverText>
            </div>
            <div class="mb-3 flex justify-between">
              <div class="flex items-center space-x-1">
                <svg-vue icon="core"></svg-vue>
                <span>Core</span>
              </div>
              <HoverText
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
              ></HoverText>
            </div>
            <div class="flex justify-between">
              <div class="flex items-center space-x-1">
                <svg-vue icon="double-tick"></svg-vue>
                <span>Completed</span>
              </div>
              <HoverText
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
              ></HoverText>
            </div>
          </div>
        </div>
        <Elements :data="elements" />
      </aside>
      <div class="activities__content">
        <div class="inline-flex">
          <button v-for="(post, index) in element_group" class="tab-btn mr-2">
            <span>{{ post.label }}</span>
            <span class="hover__text">
              <HoverText
                :name="post.label"
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                icon_size="text-tiny"
              ></HoverText>
            </span>
          </button>
        </div>

        <div
          v-for="(post, index) in activityGrouped.data"
          :class="index"
          class="basis-6/12"
        >
          <div class="activities__content--elements -mx-3 flex flex-wrap">
            <ActivityElement
              v-for="(element, index) in post"
              :title="index"
              :width="index === 'title' ? 'full' : ''"
              content="AF-COA-1234"
              icon="align-center"
              status="completed"
              tooltip="Example text"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive, ref } from 'vue';
import HoverText from '../../components/HoverText.vue';
import ProgressBar from '../../components/ProgressBar.vue';
import Elements from './partials/ActivitiesElements.vue';
import ActivityElement from './partials/ActivityElement.vue';

export default defineComponent({
  components: {
    HoverText,
    ProgressBar,
    Elements,
    ActivityElement,
  },
  props: {
    elements: {
      type: Object,
      required: false,
    },
    element_group: {
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
     * Grouping all the datas for scroll function
     *
     * static data for now
     * this data will be created using props.element_group and props.activity
     */
    const activityGrouped = reactive({
      data: {
        identification: {
          iati_identifier: {
            activity_identifier: 'SYRZ000041',
            iati_identifier_text: 'CZ-ICO-25755277-SYRZ000041',
          },
          title: [
            {
              language: 'en',
              narrative: 'DGGF Track 3',
            },
          ],
        },
      },
    });

    /**
     * Scroll to section function
     *
     * to be continue
     */

    const scrollRef = ref([]);

    return {
      scrollRef,
      activityGrouped,
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
}
</style>
