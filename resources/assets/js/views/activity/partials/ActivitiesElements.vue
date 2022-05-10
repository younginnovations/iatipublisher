<template>
  <div class="activities__card elements__panel">
    <div class="grid grid-flow-col">
      <div class="relative">
        <svg-vue
          class="panel__search absolute left-2.5 top-3 text-sm text-n-30"
          icon="panel-search"
        ></svg-vue>
        <input
          class="panel__input"
          type="text"
          v-model="elements.search"
          placeholder="Search elements to add/edit"
        />
      </div>
      <div class="relative grid justify-items-end">
        <button
          class="button panel-btn dropdown-btn"
          @click="searchBtnToggle()"
        >
          <svg-vue icon="core"></svg-vue>
          <svg-vue
            :class="
              searchBtnValue ? 'dropdown__arrow rotate-180' : 'dropdown__arrow'
            "
            icon="dropdown-arrow"
          ></svg-vue>
        </button>
        <div
          v-show="searchBtnValue"
          class="button__dropdown button panel-btn dropdown-btn absolute right-0 top-full z-10 bg-white p-2 text-left shadow-dropdown"
        >
          <ul>
            <li class="">
              <svg-vue icon="double-tick"></svg-vue>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="elements__listing mt-3 grid grid-cols-2 gap-2">
      <div
        v-for="post in filteredElements"
        class="elements__item flex cursor-pointer flex-col items-center justify-center rounded border border-dashed border-n-40 p-2.5 text-n-30"
      >
        <svg-vue :icon="post.icon" class="text-base"></svg-vue>
        <div class="title mt-1 text-xs">{{ post.name }}</div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { computed, defineComponent, reactive } from 'vue';
import { useToggle } from '@vueuse/core';

export default defineComponent({
  name: 'activities-elements',
  components: {},
  setup() {
    const [searchBtnValue, searchBtnToggle] = useToggle();

    const elements = reactive({
      search: '',
      items: [
        {
          name: 'iati-identifier',
          icon: 'align-center',
          completed: true,
          core: true,
        },
        {
          name: 'reporting-org',
          icon: 'building',
          completed: true,
          core: true,
        },
        {
          name: 'other-identifier',
          icon: 'align-right',
          completed: true,
          core: false,
        },
        {
          name: 'title',
          icon: 'note',
          completed: true,
          core: true,
        },
      ],
    });

    const filteredElements = computed(() => {
      return elements.items.filter((post) => {
        return post.name.toLowerCase().includes(elements.search.toLowerCase());
      });
    });

    return {
      searchBtnValue,
      searchBtnToggle,
      elements,
      filteredElements,
    };
  },
});
</script>

<style lang="scss">
.activities {
  .elements {
    border-radius: 0px 8px 8px 0px;
    width: 125px;
    height: 174px;
  }

  .elements__panel {
    @apply rounded-lg p-4 shadow-dropdown;
    height: 1232px;

    .panel__input:focus,
    .panel__search:focus {
      @apply text-n-40;
    }
  }

  .hover__text {
    @apply ml-1;
  }
}
</style>
