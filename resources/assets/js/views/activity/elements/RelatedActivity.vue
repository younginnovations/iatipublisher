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
          language.common_lang.missing.element.replace(
            ':element',
            language.common_lang.type
          )
        }}</span>
      </div>
      <div>
        <span v-if="post.activity_identifier">{{
          post.activity_identifier
        }}</span>
        <span v-else class="italic">{{
          language.common_lang.missing.element.replace(
            ':element',
            language.common_lang.reference_label
          )
        }}</span>
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
    const language = window['globalLang'];

    return { types, dateFormat, language };
  },
});
</script>
