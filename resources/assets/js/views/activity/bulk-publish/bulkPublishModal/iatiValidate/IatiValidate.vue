<template>
  <div
    v-if="
      percentageWidth !== 100 &&
      store.state.bulkActivityPublishStatus.iatiValidatorLoader
    "
  >
    <RollingLoader header="Checking your data before publication" />
    <p
      class="mt-2.5 rounded-lg bg-paper p-4 text-sm leading-[22px] tracking-normal text-n-50"
    >
      This process may take some time. You can minimize this tab and continue
      working on other tasks.
    </p>
  </div>

  <div v-else class="relative pt-2.5">
    <div v-if="hasError">
      <div class="flex items-center gap-1">
        <svg-vue class="text-xl text-crimson-50" icon="warninig-activity-red" />
        <h3 class="text-sm font-bold uppercase text-bluecoral">
          Validation incomplete
        </h3>
      </div>
      <h6 v-if="errorType === 'generic'" class="my-2 text-sm">
        <b class="text-[18px]"
          >{{ Object.keys(validActivities).length }}/{{
            Object.keys(activitiesList).length
          }}</b
        >
        activities could only be validated due to server error. Would you like
        to publish the validated files?
      </h6>

      <h6 v-if="errorType === 'max_merge_size_exception'" class="my-2 text-sm">
        <b class="text-[16px] text-crimson-50">
          Exceeded max publish size.
          <a
            class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise hover:text-bluecoral"
            href="mailto:support@iatistandard.org"
            target="_blank"
          >
            Contact Support.
          </a>
        </b>
      </h6>
    </div>
    <div v-else>
      <h6 class="text-sm font-bold text-bluecoral">
        Data checking complete. Click continue to publish
      </h6>
    </div>
    <KeepAlive>
      <TabIndex
        v-if="hasError && percentageWidth === 100"
        :tabs="[
          {
            name: `Ready to publish (${Object.keys(validActivities).length})`,
            value: 1,
          },
          {
            name: `Not ready to publish (${
              Object.keys(inValidedActivities).length
            })`,
            value: 2,
          },
        ]"
        :show-bottom-banner="hasError && true"
        @active-tab="handleActiveTab"
      >
        <template #tabOne>
          <ul
            class="max-h-[50vh] space-y-2 divide-y divide-n-20 overflow-auto pb-4 duration-200"
          >
            <template v-if="Object.keys(validActivities).length > 0">
              <li
                v-for="(value, key) in validActivities"
                :key="Number(key)"
                class="pt-4 text-sm leading-[22px] tracking-normal text-n-50"
              >
                <div class="flex items-center justify-between">
                  <div>
                    <label class="checkbox_container">
                      <input
                        v-model="newSelectedActivities"
                        type="checkbox"
                        :value="key"
                      />
                      <span class="checkmark"></span>
                    </label>
                    <div class="pl-6">
                      {{ value.title ?? '' }}
                    </div>
                  </div>
                  <div class="flex items-center gap-6">
                    <svg-vue
                      v-if="value?.is_valid === false"
                      class="text-xl"
                      icon="warning-activity"
                    />
                    <a :href="`${permalink}${key}`" target="_blank" class="">
                      <svg-vue class="text-sm" icon="open-link" />
                    </a>
                  </div>
                </div>
              </li>
            </template>
            <template v-else>
              <li class="pt-4 text-sm leading-[22px] tracking-normal text-n-50">
                No activities are ready to publish
              </li>
            </template>
          </ul>
        </template>

        <template #tabTwo>
          <ul
            class="max-h-[50vh] space-y-2 divide-y divide-n-20 overflow-auto pb-4 duration-200"
          >
            <template v-if="Object.keys(inValidedActivities).length > 0">
              <li
                v-for="(value, key) in inValidedActivities"
                :key="key"
                class="pt-4 text-sm leading-[22px] tracking-normal text-n-50"
              >
                <div class="flex items-center justify-between">
                  <div>
                    <div>
                      {{ value.title ?? '' }}
                    </div>
                  </div>
                  <div class="flex items-center gap-6">
                    <svg-vue
                      v-if="value?.is_valid === false"
                      class="text-xl"
                      icon="warning-activity"
                    />
                    <a :href="`${permalink}${key}`" target="_blank" class="">
                      <svg-vue class="text-sm" icon="open-link" />
                    </a>
                  </div>
                </div>
              </li>
            </template>
            <template v-else>
              <li class="pt-4 text-sm leading-[22px] tracking-normal text-n-50">
                No activities are ready to publish
              </li>
            </template>
          </ul>
        </template>
      </TabIndex>
      <div v-else class="mt-2 rounded-md border border-n-20">
        <div
          class="flex items-center gap-1.5 rounded-t-lg bg-n-10 px-6 py-[14px] uppercase text-n-50"
        >
          <svg-vue class="text-xl" icon="warning-activity" />
          <span class="text-xs font-bold">
            There may be data quality issues with
            {{ totalValidationFailedActivities }}/{{
              store.state.bulkActivityPublishStatus.validationStats.total
            }}
            activities. You can still continue to publish
          </span>
        </div>
        <ul
          class="max-h-[50vh] space-y-2 divide-y divide-n-20 overflow-auto px-4 pb-4 duration-200"
        >
          <template v-if="Object.keys(validActivities).length > 0">
            <li
              v-for="(value, key) in validActivities"
              :key="Number(key)"
              class="pt-4 text-sm leading-[22px] tracking-normal text-n-50"
            >
              <div class="flex items-center justify-between">
                <div>
                  <label class="checkbox_container">
                    <input
                      v-model="newSelectedActivities"
                      type="checkbox"
                      :value="key"
                    />
                    <span class="checkmark"></span>
                  </label>
                  <div class="pl-6">
                    {{ value.title ?? '' }}
                  </div>
                </div>
                <div class="flex items-center gap-6">
                  <svg-vue
                    v-if="value?.is_valid === false"
                    class="text-xl"
                    icon="warning-activity"
                  />
                  <a :href="`${permalink}${key}`" target="_blank" class="">
                    <svg-vue class="text-sm" icon="open-link" />
                  </a>
                </div>
              </div>
            </li>
          </template>
          <template v-else>
            <li class="pt-4 text-sm leading-[22px] tracking-normal text-n-50">
              No activities are ready to publish
            </li>
          </template>
        </ul>
      </div>
    </KeepAlive>
    <div
      v-if="activeTab === 1 && Object.keys(validActivities).length > 0"
      class="w-[100px] pt-3"
    >
      <label for="selectAll" class="checkbox_container !flex">
        <span
          class="inline-block pl-3 pt-1 text-xs font-bold uppercase leading-[18px]"
          >Select all</span
        >
        <input
          id="selectAll"
          type="checkbox"
          :checked="
            newSelectedActivities.length === Object.keys(validActivities).length
          "
          @change="(e) => selectAllActivities(e)"
        />
        <span class="checkmark"></span>
      </label>
    </div>
  </div>
</template>
<script setup lang="ts">
import { watch, defineProps, ref, onMounted, inject, Ref, computed } from 'vue';

import { useStore } from 'Store/activities/index';
import RollingLoader from '../RollingLoaderComponent.vue';
import TabIndex from '../../tabs/TabIndex.vue';

const store = useStore();
const props = defineProps({
  validationStats: {
    type: Object,
    required: true,
  },

  activitiesList: {
    type: Object,
    required: false,
    default: () => ({}),
  },
  permalink: {
    type: String,
    required: true,
  },
  percentageWidth: {
    type: Number,
    required: true,
  },
  errorType: {
    type: String,
    required: true,
  },
});

const newSelectedActivities = inject('newSelectedActivities') as Ref<number[]>;
const activeTab = ref(1);
const handleActiveTab = (value) => {
  activeTab.value = value;
};

//setting data from local storage to vuex ,to preserve state when window is reloaded
onMounted(() => {
  //to check if validation need to be show of not when navigated or refreshed
  let showPopup = Boolean(localStorage.getItem('activityValidating'));
  if (showPopup) {
    store.dispatch('updateStartValidation', true);
  }
});

const hasError = computed(() => {
  return store.state.bulkActivityPublishStatus.showValidationError;
});

const selectAllActivities = (event) => {
  if (event.target.checked) {
    newSelectedActivities.value = Object.keys(validActivities.value).map(
      (key) => parseInt(key)
    );
  } else {
    newSelectedActivities.value = [];
  }
};

watch(
  () => newSelectedActivities.value,
  (value) => {
    if (
      store.state.bulkActivityPublishStatus.validationStats.total ==
      store.state.bulkActivityPublishStatus.validationStats.complete +
        store.state.bulkActivityPublishStatus.validationStats.failed
    ) {
      store.dispatch('updateValidatingActivities', value.join(','));
    }
  },
  { deep: true }
);

const validActivities = computed(() => {
  return Object.fromEntries(
    Object.entries(props.activitiesList).filter(
      ([key, value]) => value.status !== 'failed'
    )
  );
});
const inValidedActivities = computed(() => {
  return Object.fromEntries(
    Object.entries(props.activitiesList).filter(
      ([key, value]) => value.status == 'failed'
    )
  );
});

const totalValidationFailedActivities = computed(() => {
  return Object.values(props.activitiesList).filter((item) => !item.is_valid)
    .length;
});

watch(
  () =>
    Object.fromEntries(
      Object.entries(props.activitiesList).filter(
        ([key, value]) => value.status !== 'failed'
      )
    ),
  (value) => {
    const ids = Object.keys(value);
    newSelectedActivities.value = ids.map((key) => parseInt(key));
  },
  {
    deep: true,
    immediate: true,
  }
);
</script>

<style scoped lang="scss">
.checkbox_container {
  display: block;
  position: relative;
  padding-left: 10px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.checkbox_container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 3px;
  left: 0;
  height: 17px;
  width: 17px;
  border-radius: 2px;
  @apply border-2 border-n-20;
}

/* On mouse-over, add a grey background color */
.checkbox_container:hover input ~ .checkmark {
  @apply border-spring-50;
}

/* When the checkbox is checked, add a blue background */
.checkbox_container input:checked ~ .checkmark {
  @apply border-spring-50 bg-spring-50;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: '';
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.checkbox_container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.checkbox_container .checkmark:after {
  left: 4px;
  top: 1px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 2px 2px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>
