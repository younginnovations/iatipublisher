<template>
  <div v-for="(post, i) in data.content" :key="i" class="title-content">
    <div v-if="post.narrative" class="flex flex-col">
      <span v-if="post.language" class="language mb-1.5">
        ({{ translate.commonText('language') }}:
        {{ types.languages[post.language] }})
      </span>
      <span v-if="post.narrative" class="max-w-[887px] text-sm">
        {{ post.narrative }}
      </span>
    </div>
    <span v-else class="text-sm italic">{{
      translate.missing('element', 'common.title')
    }}</span>
    <div v-if="i !== data.content.length - 1" class="mb-4"></div>
  </div>
</template>

<script lang="ts">
import { defineComponent, inject } from 'vue';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  name: 'ActivityTitle',
  components: {},
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  setup() {
    interface Types {
      languages: [];
    }
    const translate = new Translate();
    const types = inject('types') as Types;
    return { types, translate };
  },
});
</script>
