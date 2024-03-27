<template>
  <Modal :modal-active="showModal" width="583" @close="closeModal">
    <div
      class="modal-dialog max-w-xl rounded-lg bg-white p-3 shadow-2xl"
      role="document"
    >
      <div class="modal-content py-3 px-6">
        <div class="relative flex justify-between pb-4">
          <!-- Remove align-middle class -->
          <div class="flex items-center gap-2.5">
            <div class="flex items-center justify-center">
              <!-- Added flex and justify-center -->
              <img
                src="{{ url('/images/warning-activity-salmon.svg') }}"
                alt=""
                class="h-5"
              />
            </div>
            <div>
              <h4 class="text-[16px] font-bold">
                Organization-Identifier has changed
              </h4>
            </div>
          </div>
        </div>

        <div class="mb-4 rounded border border-camel-40 bg-eggshell p-3 px-5">
          <div class="pb-3">
            <strong class="text-[14px]"
              >Updating the Organization Identifier will update the following
              elements:</strong
            >
            <ul class="ml-2 list-disc px-3 text-n-50">
              <li class="text-[14px]">
                Iati-identifier of all non-published activities.
              </li>
              <li class="text-[14px]">Reporting-org of all activities.</li>
            </ul>
          </div>

          <p class="text-[14px]">Are you sure you want to save the change ?</p>
        </div>
        <div class="align-end flex justify-end gap-3">
          <button
            type="button"
            class="font-weight-bold rounded bg-white px-2 py-1 font-bold uppercase text-n-40 hover:bg-black hover:text-white"
            data-dismiss="modal"
            @click="closeModal"
          >
            Cancel
          </button>
          <button
            type="submit"
            id="submitSaveAndExit"
            class="btn primary-btn px-2 py-1 font-bold uppercase"
            data-loading-text="Loading"
            onclick="submitSaveAndExit()"
          >
            SAVE AND EXIT
          </button>
        </div>
      </div>
    </div>
  </Modal>
</template>
<script setup lang="ts">
import Modal from 'Components/PopupModal.vue';
import { ref, onMounted, defineProps, watch } from 'vue';
const props = defineProps({
  formData: { type: Object, required: true },
});

const showModal = ref(false);

const closeModal = () => {
  console.log('close');
  showModal.value = false;
};

onMounted(() => {
  const organizationIdentifier = document.querySelector<HTMLInputElement>(
    '#organisation_identifier'
  );

  if (organizationIdentifier) {
    organizationIdentifier.addEventListener('change', (event) => {
      console.log('Input value changed:', organizationIdentifier.value);
    });
  }
});

console.log(props.formData, 'here');

watch;
</script>
