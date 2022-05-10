<template>
  <div class="bg-paper px-10 pt-4 pb-[71px]">
    <!-- title section -->
    <div class="page-title mb-6">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="mb-4 text-caption-c1 text-n-40">
            <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
              <p>
                <a href="/" class="font-bold">Your Activities</a>
                <span class="separator mx-4"> / </span>
                <span class="last text-n-30"
                  >Partnership against child exploitation</span
                >
              </p>
            </nav>
          </div>
          <div class="inline-flex items-center">
            <div class="mr-3">
              <a href="/"><svg-vue icon="arrow-short-left"></svg-vue></a>
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
                name=""
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
              ></HoverText>
            </div>
            <ProgressBar class="mb-3" percent="60"></ProgressBar>
            <span>Fill core elements to get 100% score</span>
          </div>
          <div class="activities__card elements">
            <div class="mb-7 flex items-center justify-between">
              <span>Elements</span>
              <HoverText
                name=""
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
              ></HoverText>
            </div>
            <div class="mb-3 flex justify-between">
              <div class="flex items-center space-x-1">
                <svg-vue icon="core"></svg-vue>
                <span>Core</span>
              </div>
              <HoverText
                name=""
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
              ></HoverText>
            </div>
            <div class="flex justify-between">
              <div class="flex items-center space-x-1">
                <svg-vue icon="double-tick"></svg-vue>
                <span>Completed</span>
              </div>
              <HoverText
                name=""
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
              ></HoverText>
            </div>
          </div>
        </div>
        <Elements />
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
                icon_size="text-tiny"
                name="Identification"
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
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
                icon_size="text-tiny"
                name="Basic Information"
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
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
                icon_size="text-tiny"
                name="Participating Org"
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
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
                icon_size="text-tiny"
                name="Humanitarian Info"
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
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
                icon_size="text-tiny"
                name="Geography"
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
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
                icon_size="text-tiny"
                name="Classification"
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
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
                icon_size="text-tiny"
                name="Financial"
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
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
                icon_size="text-tiny"
                name="Related docs"
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
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
                icon_size="text-tiny"
                name="Relations"
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
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
                icon_size="text-tiny"
                name="Results"
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
              ></HoverText>
            </span>
          </button>
        </div>
        <div class="activities__content--elements">
          <!--    iati-identifier      -->
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref, reactive } from 'vue';
import HoverText from '../../components/HoverText.vue';
import ProgressBar from '../../components/ProgressBar.vue';
import Elements from './partials/ActivitiesElements.vue';

export default defineComponent({
  components: {
    HoverText,
    ProgressBar,
    Elements,
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
      props,
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
  .elements {
    border-radius: 0px 8px 8px 0px;
    width: 125px;
    height: 174px;
  }
  .elements__panel {
    @apply rounded-lg p-4 shadow-dropdown;
    height: 1232px;

    .panel__input:focus,
    .panel__search:focus {
      @apply text-n-40;
    }
  }
  .hover__text {
    @apply ml-1;
  }
}
</style>
