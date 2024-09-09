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

        <ErrorPopUp
          v-if="errorData.visibility"
          :message="errorData.message"
          title="Activity couldn’t be published because"
          @close-popup="
            () => {
              errorData.visibility = false;
            }
          "
        />
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
                <DownloadActivityButton />
                <BtnComponent
                  v-if="store.state.selectedActivities.length > 0"
                  type="secondary"
                  :text="`Publish Selected (${store.state.selectedActivities.length})`"
                  icon="approved-cloud"
                  @click="checkPublish"
                />
                <PublishSelected ref="publishRef" />
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
import { inject, ref, Ref } from 'vue';
import DownloadActivityButton from './DownloadActivityButton.vue';
import AddActivityButton from './AddActivityButton.vue';
import Toast from 'Components/ToastMessage.vue';
import RefreshToastMessage from 'Activity/bulk-publish/RefreshToast.vue';
import PublishSelected from 'Activity/bulk-publish/PublishSelected.vue';
import DeleteButton from 'Components/buttons/DeleteButton.vue';
import BtnComponent from 'Components/ButtonComponent.vue';
// Vuex Store
import { useStore } from 'Store/activities/index';
import ErrorPopUp from 'Components/ErrorPopUp.vue';

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

const refreshToastMsg = inject('refreshToastMsg') as RefreshToastMsgTypeface;
const toastMessage = inject('toastData') as ToastInterface;
const errorData = inject('errorData') as ToastInterface;
const store = useStore();
const publishRef: Ref<typeof PublishSelected | null> = ref(null);

const checkPublish = () => {
  if (publishRef.value) {
    publishRef.value.checkPublish();
  }
};
</script>
