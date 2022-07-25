<template>
  <div class="mb-4 page-title">
    <div class="flex items-end gap-4">
      <div class="title grow-0">
        <div class="mb-4 text-caption-c1 text-n-40">
          <nav aria-label="breadcrumbs" class="breadcrumb">
            <p>
              <span class="font-bold last">Your Activities</span>
            </p>
          </nav>
        </div>
        <div class="inline-flex items-center">
          <h4 class="mr-4 font-bold">Your Activities</h4>
          <div class="tooltip-btn">
            <button class="">
              <svg-vue icon="question-mark" />
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
                  publishing the data. For example, an activity could be a donor
                  government providing US$ 50 million to a recipient country’s
                  government in order to implement basic education over 5 years.
                  Another activity could be an NGO spending US$ 500,000 to
                  deliver clean drinking water to 1000 households over 6 months.
                </p>
                <p class="text-n-40">
                  Learn more about how to publish data on activities in IATI’s
                  publishing
                  <a href="#" class="text-bluecoral"><b>guidance.</b></a
                  >.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="flex justify-end actions grow">
        <div class="inline-flex justify-center">
          <BtnComponent
            v-if="showButtons"
            class="mr-3.5"
            type="secondary"
            text="Download Selected"
            icon="download-file"
          />
          <BtnComponent
            v-if="showButtons"
            class="mr-3.5"
            type="secondary"
            text="Publish Selected"
            icon="approved-cloud"
            @click="modalValue = true"
          />
          <BtnComponent
            v-if="showButtons"
            class="mr-3.5"
            type="secondary"
            text="Delete Selected"
            icon="delete"
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
    <ToastMessage />

    <!-- =====================
          Toggle modal
    ==========================-->
    <Modal :modal-active="modalValue" @close="modalToggle">
      <div class="mb-6 text-sm leading-relaxed eligible-activities">
        <div class="flex mb-6 title">
          <svg-vue icon="tick" class="mr-1 mt-0.5 text-lg text-spring-50" />
          <b>The following activities are eligible for publishing</b>
        </div>
        <div class="px-6 rounded-lg eligible-list bg-mint">
          <div class="py-6 border-b list border-n-20">
            <a href="#" class=""> EU-Angola Dialogue Facility </a>
          </div>
          <div class="py-6 border-b list border-n-20">
            <a href="#" class=""> Programme in support of Higher Education </a>
          </div>
          <div class="py-6 list">
            <a href="#" class="">
              AGO.S1 Leadership, advocacy and communication to fast track the
              AIDS response
            </a>
          </div>
        </div>
      </div>

      <div class="mb-6 text-sm leading-relaxed non-eligible-activities">
        <div class="flex mb-6 title">
          <svg-vue
            icon="warning-fill"
            class="mr-1 mt-0.5 text-lg text-crimson-40"
          />
          <b>The following activities are eligible for publishing</b>
        </div>
        <div class="px-6 rounded-lg eligible-list bg-rose">
          <div class="py-6 border-b list border-n-20">
            <a href="#" class=""> EU-Angola Dialogue Facility </a>
          </div>
          <div class="py-6 border-b list border-n-20">
            <a href="#" class=""> Programme in support of Higher Education </a>
          </div>
          <div class="py-6 list">
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
            class="px-6 uppercase bg-white"
            type=""
            text="Cancel"
            @click="modalValue = false"
          />
          <BtnComponent
            class="space"
            type="primary"
            text="Publish"
            @click="modalValue = false"
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
  name: 'PageTitle',
  components: {
    AddActivityButton,
    Modal,
    BtnComponent,
    ToastMessage,
  },
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
