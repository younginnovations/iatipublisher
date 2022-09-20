<template>
  <div class="activities__card elements__panel">
    <div class="grid grid-flow-col mb-3">
      <div class="relative">
        <svg-vue
          class="panel__search absolute left-2.5 top-3 text-sm text-n-30"
          icon="panel-search"
        ></svg-vue>
        <input
          v-model="elements.search"
          class="panel__input"
          placeholder="Search elements to add/edit"
          type="text"
        />
      </div>
      <div class="relative grid justify-items-end">
        <button
          ref="dropdownBtn"
          class="button panel-btn dropdown-btn"
          @click="searchBtnToggle()"
        >
          <svg-vue
            :icon="
              elements.status
                ? elements.status === 'completed'
                  ? 'double-tick'
                  : elements.status
                : 'box'
            "
            class="text-lg"
          ></svg-vue>
          <svg-vue
            class="w-2.5 text-xs transition duration-200 ease-linear"
            :class="{ 'rotate-180': searchBtnValue }"
            icon="dropdown-arrow"
          ></svg-vue>
        </button>
        <div
          v-show="searchBtnValue"
          ref="dropdown"
          class="button__dropdown button dropdown-btn absolute right-0 top-full z-10 w-[118px] bg-white text-left shadow-dropdown"
        >
          <ul class="w-full py-2 bg-eggshell">
            <li
              class="flex py-1.5 px-3.5 hover:bg-white"
              @click="dropdownFilter('')"
            >
              <svg-vue class="mr-1 text-lg" icon="box"></svg-vue>
              <span>All Elements</span>
            </li>
            <li
              class="flex py-1.5 px-3.5 hover:bg-white"
              @click="dropdownFilter('completed')"
            >
              <svg-vue class="mr-1 text-lg" icon="double-tick"></svg-vue>
              <span>Completed</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="grid grid-cols-2 gap-2 elements__listing">
      <a
        v-for="(post, index) in filteredElements"
        :key="index"
        class="elements__item relative flex cursor-pointer flex-col items-center justify-center rounded border border-dashed border-n-40 px-[3px] py-2.5 text-n-30"
        :href="post.has_data ? '#' + index : '/organisation/' + index"
      >
        <div class="absolute top-0 right-0 inline-flex mt-1 mr-1 status_icons">
          <svg-vue
            v-if="
              String(index) === 'organisation_identifier'
                ? status['identifier']
                : status[index]
            "
            class="text-base text-teal-50"
            icon="double-tick"
          ></svg-vue>
          <svg-vue
            v-if="orgMandatoryElements().includes(index.toString())"
            class="text-base text-camel-50"
            icon="star"
          ></svg-vue>
        </div>
        <template v-if="index === 'name'">
          <svg-vue
            class="text-base"
            icon="organisation-elements/building"
          ></svg-vue>
        </template>
        <template v-else>
          <svg-vue
            :icon="'organisation-elements/' + index"
            class="text-base"
          ></svg-vue>
        </template>
        <div class="mt-1 text-xs break-all title">
          {{ index.toString().replace(/_/g, '-') }}
        </div>
      </a>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, defineProps, reactive, onMounted, ref } from 'vue';
import { useToggle } from '@vueuse/core';
import { orgMandatoryElements } from 'Composable/coreElements';

const props = defineProps({
  data: {
    type: Object,
    required: true,
  },
  status: {
    type: Object,
    required: true,
  },
  completed: {
    type: Object,
    required: true,
  },
});

const [searchBtnValue, searchBtnToggle] = useToggle();
const dropdown = ref();
const dropdownBtn = ref();

/**
 * Search functionality
 */
const elements = reactive({
  search: '',
  status: '',
});

const asArrayData = Object.entries(props.data);
const filteredElements = computed(() => {
  const filtered = asArrayData.filter(([key, value]) => {
    if (!elements.status) {
      return key
        .toLowerCase()
        .includes(
          elements.search.toLowerCase().replace(/_/g, ' ').replace(/-/g, '_')
        );
    } else {
      if (value[elements.status]) {
        return key
          .toLowerCase()
          .includes(
            elements.search.toLowerCase().replace(/_/g, ' ').replace(/-/g, '_')
          );
      }
    }
  });

  const justStrings = Object.fromEntries(filtered);
  return justStrings;
});

onMounted(() => {
  window.addEventListener('click', (e) => {
    if (
      !dropdownBtn.value.contains(e.target) &&
      !dropdown.value.contains(e.target) &&
      searchBtnValue.value
    ) {
      searchBtnToggle();
    }
  });
});

const dropdownFilter = (s: string) => {
  elements.status = s;
  searchBtnToggle();
};
</script>
