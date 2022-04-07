<template>
  <div class="page-title mb-4">
    <div class="flex items-end gap-4">
      <div class="title grow-0">
        <div class="mb-4 text-caption-c1 font-bold text-n-40">
          Your Activities
        </div>
        <div class="inline-flex items-center">
          <h4 class="mr-4 font-bold">Your Activities</h4>
          <div class="tooltip-btn">
            <button class="">
              <svg-vue icon="question-mark"></svg-vue>
              <span>What is activity?</span>
            </button>
            <div class="tooltip-btn__content z-[1]">
              <div class="content">
                <div class="mb-1.5 text-caption-c1 font-bold text-bluecoral">
                  What is an activity?
                </div>
                <p>
                  Organisations need to publish data on their activities. An
                  ‘activity’ is an individual project or piece of development
                  and humanitarian work. The unit of work described by an
                  ‘activity’ is determined by the organisation that is
                  publishing the data.
                </p>
                <p>
                  For example, an activity could be a donor government providing
                  US$ 100 million to a recipient country’s state bank to
                  implement basic education over 8 years.
                </p>
                <p class="text-n-40">
                  To know more about how to publish data on activities according
                  to the IATI read the
                  <a href="#" class="text-bluecoral"><b>full guidance</b></a
                  >.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="actions flex grow justify-end">
        <div class="inline-flex justify-center">
          <button
            class="button secondary-btn mr-3.5 font-bold"
            v-show="showButtons"
          >
            <svg-vue icon="download-file"></svg-vue>
            <span>Download Selected</span>
          </button>

          <!--    Toggle modal      -->
          <Modal @close="toggleModal" :modalActive="state.modalActive">
            <alert :type="'success'" class="mb-1"
              >The following activities are eligible for publishing</alert
            >
            <div class="checked-list">
              <div class="list px-6">
                <a href="#" class="block border-b border-n-20 py-4"
                  >EU-Angola Dialogue Facility</a
                >
              </div>
            </div>
            <alert :type="'failure'" class="mt-1 mb-1"
              >The following activities are not eligible for publishing</alert
            >
            <div class="checked-list">
              <div class="list px-6">
                <a href="#" class="block border-b border-n-20 py-4"
                  >Programme in support of Higher Education Agro-PRODESI:
                  Acceleration of inclusive & sustainable agribusiness
                  investment in economic corridors</a
                >
              </div>
            </div>
          </Modal>
          <button
            class="button secondary-btn mr-3.5 font-bold"
            v-show="showButtons"
            @click="state.modalActive = true"
          >
            <svg-vue icon="approved-cloud"></svg-vue>
            <span>Publish Selected</span>
          </button>
          <button
            class="button secondary-btn mr-3.5 font-bold"
            v-show="showButtons"
          >
            <svg-vue icon="delete"></svg-vue>
            <span>Delete Selected</span>
          </button>
          <button class="button secondary-btn mr-3.5 font-bold">
            <svg-vue icon="download-file"></svg-vue>
            <span>Download All</span>
          </button>
          <button class="button secondary-btn mr-3.5 font-bold">
            <svg-vue icon="publish"></svg-vue>
            <span>Publish</span>
          </button>
          <AddActivityButton />
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive } from 'vue';
import AddActivityButton from './AddActivityButton.vue';
import Modal from '../../../components/PopupModal.vue';
import Alert from '../../../components/AlertMessage.vue';

export default defineComponent({
  name: 'page-title',
  components: { AddActivityButton, Modal, Alert },
  props: {
    showButtons: Boolean,
  },
  setup() {
    const state = reactive({
      modalActive: false,
    });

    const data = {
      activityList: [
        {
          title: 'EU-Angola Dialogue Facility',
          permalink: '#',
          canBePublished: true,
        },
        {
          title:
            'Programme in support of Higher Education Agro-PRODESI: Acceleration of inclusive & sustainable agribusiness investment in economic corridors',
          permalink: '#',
          canBePublished: false,
        },
        {
          title:
            'UNFPA Angola Improved national population data systems to map and address inequalities; to advance achievement of the Sustainable Development Goals and the commitments of the Programme of Action of the International Cference on Population and Development; and to strengthen interventions in humanitarian crises activities',
          permalink: '#',
          canBePublished: false,
        },
        {
          title: 'Programme in support of Higher Education',
          permalink: '#',
          canBePublished: true,
        },
        {
          title:
            'AGO.S1 Leadership, advocacy and communication to fast track the AIDS response',
          permalink: '#',
          canBePublished: true,
        },
      ],
    };

    const list = reactive({
      publishable: [],
      nonPublishable: [],
    });

    // computed function
    // const selectedItems = computed({
    //
    // });

    // toggle function
    const toggleModal = () => {
      state.modalActive = false;
    };

    return {
      state,
      data,
      list,
      toggleModal,
    };
  },
});
</script>
