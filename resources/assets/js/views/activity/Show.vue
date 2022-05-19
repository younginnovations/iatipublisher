<template>
  <div class="bg-paper px-10 pt-4 pb-[71px]">
    <!-- title section -->
    <div class="page-title mb-6">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="mb-4 text-caption-c1 text-n-40">
            <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
              <p>
                <a class="font-bold" href="/activities">Your Activities</a>
                <span class="separator mx-4"> / </span>
                <span class="last text-n-30">{{ pageTitle }}</span>
              </p>
            </nav>
          </div>
          <div class="inline-flex items-center">
            <div class="mr-3">
              <a href="/activities">
                <svg-vue icon="arrow-short-left"></svg-vue>
              </a>
            </div>
            <h4 class="mr-4 font-bold">
              {{ pageTitle }}
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
        <div class="inline-flex flex-wrap">
          <a
            v-for="(post, index) in groupedData"
            v-smooth-scroll
            :href="`#${index}`"
            class="tab-btn-anchor"
          >
            <button :disabled="post.status == 'disabled'" class="tab-btn mr-2">
              <span>{{ post.label }}</span>
              <span class="hover__text">
                <HoverText
                  :name="post.label"
                  hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                  icon_size="text-tiny"
                  name=""
                ></HoverText>
              </span>
            </button>
          </a>
        </div>

        <div v-for="(post, index) in activities" :id="index">
          <div class="activities__content--elements -mx-3 flex flex-wrap">
            <template v-for="(element, a) in post.elements">
              <ActivityElement
                v-if="element.content.length > 0"
                :content="element.content"
                :element_name="a"
                :title="a"
                :width="a === 'title' ? 'full' : ''"
                status="completed"
                tooltip="Example text"
              />
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
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
     * Finding current language - activity title
     */
    let pageTitle = '';
    const found = props.activity.title.find(
      (e: { language: string }, index: number) => {
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
    Object.keys(activities).map((key, index) => {
      let flag = false;
      Object.keys(activities[key]['elements']).map((k, i) => {
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
    Object.keys(groupedData).map((key, index) => {
      if (activities.hasOwnProperty(key)) {
        groupedData[key]['status'] = 'enabled';
      } else {
        groupedData[key]['status'] = 'disabled';
      }
    });

    return {
      groupedData,
      activities,
      pageTitle,
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
