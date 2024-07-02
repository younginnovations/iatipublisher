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
    <div v-if="store?.state?.startBulkPublish">
      <PublishingActivity />
    </div>
    <div v-else>
      <div v-if="store.state.startValidation">
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
      class="space"
      type=""
      text="Go Back"
      @click="resetPublishStep()"
    />

    <template v-if="percentageWidth !== 100">
      <BtnComponent
        v-if="
          props.coreInCompletedActivities.length > 0 ||
          props.coreCompletedActivities.length > 0
        "
        class="bg-white px-6 uppercase"
        type="primary"
        text="Continue publishing Anyway"
        @click="validateActivities()"
      />
    </template>

    <template v-else>
      <BtnComponent
        class="bg-white px-6 uppercase"
        type="primary"
        text="Start publishing"
        :disabled="newSelectedActivities.length === 0"
        @click="startBulkPublish()"
      />
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
});
const newSelectedActivities = ref([] as number[]);
provide('newSelectedActivities', newSelectedActivities);

const emit = defineEmits([
  'resetPublishStep',
  'validateActivities',
  'startBulkPublish',
]);
const resetPublishStep = () => {
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
};
</script>

<style scoped></style>
