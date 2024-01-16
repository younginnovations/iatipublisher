<!-- eslint-disable -->
<template>
  <div class="page-title mb-4">
    <div class="flex gap-4 md:items-end">
      <div class="title shrink-0 grow-0">
        <div class="mb-2 text-caption-c1 text-n-40 xl:mb-4">
          <nav aria-label="breadcrumbs" class="breadcrumb">
            <p>
              <span class="last font-bold">{{
                translate.textFromKey('activities.your_activities')
              }}</span>
            </p>
          </nav>
        </div>
        <div class="inline-flex flex-col space-y-2 md:flex-row md:items-center">
          <h4 class="mr-4 text-3xl font-bold xl:text-heading-4">
            {{ translate.textFromKey('activities.your_activities') }}
          </h4>
          <div class="tooltip-btn">
            <button class="">
              <svg-vue icon="question-mark" />
              <span>{{
                translate.textFromKey('activities.what_is_an_activity.label')
              }}</span>
            </button>
            <div class="tooltip-btn__content z-[1]">
              <div class="content">
                <div class="mb-1.5 text-caption-c1 font-bold text-bluecoral">
                  {{
                    translate.textFromKey(
                      'activities.what_is_an_activity.label'
                    )
                  }}
                </div>
                <p
                  v-html="
                    translate.textFromKey(
                      'activities.what_is_an_activity.description.one'
                    )
                  "
                ></p>
                <p
                  v-html="
                    translate.textFromKey(
                      'activities.what_is_an_activity.description.two'
                    )
                  "
                ></p>
                <p
                  v-html="
                    translate.textFromKey(
                      'activities.what_is_an_activity.description.three'
                    )
                  "
                ></p>
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
          :title="translate.error('activity_could_not_be_published')"
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
import { inject } from 'vue';
import DownloadActivityButton from './DownloadActivityButton.vue';
import AddActivityButton from './AddActivityButton.vue';
import Toast from 'Components/ToastMessage.vue';
import RefreshToastMessage from 'Activity/bulk-publish/RefreshToast.vue';
import PublishSelected from 'Activity/bulk-publish/PublishSelected.vue';
import DeleteButton from 'Components/buttons/DeleteButton.vue';

// Vuex Store
import { useStore } from 'Store/activities/index';
import ErrorPopUp from 'Components/ErrorPopUp.vue';
import { Translate } from 'Composable/translationHelper';

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

const translate = new Translate();
const refreshToastMsg = inject('refreshToastMsg') as RefreshToastMsgTypeface;
const toastMessage = inject('toastData') as ToastInterface;
const errorData = inject('errorData') as ToastInterface;
const store = useStore();
</script>
