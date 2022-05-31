<template>
  <div>
    <div class="relative">
      <svg-vue
        class="absolute left-4 top-7 text-base text-n-40"
        icon="search"
      ></svg-vue>
      <input
        v-model="elements.search"
        class="element__search"
        placeholder="Search elements to add/edit"
        type="text"
      />
    </div>
    <div class="activities__card elements__panel">
      <div class="elements__listing grid grid-cols-2 gap-2">
        <a
          v-for="(post, index) in filteredElements"
          :key="index"
          class="elements__item relative flex cursor-pointer flex-col items-center justify-center rounded border border-dashed border-n-40 p-2.5 text-n-30"
          href="/1/title-form"
        >
          <div
            class="status_icons absolute right-0 top-0 mt-1 mr-1 inline-flex"
          >
            <svg-vue
              v-if="post.completed"
              class="text-base text-spring-50"
              icon="double-tick"
            ></svg-vue>
            <svg-vue
              v-if="post.core"
              class="text-base text-camel-50"
              icon="core"
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
          <div class="title mt-1 break-all text-xs">{{ index }}</div>
        </a>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { computed, defineComponent, reactive } from 'vue';

export default defineComponent({
  name: 'activities-elements',
  components: {},
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
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
          return key.toLowerCase().includes(elements.search.toLowerCase());
        } else {
          if (value[elements.status]) {
            console.log(elements.status);
            return key.toLowerCase().includes(elements.search.toLowerCase());
          }
        }
      });

      const justStrings = Object.fromEntries(filtered);
      return justStrings;
    });

    return {
      elements,
      filteredElements,
    };
  },
});
</script>
