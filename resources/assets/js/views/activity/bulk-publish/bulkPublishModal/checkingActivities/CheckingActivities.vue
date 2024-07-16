<template>
  <div class="flex items-start gap-1 pt-2.5 text-sm font-bold text-blue-50">
    <svg-vue class="text-xl" icon="warning-activity" />
    <p class="tracking-normal">
      The following activities have incomplete core elements or deprecated
      codes. We recommend checking these to ensure good data quality.
    </p>
  </div>
  <TabIndex
    :tabs="[
      {
        name: `Core Elements completeness check (${props.coreInCompletedActivities.length})`,
        value: 1,
      },
      {
        name: `Deprecated Code Check (${
          Object.keys(deprecationStatusMap).length
        })`,
        value: 2,
      },
    ]"
  >
    <template #tabOne>
      <div
        v-if="props.coreInCompletedActivities.length > 0"
        class="notCompleted max-h-[50vh] space-y-3 divide-y divide-n-20 overflow-auto"
      >
        <div
          v-for="(act, i) in props.coreInCompletedActivities"
          :key="i"
          class="item flex items-center justify-between pt-3"
        >
          <span>
            {{ act.title }}
          </span>
          <a :href="`${permalink}${act.activity_id}`" target="_blank" class="">
            <svg-vue class="text-sm" icon="open-link" />
          </a>
        </div>
      </div>
      <div
        v-if="
          props.coreInCompletedActivities.length === 0 &&
          props.coreCompletedActivities.length !== 0
        "
      >
        No activities found
      </div>
      <div
        v-if="
          props.coreInCompletedActivities.length === 0 &&
          props.coreCompletedActivities.length === 0
        "
      >
        Selected
        {{
          store.state.selectedActivities.length > 1
            ? 'activities are'
            : 'activity is'
        }}
        already published
      </div>
    </template>
    <template #tabTwo>
      <div>
        <div
          v-if="Object.keys(deprecationStatusMap).length > 0"
          class="max-h-[50vh] space-y-3 divide-y divide-n-20 overflow-auto leading-relaxed"
        >
          <div
            v-for="(act, i) in deprecationStatusMap"
            :key="i"
            class="item flex items-center justify-between pt-3"
          >
            <span>
              {{ act.title }}
            </span>
            <a
              :href="`${permalink}${act.activity_id}`"
              target="_blank"
              class=""
            >
              <svg-vue class="text-sm" icon="open-link" />
            </a>
          </div>
        </div>
        <div v-else class="py-2">No activities found</div>
      </div>
    </template>
  </TabIndex>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import TabIndex from '../../tabs/TabIndex.vue';
import { useStore } from 'Store/activities';

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
});
</script>

<style scoped></style>
