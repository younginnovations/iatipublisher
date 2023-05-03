<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="related-content text-sm">
      <div class="category">
        <span v-if="!isEmpty(post.relationship_type)">{{
          types.relatedActivityType[post.relationship_type]
        }}</span>
        <span v-else class="italic">Type Missing</span>
      </div>
      <div>
        <span v-if="!isEmpty(post.activity_identifier)">{{
          post.activity_identifier
        }}</span>
        <span v-else class="italic">Reference Missing</span>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, inject } from 'vue';
import dateFormat from 'Composable/dateFormat';
import isEmpty from 'Composable/helper';

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
  methods: { isEmpty },
});
</script>
