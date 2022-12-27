<template>
  <div class="page-title mb-4">
    <div class="flex items-end gap-4">
      <div class="title shrink-0 grow-0">
        <div class="mb-2 text-caption-c1 text-n-40 xl:mb-4">
          <nav aria-label="breadcrumbs" class="breadcrumb">
            <p>
              <span class="last font-bold">{{ language.activities_lang.your_activities }}</span>
            </p>
          </nav>
        </div>
        <div class="inline-flex items-center">
          <h4 class="mr-4 text-3xl font-bold xl:text-heading-4">
            {{ language.activities_lang.your_activities }}
          </h4>
          <div class="tooltip-btn">
            <button class="">
              <svg-vue icon="question-mark" />
              <span>{{ language.activities_lang.what_is_activity.label }}</span>
            </button>
            <div class="tooltip-btn__content z-[1]">
              <div class="content">
                <div class="mb-1.5 text-caption-c1 font-bold text-bluecoral">
                  {{ language.activities_lang.what_is_activity.label }}
                </div>
                <p>
                  <span v-html="language.activities_lang.what_is_activity.description.one"></span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="actions relative flex grow flex-col items-end justify-end">
        <div class="inline-flex justify-end">
          <Toast
            v-if="toastMessage.visibility"
            class="mr-3.5"
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
          <div class="inline-flex shrink-0 items-center justify-end gap-3">
            <RefreshToastMessage
              v-if="refreshToastMsg.visibility"
              :message="refreshToastMsg.refreshMessage"
              :type="refreshToastMsg.refreshMessageType"
            />
            <PublishSelected />
            <DeleteButton v-if="store.state.selectedActivities.length === 1" />
            <AddActivityButton />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { inject } from 'vue';
import AddActivityButton from './AddActivityButton.vue';
import Toast from 'Components/ToastMessage.vue';
import RefreshToastMessage from 'Activity/bulk-publish/RefreshToast.vue';
import PublishSelected from 'Activity/bulk-publish/PublishSelected.vue';
import DeleteButton from 'Components/buttons/DeleteButton.vue';
import ErrorPopUp from 'Components/ErrorPopUp.vue';

// Vuex Store
import { useStore } from 'Store/activities/index';

interface RefreshToastMsgTypeface {
  visibility: boolean;
  refreshMessageType: boolean;
  refreshMessage: string;
}
const language = window["global_lang"];
const store = useStore();

interface ToastInterface {
  visibility: boolean;
  message: string;
  type: boolean;
}

const toastMessage = inject('toastData') as ToastInterface;
const errorData = inject('errorData') as ToastInterface;


const refreshToastMsg = inject('refreshToastMsg') as RefreshToastMsgTypeface;
</script>

