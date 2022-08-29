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
          <!-- Hidden for now -->
          <!-- <BtnComponent
            v-if="showButtons"
            class="mr-3.5"
            type="secondary"
            text="Download Selected"
            icon="download-file"
          /> -->
          <BtnComponent
            v-if="showButtons"
            class="mr-3.5"
            type="secondary"
            text="Publish Selected"
            icon="approved-cloud"
            @click="modalValue = true"
          />
          <!-- Hidden for now -->
          <!-- <BtnComponent
            class="mr-3.5"
            type="secondary"
            text="Download All"
            icon="download-file"
          /> -->
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

    <!-- =====================
          Toggle modal
    ==========================-->
    <Modal :modal-active="modalValue" @close="modalToggle">
      <div class="max-w-[809px]">
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
              <a href="#" class="">
                Programme in support of Higher Education
              </a>
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
              <a href="#" class="">
                Programme in support of Higher Education
              </a>
            </div>
            <div class="list py-6">
              <a href="#" class="">
                UNFPA Angola Improved national population data systems to map
                and address inequalities; to advance achievement of the
                Sustainable Development Goals and the commitments of the
                Programme of Action of the International Cference on Population
                and Development; and to strengthen interventions in humanitarian
                crises activities
              </a>
            </div>
          </div>
        </div>
        <div class="flex justify-end">
          <div class="inline-flex">
            <BtnComponent
              class="bg-white px-6 uppercase"
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
      </div>
    </Modal>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { useToggle } from '@vueuse/core';
import AddActivityButton from './AddActivityButton.vue';
import Modal from '../../../components/PopupModal.vue';
import BtnComponent from '../../../components/ButtonComponent.vue';
import Toast from '../../../components/Toast.vue';

export default defineComponent({
  name: 'PageTitle',
  components: {
    AddActivityButton,
    Modal,
    BtnComponent,
  },
  props: {
    showButtons: Boolean,
  },
  setup() {
    const [modalValue, modalToggle] = useToggle();

    const toastVisibility = ref(false);
    const toastMessage = ref('');
    const toastType = ref(false);

    function toast(message: string, type: boolean) {
      toastVisibility.value = true;
      setTimeout(() => (toastVisibility.value = false), 5000);
      toastMessage.value = message;
      toastType.value = type;
    }

    return {
      modalValue,
      modalToggle,
      toastVisibility,
      toastMessage,
      toastType,
      toast,
    };
  },
});
</script>
