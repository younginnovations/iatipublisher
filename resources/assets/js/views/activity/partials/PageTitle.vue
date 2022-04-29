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
          <BtnComponent
            class="mr-3.5"
            type="secondary"
            text="Download Selected"
            icon="download-file"
            v-if="showButtons"
          />
          <BtnComponent
            class="mr-3.5"
            type="secondary"
            text="Publish Selected"
            icon="approved-cloud"
            v-if="showButtons"
            @click="modalValue = true"
          />
          <BtnComponent
            class="mr-3.5"
            type="secondary"
            text="Delete Selected"
            icon="delete"
            v-if="showButtons"
          />
          <BtnComponent
            class="mr-3.5"
            type="secondary"
            text="Download All"
            icon="download-file"
          />
          <BtnComponent
            class="mr-3.5"
            type="secondary"
            text="Publish"
            icon="publish"
            @click="modalValue = true"
          />
          <AddActivityButton />
        </div>
      </div>
    </div>

    <!-- ==============================
          Toast Message that shows
          publishable status
        ===============================-->
    <div
      class="fixed right-10 bottom-0 inline-flex rounded-t-lg bg-eggshell py-4 px-8 text-sm leading-normal text-n-50"
    >
      <span>5 activities ready to publish</span>
      <span
        class="ml-2.5 cursor-pointer font-bold text-spring-50"
        @click="modalValue = true"
      >
        Publish all
      </span>
    </div>

    <!-- =====================
          Toggle modal
    ==========================-->
    <Modal @close="modalToggle" :modalActive="modalValue">
      <div class="eligible-activities mb-6 text-sm leading-relaxed">
        <div class="title mb-6 flex">
          <svg-vue
            icon="tick"
            class="mr-1 mt-0.5 text-lg text-spring-50"
          ></svg-vue>
          <b>The following activities are eligible for publishing</b>
        </div>
        <div class="eligible-list rounded-lg bg-mint px-6">
          <div class="list border-b border-n-20 py-6">
            <a href="#" class=""> EU-Angola Dialogue Facility </a>
          </div>
          <div class="list border-b border-n-20 py-6">
            <a href="#" class=""> Programme in support of Higher Education </a>
          </div>
          <div class="list py-6">
            <a href="#" class="">
              AGO.S1 Leadership, advocacy and communication to fast track the
              AIDS response
            </a>
          </div>
        </div>
      </div>

      <div class="non-eligible-activities mb-6 text-sm leading-relaxed">
        <div class="title mb-6 flex">
          <svg-vue
            icon="warning-fill"
            class="mr-1 mt-0.5 text-lg text-crimson-40"
          ></svg-vue>
          <b>The following activities are eligible for publishing</b>
        </div>
        <div class="eligible-list rounded-lg bg-rose px-6">
          <div class="list border-b border-n-20 py-6">
            <a href="#" class=""> EU-Angola Dialogue Facility </a>
          </div>
          <div class="list border-b border-n-20 py-6">
            <a href="#" class=""> Programme in support of Higher Education </a>
          </div>
          <div class="list py-6">
            <a href="#" class="">
              UNFPA Angola Improved national population data systems to map and
              address inequalities; to advance achievement of the Sustainable
              Development Goals and the commitments of the Programme of Action
              of the International Cference on Population and Development; and
              to strengthen interventions in humanitarian crises activities
            </a>
          </div>
        </div>
      </div>
      <div class="flex justify-end">
        <div class="inline-flex">
          <BtnComponent
            class="bg-white px-6 uppercase"
            @click="modalValue = false"
            text="Cancel"
          />
          <BtnComponent
            class="space"
            type="primary"
            @click="modalValue = false"
            text="Publish"
          />
        </div>
      </div>
    </Modal>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useToggle } from '@vueuse/core';
import ToastMessage from '../../../components/ToastMessage.vue';
import AddActivityButton from './AddActivityButton.vue';
import Modal from '../../../components/PopupModal.vue';
import BtnComponent from '../../../components/ButtonComponent.vue';

export default defineComponent({
  name: 'page-title',
  components: { AddActivityButton, Modal, BtnComponent, ToastMessage },
  props: {
    showButtons: Boolean,
  },
  setup() {
    const [modalValue, modalToggle] = useToggle();

    return {
      modalValue,
      modalToggle,
    };
  },
});
</script>
