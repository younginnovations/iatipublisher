<template>
  <div class="page-title mb-4">
    <div class="flex gap-4 md:items-end">
      <div class="title shrink-0 grow-0">
        <div class="mb-2 text-caption-c1 text-n-40 xl:mb-4">
          <nav aria-label="breadcrumbs" class="breadcrumb">
            <p>
              <span class="last font-bold">Your Activities</span>
            </p>
          </nav>
        </div>
        <div class="inline-flex flex-col space-y-2 md:flex-row md:items-center">
          <h4 class="mr-4 text-3xl font-bold xl:text-heading-4">
            Your Activities
          </h4>
          <div class="tooltip-btn">
            <button class="">
              <svg-vue icon="question-mark" />
              <span>What is an activity?</span>
            </button>
            <div class="tooltip-btn__content z-[1]">
              <div class="content">
                <div class="mb-1.5 text-caption-c1 font-bold text-bluecoral">
                  What is an activity?
                </div>
                <p>
                  You need to provide data about your organisation's development
                  and humanitarian 'activities'. The unit of work described by
                  an 'activity' is determined by the organisation that is
                  publishing the data. For example, an activity could be a donor
                  government providing US$ 50 million to a recipient country's
                  government to implement basic education over 5 years. Or an
                  activity could be an NGO spending US$ 500,000 to deliver clean
                  drinking water to 1000 households over 6 months.
                  <br />
                  Therefore your organisation will need to determine how it will
                  divide its work internally into activities. Read the
                  <a
                    target="_blank"
                    rel="noopener noreferrer"
                    href="/publishing-checklist"
                    class="text-bluecoral"
                    ><b>Publishing Checklist</b></a
                  >
                  for more information.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div
        class="actions relative inline-flex grow flex-col items-end justify-end space-y-2 xl:flex-row"
      >
        <Toast
          v-if="toastMessage.visibility"
          class="whitespace-nowrap lg:mr-3.5"
          :message="toastMessage.message"
          :type="toastMessage.type"
        />

        <Modal :modal-active="errorData.visibility" width="583">
          <div>
            <BulkPublishingErrorPopup></BulkPublishingErrorPopup>

            <div class="mt-4 flex justify-between space-x-4">
              <button
                class="rounded py-3 px-5 font-semibold uppercase text-n-40 hover:bg-bluecoral hover:text-white"
                @click="cancelOtherBulkPublish"
              >
                Cancel previous bulk publish
              </button>
              <button
                class="rounded bg-bluecoral py-3 px-5 font-semibold uppercase text-white"
                @click="closeModal"
              >
                Wait for completion
              </button>
            </div>
          </div>
        </Modal>

        <Modal width="583" :modal-active="showCancelledPopup">
          <h3 class="mb-4 text-lg font-medium">
            <svg-vue icon="tick" class="mr-2 inline text-spring-50"></svg-vue>
            <span class="font-bold">Cancellation Successful</span>
          </h3>
          <div class="fw-bold rounded-lg bg-spring-20 px-3 py-2 text-white">
            {{ messageOnCancellation }}
          </div>
          <div class="d-flex justify-content-end my-3">
            <PublishSelected />
          </div>
        </Modal>

        <div class="inline-flex justify-end">
          <div
            class="inline-flex shrink-0 flex-col items-end justify-end gap-3 lg:flex-row"
          >
            <RefreshToastMessage
              v-if="refreshToastMsg.visibility"
              :message="refreshToastMsg.refreshMessage"
              :type="refreshToastMsg.refreshMessageType"
            />
            <div class="flex flex-col items-end gap-2 lg:flex-row">
              <div class="flex gap-2">
                <DownloadActivityButton /> <PublishSelected />
              </div>
              <div class="flex gap-2">
                <DeleteButton
                  v-if="store.state.selectedActivities.length === 1"
                />
                <AddActivityButton />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { inject, ref } from 'vue';
import DownloadActivityButton from './DownloadActivityButton.vue';
import AddActivityButton from './AddActivityButton.vue';
import Toast from 'Components/ToastMessage.vue';
import RefreshToastMessage from 'Activity/bulk-publish/RefreshToast.vue';
import PublishSelected from 'Activity/bulk-publish/PublishSelected.vue';
import DeleteButton from 'Components/buttons/DeleteButton.vue';
import Modal from 'Components/PopupModal.vue';
import BulkPublishingErrorPopup from 'Components/BulkPublishingErrorPopup.vue';

// Vuex Store
import { useStore } from 'Store/activities/index';
import axios from 'axios';

interface RefreshToastMsgTypeface {
  visibility: boolean;
  refreshMessageType: boolean;
  refreshMessage: string;
}

interface ToastInterface {
  visibility: boolean;
  message: string;
  type: boolean;
}

const toastMessage = inject('toastData') as ToastInterface;
const errorData = inject('errorData') as ToastInterface;
const store = useStore();

const refreshToastMsg = inject('refreshToastMsg') as RefreshToastMsgTypeface;

const showCancelledPopup = ref(false);
const messageOnCancellation = ref('No bulk publish were cancelled');

/*Closes Cancel Confirmation Popup*/
const closeModal = () => {
  errorData.visibility = !errorData.visibility;
};

/*Cancels on-going bulk publish*/
const cancelOtherBulkPublish = () => {
  const endpoint = 'activities/cancel-bulk-publish';
  axios.get(endpoint).then((res) => {
    closeModal();
    setCancellationMessage(res.data.message);
    showCancelledDetailPopup();
  });
};

/*Show modal that shows number of bulk publish cancelled */
const showCancelledDetailPopup = () => {
  showCancelledPopup.value = true;
};

/*Sets message in modal triggered by showCancelledDetailPopup() */
const setCancellationMessage = (msg) => {
  messageOnCancellation.value = msg;
};
</script>
