<template>
  <td class="title">
    {{ activity["data"]["title"][0]["narrative"] ?? "Not Available" }}

    <span
      v-if="activity['errors'].length > 0"
      class="text-crimson-50"
      @click="toggleError"
    >
      <span class="text-n-50">- </span>
      Show {{ Object.keys(activity["errors"]).length }} errors
      <!-- <svg-vue icon="dropdown-arrow" /> -->
      <!-- <span class="upload-error-icon" :class="{ open: active }"
        >
      </span> -->
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

  <td class="check-column">
    <label class="sr-only" for=""> Select </label>
    <label class="checkbox">
      <input type="checkbox" @click="selectElement()" />
      <span class="checkmark" />
    </label>
  </td>
</template>

<script lang="ts">
import { defineComponent, ref } from "@vue/runtime-core";

export default defineComponent({
  name: "ImportList",
  components: {},
  props: {
    activity: {
      type: Object,
      required: true,
    },
    index: {
      type: String,
      required: true,
    },
    selectAll: {
      type: String,
      required: false,
      default: "",
    },
  },
  emits: ["selectElement"],
  setup(props, { emit }) {
    const active = ref(false);

    function toggleError() {
      active.value = !active.value;
    }

    const selectElement = (index) => {
      emit("selectElement", index);
    };

    return {
      active,
      toggleError,
      selectElement,
    };
  },
});
</script>
