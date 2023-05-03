<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="description-type mb-2 text-sm font-bold">
      <span v-if="!isEmpty(post.type)">
        {{ types.descriptionType[post.type] }}
      </span>
      <span v-else class="italic">Type Missing</span>
    </div>
    <div
      v-for="(item, i) in post.narrative"
      :key="i"
      :class="{ 'mb-4': i !== post.narrative.length - 1 }"
      class="description-content text-sm"
    >
      <div v-if="!isEmpty(item.narrative)" class="flex flex-col">
        <span v-if="item.language" class="language mb-1.5">
          (Language: {{ types.languages[item.language] }})
        </span>
        <span v-if="item.narrative" class="max-w-[887px]">
          {{ item.narrative }}
        </span>
      </div>
      <span v-else class="italic">Narrative Missing</span>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, inject } from 'vue';
import isEmpty from 'Composable/helper';

export default defineComponent({
  name: 'ActivityDescription',
  components: {},
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  setup() {
    interface Types {
      descriptionType: [];
      languages: [];
    }
    const types = inject('types') as Types;
    return { types };
  },
  methods: { isEmpty },
});
</script>
