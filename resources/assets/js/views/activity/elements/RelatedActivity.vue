<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="text-sm related-content">
      <div class="category">
        <span v-if="post.relationship_type">{{
          types.relatedActivityType[post.relationship_type]
        }}</span>
        <span v-else class="italic">Type Not Available</span>
      </div>
      <div>
        <span v-if="post.activity_identifier">{{
          post.activity_identifier
        }}</span>
        <span v-else class="italic">Reference Not Available</span>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, inject } from 'vue';
import dateFormat from 'Composable/dateFormat';

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

    return { types, dateFormat };
  },
});
</script>
