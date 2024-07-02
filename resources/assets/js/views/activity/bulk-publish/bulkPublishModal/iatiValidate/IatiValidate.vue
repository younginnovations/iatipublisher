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
  <div v-else class="relative">
    <h6 class="mb-2 font-bold text-bluecoral">
      Data checking complete. Click continue to publish
    </h6>
    <div class="relative rounded-lg border border-n-20 bg-white">
      <div v-if="!hasError">
        <div
          class="flex items-center gap-1.5 rounded-t-lg bg-n-10 px-6 py-[14px] uppercase text-n-50"
        >
          <svg-vue class="text-xl" icon="warning-activity" />
          <span class="text-xs font-bold">
            There may be data quality issues with 24/90 activities. You can
            still continue to publish
          </span>
        </div>
        <ul class="space-y-2 divide-y divide-n-20 px-6 pb-4 duration-200">
          <li
            v-for="(value, key) in activitiesList"
            :key="key"
            class="pt-4 text-sm leading-[22px] tracking-normal text-n-50"
          >
            <div class="flex items-center justify-between">
              <div>
                <label class="checkbox_container">
                  <input
                    v-model="store.state.selectedActivities"
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
                  v-if="value.status === 'failed'"
                  class="text-xl"
                  icon="warning-activity"
                />
                <a :href="`${permalink}${key}`" target="_blank" class="">
                  <svg-vue class="text-sm" icon="open-link" />
                </a>
              </div>
            </div>
          </li>
        </ul>
      </div>
      <div v-else>
        <span class="text-sm text-[#E34D5B]">Validation failed</span>
      </div>
    </div>
    <!-- <div class="pt-3">
      <label for="selectAll" class="checkbox_container !flex">
        <span
          class="inline-block pl-3 pt-1 text-xs font-bold uppercase leading-[18px]"
          >Select all</span
        >
        <input type="checkbox" id="selectAll" @change="selectAllActivities" :checked="areAllSelected"  />
        <span class="checkmark"></span>
      </label>
    </div> -->
  </div>
</template>
<script setup lang="ts">
import { watch, defineProps, computed, ref, onMounted, defineEmits } from 'vue';
import { useStore } from 'Store/activities/index';
import axios from 'axios';
import RollingLoader from '../RollingLoaderComponent.vue';

const store = useStore();
const props = defineProps({
  validationStats: {
    type: Object,
    required: true,
  },

  errorTab: {
    type: Boolean,
    required: true,
    default: false,
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
});

const emit = defineEmits(['stopValidation', 'proceed']);

const hasError = ref(false);

//setting data from local storage to vuex ,to preserve state when window is reloaded
onMounted(() => {
  //to check if validation need to be show of not when navigated or refreshed
  let showPopup = Boolean(localStorage.getItem('activityValidating'));
  if (showPopup) {
    store.dispatch('updateStartValidation', true);
  }

  let activitiesIds = localStorage.getItem('validatingActivities');
  if (activitiesIds) {
    store.dispatch('updateValidatingActivities', activitiesIds);
  }
});

watch(
  () => props.errorTab,
  (value) => {
    hasError.value = value;
  }
);

const stopValidating = () => {
  emit('stopValidation');
  axios.get(`/activities/delete-validation-status`).then(() => {
    store.dispatch('updateStartValidation', false);
    store.dispatch('updateValidatingActivities', '');
    localStorage.removeItem('validatingActivities');
    localStorage.removeItem('activityValidating');
  });
};

// const selectAllActivities = (event) => {
//   if (event.target.checked) {
//     store.dispatch('updateSelectedActivities', props.validationNames);
//   } else {
//     store.dispatch('updateSelectedActivities', []);
//   }
// };
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
