<template>
  <div class="mb-4 page-title">
    <div class="flex items-end gap-4">
      <div class="title grow-0">
        <div class="mb-2 text-caption-c1 text-n-40 xl:mb-4">
          <nav aria-label="breadcrumbs" class="breadcrumb">
            <p>
              <span class="font-bold last">Your Activities</span>
            </p>
          </nav>
        </div>
        <div class="inline-flex items-center">
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
      <div class="relative flex flex-col items-end justify-end actions grow">
        <div class="inline-flex justify-end">
          <Toast
            v-if="toastMessage.visibility"
            class="mr-3.5"
            :message="toastMessage.message"
            :type="toastMessage.type"
          />
          <div class="inline-flex items-center justify-end gap-3">
            <RefreshToastMessage
              v-if="refreshToastMsg.visibility"
              :message="refreshMessage"
              :type="refreshMessageType"
              class="mr-5"
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

// Vuex Store
import { useStore } from 'Store/activities/index';

interface RefreshToastMsgTypeface {
  visibility: boolean;
}

const store = useStore();

const refreshMessageType = true,
  refreshMessage =
    'Activity has been published sucessfully, refresh to see changes';

interface ToastInterface {
  visibility: boolean;
  message: string;
  type: boolean;
}

const toastMessage = inject('toastData') as ToastInterface;

const refreshToastMsg = inject('refreshToastMsg') as RefreshToastMsgTypeface;
</script>
