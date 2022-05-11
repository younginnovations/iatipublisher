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
          <button
            :class="
              tab === ''
                ? 'tab-btn active__tab mr-2 flex items-center'
                : 'tab-btn mr-2'
            "
            @click="toggleTab('')"
          >
            <span>Identification</span>
            <span class="hover__text">
              <HoverText
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                icon_size="text-tiny"
                name="Identification"
              ></HoverText>
            </span>
          </button>
          <button
            :class="tab === '' ? 'tab-btn active__tab mr-2' : 'tab-btn mr-2'"
            @click="toggleTab('')"
          >
            <span>Basic Information</span>
            <span class="hover__text">
              <HoverText
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                icon_size="text-tiny"
                name="Basic Information"
              ></HoverText>
            </span>
          </button>
          <button
            :class="tab === '' ? 'tab-btn active__tab mr-2' : 'tab-btn mr-2'"
            @click="toggleTab('')"
          >
            <span>Participating Org</span>
            <span class="hover__text">
              <HoverText
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                icon_size="text-tiny"
                name="Participating Org"
              ></HoverText>
            </span>
          </button>
          <button
            :class="tab === '' ? 'tab-btn active__tab mr-2' : 'tab-btn mr-2'"
            @click="toggleTab('')"
          >
            <span>Humanitarian Info</span>
            <span class="hover__text">
              <HoverText
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                icon_size="text-tiny"
                name="Humanitarian Info"
              ></HoverText>
            </span>
          </button>
          <button
            :class="tab === '' ? 'tab-btn active__tab mr-2' : 'tab-btn mr-2'"
            @click="toggleTab('')"
          >
            <span>Geography</span>
            <span class="hover__text">
              <HoverText
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                icon_size="text-tiny"
                name="Geography"
              ></HoverText>
            </span>
          </button>
          <button
            :class="tab === '' ? 'tab-btn active__tab mr-2' : 'tab-btn mr-2'"
            @click="toggleTab('')"
          >
            <span>Classification</span>
            <span class="hover__text">
              <HoverText
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                icon_size="text-tiny"
                name="Classification"
              ></HoverText>
            </span>
          </button>
          <button
            :class="tab === '' ? 'tab-btn active__tab mr-2' : 'tab-btn mr-2'"
            @click="toggleTab('')"
          >
            <span>Financial</span>
            <span class="hover__text">
              <HoverText
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                icon_size="text-tiny"
                name="Financial"
              ></HoverText>
            </span>
          </button>
          <button
            :class="tab === '' ? 'tab-btn active__tab mr-2' : 'tab-btn mr-2'"
            @click="toggleTab('')"
          >
            <span>Related docs</span>
            <span class="hover__text">
              <HoverText
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                icon_size="text-tiny"
                name="Related docs"
              ></HoverText>
            </span>
          </button>
          <button
            :class="tab === '' ? 'tab-btn active__tab mr-2' : 'tab-btn mr-2'"
            @click="toggleTab('')"
          >
            <span>Relations</span>
            <span class="hover__text">
              <HoverText
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                icon_size="text-tiny"
                name="Relations"
              ></HoverText>
            </span>
          </button>
          <button
            :class="tab === '' ? 'tab-btn active__tab' : 'tab-btn'"
            @click="toggleTab('')"
          >
            <span>Results</span>
            <span class="hover__text">
              <HoverText
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                icon_size="text-tiny"
                name="Results"
              ></HoverText>
            </span>
          </button>
        </div>
        <div class="activities__content--elements -mx-3 flex flex-wrap">
          <!-- iati-identifier -->
          <ActivityElement
            content="AF-COA-1234"
            icon="align-center"
            status="completed"
            title="iati-publisher"
            tooltip="Example text"
          />
          <!-- reporting-org -->
          <ActivityElement
            content="Younginnovations"
            icon="building"
            status="completed"
            title="reporting-org"
            tooltip="Example text"
          />
          <!-- title -->
          <ActivityElement
            content="Partnership Against Child Exploitation"
            icon="note"
            language="english"
            status="completed"
            title="title"
            tooltip="Example text"
            width="full"
          />
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
      required: true,
    },
    elementGroups: {
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
    const dropdown = ref();
    const dropdownBtn = ref();
    const state = reactive({
      isVisible: false,
    });

    const toggle = () => {
      state.isVisible = !state.isVisible;
    };
    return {
      state,
      dropdown,
      dropdownBtn,
      toggle,
    };
  },
});
</script>

<style lang="scss">
.activities {
  @apply grid grid-flow-col gap-7;

  &__sidebar {
    width: 280px;
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
