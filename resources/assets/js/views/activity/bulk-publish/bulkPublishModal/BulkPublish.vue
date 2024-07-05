<template>
  <div>
    <h4
      class="mb-4 flex items-center gap-1 border-b border-n-20 pb-2 text-sm font-bold"
    >
      <span> Publishing Activity </span>
      <span
        class="inline-block rounded-full bg-lagoon-10 px-2 py-1 text-xs font-[500] text-spring-50"
      >
        {{ selectedActivities && selectedActivities.length }}
      </span>
    </h4>
    <WizardIndex
      :completed-steps="store.state.bulkActivityPublishStatus.completedSteps"
    />
    <div v-if="store?.state?.startBulkPublish || showPublishingActivityModal">
      <PublishingActivity />
    </div>
    <div v-else>
      <div v-if="store.state.startValidation || showValidationPopup">
        <IatiValidate
          :validation-stats="
            store.state.bulkActivityPublishStatus.validationStats
          "
          :error-tab="store.state.bulkActivityPublishStatus.showValidationError"
          :activities-list="
            store.state.bulkActivityPublishStatus.importedActivitiesList
          "
          :permalink="permalink"
          :percentage-width="percentageWidth"
        />
      </div>
      <div v-else>
        <CheckingActivities
          v-if="!coreElementLoader"
          :deprecation-status-map="deprecationStatusMap"
          :core-in-completed-activities="coreInCompletedActivities"
          :permalink="permalink"
        />
        <RollingLoader v-else header="Checking your data before publication" />
      </div>
    </div>
  </div>
  <div class="flex justify-end gap-6 pt-2.5">
    <BtnComponent
      v-if="
        store.state.bulkActivityPublishStatus.publishing.response?.status ===
        'completed'
      "
      type="primary"
      text="Close"
      class="bg-white px-6 uppercase"
      @click="cancelPublishing()"
    />
    <template v-else>
      <BtnComponent
        class="space"
        type=""
        text="Cancel"
        @click="cancelPublishing()"
      />
      <button
        v-if="
          coreElementLoader ||
          store.state.bulkActivityPublishStatus.iatiValidatorLoader
        "
        className="flex items-center gap-1.5 font-bold text-bluecoral border border-bluecoral rounded px-2.5 py-3 text-xs uppercase"
        @click="handleMinimize()"
      >
        <span> Minimize screen </span>
        <svg-vue icon="open-link" class="rotate-90 text-[10px] text-n-40" />
      </button>
      <template v-if="percentageWidth !== 100">
        <template
          v-if="
            (props.coreInCompletedActivities.length > 0 ||
              props.coreCompletedActivities.length > 0) &&
            !coreElementLoader
          "
        >
          <BtnComponent
            v-if="
              !store.state.bulkActivityPublishStatus.iatiValidatorLoader &&
              !store?.state?.startBulkPublish
            "
            class="bg-white px-6 uppercase"
            type="primary"
            text="Continue publishing Anyway"
            @click="validateActivities()"
          />
        </template>
      </template>

      <template v-else>
        <template v-if="!store?.state?.startBulkPublish">
          <BtnComponent
            class="bg-white px-6 uppercase"
            type="primary"
            text="Start publishing"
            :disabled="newSelectedActivities.length === 0"
            @click="startBulkPublish()"
          />
        </template>
      </template>
    </template>
  </div>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, computed, watch, ref, provide } from 'vue';
import WizardIndex from '../wizardSteps/WizardIndex.vue';
import BtnComponent from 'Components/ButtonComponent.vue';
import CheckingActivities from './checkingActivities/CheckingActivities.vue';
import RollingLoader from './RollingLoaderComponent.vue';
import IatiValidate from './iatiValidate/IatiValidate.vue';
import { useStore } from 'Store/activities/index';
import PublishingActivity from './publishingActivity/PublishingActivity.vue';

const store = useStore();
const props = defineProps({
  coreInCompletedActivities: {
    type: Object,
    default: () => ({}),
  },
  coreCompletedActivities: {
    type: Object,
    default: () => ({}),
  },
  deprecationStatusMap: {
    type: Object,
    default: () => ({}),
  },
  permalink: {
    type: String,
    default: () => '',
  },
  coreElementLoader: {
    type: Boolean,
    required: true,
  },
  validationActivityLoader: {
    type: Boolean,
    required: true,
  },
  selectedActivities: {
    type: Array,
    required: true,
  },
  showValidationPopup: {
    type: Boolean,
    required: true,
  },
  publishingActivities: {
    type: Object,
    default: () => ({}),
  },
});
const newSelectedActivities = ref([] as number[]);
provide('newSelectedActivities', newSelectedActivities);

const emit = defineEmits([
  'resetPublishStep',
  'validateActivities',
  'startBulkPublish',
]);
const cancelPublishing = () => {
  emit('resetPublishStep');
};

const validateActivities = () => {
  emit('validateActivities');
};

const percentageWidth = computed(() => {
  return (
    (store.state.bulkActivityPublishStatus.validationStats.complete
      ? store.state.bulkActivityPublishStatus.validationStats.complete /
        store.state.bulkActivityPublishStatus.validationStats.total
      : 0) * 100
  );
});

watch(
  () => percentageWidth?.value,
  (value) => {
    localStorage.setItem('validationPercent', (value ?? 0).toString());
  }
);

const startBulkPublish = () => {
  store.dispatch('updateStartValidation', false);
  // localStorage.removeItem('validatingActivities');
  store.dispatch('updateStartBulkPublish', true);
  localStorage.removeItem('activityValidating');
  store.state.bulkActivityPublishStatus.completedSteps = [1];
};

const handleMinimize = () => {
  store.dispatch('updateMinimizeScreen', true);
};

const showPublishingActivityModal = computed(() => {
  return (
    props.publishingActivities &&
    Object.keys(props.publishingActivities).length > 0
  );
});
</script>

<style scoped></style>
