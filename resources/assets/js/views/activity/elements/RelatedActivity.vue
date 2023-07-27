<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="related-content text-sm">
      <div class="category">
        <span v-if="post.relationship_type">{{
          types.relatedActivityType[post.relationship_type]
        }}</span>
        <span v-else class="italic">{{
          translate.missingText('element', 'common.type')
        }}</span>
      </div>
      <div>
        <span v-if="post.activity_identifier">{{
          post.activity_identifier
        }}</span>
        <span v-else class="italic">{{
          translate.missingText('element', 'common.reference')
        }}</span>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, inject } from 'vue';
import dateFormat from 'Composable/dateFormat';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  name: 'RelatedActivity',
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  setup() {
    interface Types {
      relatedActivityType: [];
      languages: [];
    }

    const types = inject('types') as Types;
    const translate = new Translate();

    return { types, dateFormat, translate };
  },
});
</script>
