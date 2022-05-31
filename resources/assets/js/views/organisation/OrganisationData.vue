<template>
  <div class="page-height bg-n-10 px-10 pt-4 pb-[71px]">
    <!-- title section -->
    <div class="page-title mb-6">
      <div class="mb-6 text-caption-c1 text-n-40">
        <BreadCrumb title="Organisation Name"></BreadCrumb>
      </div>
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="inline-flex items-center">
            <div class="mr-3">
              <a href="/activities">
                <svg-vue icon="arrow-short-left"></svg-vue>
              </a>
            </div>
            <h4 class="mr-4 font-bold">Organisation Name</h4>
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
        <div
          class="grid grid-cols-2 items-center justify-items-center rounded-lg bg-white py-3.5 text-center text-tiny text-n-30 shadow-dropdown"
        >
          <div class="mandatory relative flex flex-col items-center">
            <span class="mr-2">Your overall progress</span>
            <RadialProgressBar class="my-2.5 h-20 text-8xl"></RadialProgressBar>
            <p>
              <span class="text-spring-50">1</span> mandatory <br />
              elements completed
            </p>
          </div>
          <div class="">
            <div class="mb-7 flex items-center space-x-6">
              <span>Element Notes</span>
              <HoverText
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
              ></HoverText>
            </div>
            <div class="element">
              <div class="element__inner">
                <span
                  class="element__notes border-dashed border-salmon-50"
                ></span>
                <span>Mandatory</span>
              </div>
            </div>
            <div class="element">
              <div class="element__inner">
                <span class="element__notes border border-spring-50"></span>
                <span>Completed</span>
              </div>
            </div>
            <div class="element">
              <div class="element__inner">
                <span
                  class="element__notes border-dashed border-lavender-50"
                ></span>
                <span>DQI</span>
              </div>
            </div>
            <div class="ml-2">
              <div class="element__inner">
                <span class="element__notes border-dashed border-n-40"></span>
                <span>Optional</span>
              </div>
            </div>
          </div>
        </div>
        <OrganisationElements :data="elements" />
      </aside>
      <div class="flex w-[77%] flex-col">
        <nav
          class="mb-2 rounded-lg border border-n-30 bg-white pt-6 text-xs text-n-40"
        >
          <ul class="flex items-center justify-evenly">
            <li class="tab__links">
              <a
                v-smooth-scroll
                href="#identification"
                :class="tab === 'identification' ? 'tab__links--active' : ''"
                @click="toggleTab('identification')"
                >Identification</a
              >
            </li>
            <li class="tab__links">
              <a
                v-smooth-scroll
                href="#budget"
                :class="tab === 'budget' ? 'tab__links--active' : ''"
                @click="toggleTab('budget')"
                >Budget</a
              >
            </li>
            <li class="tab__links">
              <a
                v-smooth-scroll
                href="#expenditure"
                :class="tab === 'expenditure' ? 'tab__links--active' : ''"
                @click="toggleTab('expenditure')"
                >Expenditure</a
              >
            </li>
            <li class="tab__links">
              <a
                v-smooth-scroll
                href="#document_link"
                :class="tab === 'document_link' ? 'tab__links--active' : ''"
                @click="toggleTab('document_link')"
                >Documents</a
              >
            </li>
          </ul>
        </nav>

        <div class="activities__content--elements -mx-3 flex flex-wrap">
          <template v-for="(post, key, index) in organisation" :key="index">
            <template v-for="(element, name, i) in post.elements" :key="i">
              <ElementsDetail
                :id="key"
                :content="element.content"
                :data="element"
                :title="name"
                :width="
                  name === 'org_name' ||
                  name === 'total_expenditure' ||
                  name === 'document_link'
                    ? 'full'
                    : ''
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
import { defineComponent, reactive, ref } from 'vue';
import HoverText from '../../components/HoverText.vue';
import ProgressBar from '../../components/ProgressBar.vue';
import ActivityElement from '../activity/partials/ActivityElement.vue';
import RadialProgressBar from '../../components/RadialProgressBar.vue';
import OrganisationElements from './OrganisationElements.vue';
import ElementsDetail from './ElementsDetail.vue';
import BreadCrumb from '../../components/BreadCrumb.vue';

export default defineComponent({
  name: 'activities-elements',
  components: {
    HoverText,
    ProgressBar,
    ActivityElement,
    RadialProgressBar,
    OrganisationElements,
    ElementsDetail,
    BreadCrumb,
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
    const tab = ref('identification');
    function toggleTab(page: string) {
      tab.value = page;
    }
    const elements = reactive({
      org_identifier: '',
      name: '',
      reporting_org: '',
      total_budget: '',
      recipient_org_budget: '',
      recipient_country_budget: '',
      recipient_region_budget: '',
      total_expenditure: '',
      document_link: '',
    });

    let pageTitle = '';

    /**
     * Grouping all the data's for scroll function
     *
     * this data is created using props.element_group and props.activity
     */
    const groupedData = { ...props.element_group },
      detailData = props.activity,
      organisation = { ...props.element_group };

    // generating available elements
    Object.keys(organisation).map((key, index) => {
      let flag = false;
      Object.keys(organisation[key]['elements']).map((k, i) => {
        if (detailData[k]) {
          organisation[key]['elements'][k]['content'] = detailData[k];
          flag = true;
        } else {
          organisation[key]['elements'][k]['content'] = [];
        }
      });

      // generating available categories of elements
      Object.keys(groupedData).map((key, index) => {
        if (organisation.hasOwnProperty(key)) {
          groupedData[key]['status'] = 'enabled';
        } else {
          groupedData[key]['status'] = 'disabled';
        }
      });
    });
    return {
      elements,
      organisation,
      groupedData,
      pageTitle,
      tab,
      toggleTab,
    };
  },
});
</script>

<style lang="scss">
.mandatory::after {
  content: '';
  width: 0.5px;
  height: 140px;
  @apply absolute top-1 -right-6 bg-n-20;
}
.element {
  @apply mb-3 ml-2;

  &__inner {
    @apply flex space-x-2.5;
  }

  &__notes {
    @apply h-4 w-8 rounded-sm border;
  }
}
.element__search {
  @apply my-4 h-10 w-full rounded border border-n-30 bg-white py-3 pr-3 pl-10 text-n-40 outline-none duration-300;

  &::placeholder {
    @apply text-sm text-n-30 duration-300;
    letter-spacing: -0.02em;
  }
  &:focus::placeholder {
    @apply text-n-40;
  }
}
.tab__links {
  @apply relative cursor-pointer px-2 pb-6;

  &::after {
    content: '';
    @apply absolute bottom-0 left-0 h-1 w-full scale-0 bg-bluecoral duration-300;
  }
  &:hover::after {
    content: '';
    @apply visible scale-100;
  }
  &--active {
    @apply font-bold text-bluecoral;
  }
}
.tab__links--active::after {
  content: '';
  @apply absolute bottom-0 left-0 h-1 w-full bg-bluecoral duration-300;
}
.separator {
  @apply mx-4;
}
.last {
  @apply text-n-30;
}
</style>
