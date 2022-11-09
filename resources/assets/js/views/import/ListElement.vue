<template>
  <td class="title">
    {{
      activity["data"]["title"][0]["narrative"]
        ? activity["data"]["title"][0]["narrative"]
        : "Not Available"
    }}

    <span
      v-if="activity['errors'].length > 0"
      class="inline-flex cursor-pointer items-center text-crimson-50"
      @click="toggleError"
    >
      Show {{ Object.keys(activity["errors"]).length }} errors
      <svg-vue
        icon="dropdown-arrow"
        class="ml-1 text-[4px]"
        :class="{ 'rotate-180': active, '': !active }"
      />
    </span>

    <div class="upload-error-content" :class="{ open: active }">
      <ul>
        <li v-for="(err, i) in activity['errors']" :key="i">
          <p>{{ err }}</p>
        </li>
      </ul>
    </div>
  </td>

  <td>
    <span class="text-sm leading-relaxed">{{
      !activity["existence"] ? "New" : "Existing"
    }}</span>
  </td>

  <td class="check-column" @click="(event: Event) => event.stopPropagation()">
    <label class="sr-only" for=""> Select </label>
    <label v-if="activity['errors'].length === 0" class="checkbox">
      <input
        v-model="activities"
        type="checkbox"
        :value="index"
        @click="selectElement(index)"
      />
      <span class="checkmark" />
    </label>
    <label v-else class="checkbox">
      <!-- <input type="checkbox" :value="index" /> -->
      <span class="checkmark" />
    </label>
  </td>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, ref, watch, reactive } from "vue";

const props = defineProps({
  activity: {
    type: Object,
    required: true,
  },
  index: {
    type: String,
    required: true,
  },
  selectedActivities: {
    type: String,
    required: true,
  },
});

const emit = defineEmits(["selectElement"]);

const active = ref(false);
let activities = reactive([]);
function toggleError() {
  active.value = !active.value;
}

const selectElement = (index) => {
  emit("selectElement", index);
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
