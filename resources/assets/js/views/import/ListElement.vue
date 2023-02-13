<template>
  <td class="title">
    <span class="flex">
      <span class="font-normal">{{
        activity['data']['title'][0]['narrative']
          ? activity['data']['title'][0]['narrative']
          : 'Missing'
      }}</span>

      <span
        v-if="Object.keys(activity['errors']).length > 0"
        class="mb-4 ml-4 inline-flex cursor-pointer items-center text-sm font-medium text-crimson-50"
        @click="toggleError"
      >
        <span class="flex items-center space-x-2">
          <svg-vue class="text-crimson-40" icon="alert" />
          <span> Show {{ countErrors() }} Issues</span>
        </span>

        <svg-vue
          icon="dropdown-arrow"
          class="ml-1 text-[4px] duration-200"
          :class="{ 'rotate-180': active, '': !active }"
        /> </span
    ></span>

    <div
      :style="`width: ${width - 40}px;`"
      class="upload-error-content duration-200"
      :class="{ closed: !active }"
    >
      <div class="py-4">
        <div
          v-if="Object.keys(activity['errors']).indexOf('critical') !== -1"
          class="critical-container mt-2 cursor-pointer"
          :style="`width: ${width - 40}px;`"
          @click="
            () => {
              showCritical = !showCritical;
            }
          "
        >
          <div class="flex items-center justify-between border border-none p-3">
            <span class="flex items-center space-x-2">
              <svg-vue class="text-crimson-40" icon="alert" />
              <span> Critical errors</span>
            </span>
            <svg-vue
              icon="dropdown-arrow"
              class="ml-1 cursor-pointer text-[4px] duration-200"
              :class="{ 'rotate-180': showCritical, '': !showCritical }"
              @click="
                () => {
                  showCritical = !showCritical;
                }
              "
            />
          </div>
          <div class="error-dropdown" :class="showCritical ? '' : 'hide-error'">
            <div
              v-for="(ele_err, i) in activity['errors']['critical']"
              :key="i"
              class="p-4"
            >
              <p class="mb-2 font-semibold capitalize">
                {{ i }}
              </p>

              <p
                v-for="item in Object.keys(ele_err)"
                :key="(item as string)"
                class="error-list text-sm font-medium"
              >
                {{ item.toString().replace(/_/g, ' ').replace(/\./g, ' > ') }}
                ( {{ ele_err[item] }} )
              </p>
            </div>
          </div>
        </div>
        <div
          v-if="Object.keys(activity['errors']).indexOf('error') !== -1"
          class="error-container mt-2 cursor-pointer"
          :style="`width: ${width - 40}px;`"
          @click="
            () => {
              showError = !showError;
            }
          "
        >
          <div
            class="flex items-center justify-between border border-none bg-rose p-3"
          >
            <span class="flex items-center space-x-2">
              <svg-vue class="text-crimson-40" icon="alert" />
              <span> Errors</span>
            </span>
            <svg-vue
              icon="dropdown-arrow"
              class="ml-1 cursor-pointer text-[4px] duration-200"
              :class="{ 'rotate-180': showError, '': !showError }"
              @click="
                () => {
                  showError = !showError;
                }
              "
            />
          </div>
          <div class="error-dropdown" :class="showError ? '' : 'hide-error'">
            <div
              v-for="(ele_err, i) in activity['errors']['error']"
              :key="i"
              class="bg-rose p-4"
            >
              <p class="mb-2 font-semibold capitalize">
                {{ i }}
              </p>

              <p
                v-for="item in Object.keys(ele_err)"
                :key="(item as string)"
                class="error-list text-sm font-medium"
              >
                {{ item.toString().replace(/_/g, ' ').replace(/\./g, ' > ') }}
                ( {{ ele_err[item] }} )
              </p>
            </div>
          </div>
        </div>
        <div
          v-if="Object.keys(activity['errors']).indexOf('warning') !== -1"
          class="warning-container my-2 cursor-pointer border-none"
          :style="`width: ${width - 40}px;`"
          @click="
            () => {
              showWarning = !showWarning;
            }
          "
        >
          <div class="flex items-center justify-between bg-eggshell p-3">
            <span class="flex items-center space-x-2">
              <svg-vue icon="alert" class="text-camel-40" /><span
                >Warnings</span
              >
            </span>
            <svg-vue
              icon="dropdown-arrow"
              class="ml-1 cursor-pointer text-[4px] duration-200"
              :class="{ 'rotate-180': showWarning, '': !showWarning }"
              @click="
                () => {
                  showWarning = !showWarning;
                }
              "
            />
          </div>
          <div :class="showWarning ? '' : 'hide-error'" class="error-dropdown">
            <div
              v-for="(ele_err, i) in activity['errors']['warning']"
              :key="i"
              class="bg-eggshell p-4"
            >
              <p class="mb-2 font-semibold capitalize">
                {{ i }}
              </p>

              <p
                v-for="item in Object.keys(ele_err)"
                :key="(item as string)"
                class="error-list text-sm font-medium"
              >
                {{ item.toString().replace(/_/g, ' ').replace(/\./g, ' > ') }}
                ( {{ ele_err[item] }} )
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- <div v-for="(ele_err, i) in activity['errors']" :key="i">
        <ul>
          <li v-for="(err, key, j) in ele_err" :key="j">
            <p class="mb-2 font-semibold capitalize">
              {{ key.toString().replace(/_/g, ' ').replace(/\./g, ' > ') }}
            </p>
            <p
              v-for="item in Object.values(err)"
              :key="(item as string)"
              class="error-list"
            >
              {{ item }}
            </p>
          </li>
        </ul>
      </div> -->
    </div>
  </td>

  <td>
    <span class="text-sm leading-relaxed">{{
      !activity['existence'] ? 'New' : 'Existing'
    }}</span>
  </td>

  <td class="check-column" @click="(event: Event) => event.stopPropagation()">
    <label class="sr-only" for=""> Select </label>
    <label
      v-if="Object.keys(activity['errors']).indexOf('critical') === -1"
      class="checkbox"
    >
      <input
        v-model="activities"
        type="checkbox"
        :value="index"
        @click="selectElement(index)"
      />
      <span class="checkmark" />
    </label>
    <label v-else class="checkbox">
      <span class="checkmark" />
    </label>
  </td>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, ref, watch, reactive } from 'vue';

const props = defineProps({
  activity: {
    type: Object,
    required: true,
  },
  index: {
    type: String,
    required: true,
  },
  width: { type: Number, required: false, default: 0 },
  selectedActivities: {
    type: String,
    required: true,
  },
});

const emit = defineEmits(['selectElement']);

const active = ref(false);
const showCritical = ref(false);
const showError = ref(false);
const showWarning = ref(false);
let activities = reactive([]);
function toggleError() {
  active.value = !active.value;
}

const selectElement = (index) => {
  emit('selectElement', index);
};

const countErrors = () => {
  let count = 0;

  for (const type in props.activity['errors']) {
    for (const index in props.activity['errors'][type]) {
      count += Object.keys(props.activity['errors'][type][index]).length;
    }
  }

  return count;
};

watch(
  () => props.selectedActivities,
  () => {
    let selectedData = JSON.parse(props.selectedActivities);
    if (selectedData.length) {
      Object.assign(activities, selectedData);
    } else {
      activities.length = 0;
    }
  }
);
</script>
<style scoped>
.error-dropdown {
  overflow: hidden;
  transition: max-height 0.3s ease-out;
  height: auto;
  max-height: 600px;
}

.error-dropdown.hide-error {
  max-height: 0;
}

.critical-container {
  position: relative;
  background-color: #f6f0ff;
  z-index: 100;
}

.critical-container::after {
  position: absolute;
  content: ' ';
  z-index: 10;
  background-color: #a66ee9;
  height: 100%;
  width: 2px;
  left: 0;
  top: 0;
}

.warning-container {
  position: relative;
  z-index: 100;
}
.error-container::after {
  position: absolute;
  content: ' ';
  z-index: 10;
  @apply bg-crimson-40;
  height: 100%;
  width: 2px;
  left: 0;
  top: 0;
}
.error-container {
  position: relative;
  z-index: 100;

  @apply bg-rose;
}
.warning-container::after {
  position: absolute;
  content: ' ';
  z-index: 10;
  @apply bg-camel-40;
  height: 100%;
  width: 2px;
  left: 0;
  top: 0;
}
</style>
