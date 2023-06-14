<template>
  <div
    v-for="(post, i) in tdData[0].narrative"
    :key="i"
    class="title-content"
    :class="{
      'mb-4': i !== Object.keys(tdData[0].narrative).length - 1,
    }"
  >
    <div class="language mb-1.5">
      ({{
        post.language
          ? `${language.common_lang.language}: ${type.languages[post.language]}`
          : language.common_lang.missing.element.replace(
              ':element',
              language.common_lang.language
            )
      }})
    </div>
    <div class="description text-sm">
      {{ post.narrative ?? language.common_lang.missing.narrative }}
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';

export default defineComponent({
  name: 'TransactionDescription',
  components: {},
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
  },
  setup(props) {
    /**
     * Typescript interface
     */
    interface NarrativeArray {
      [index: number]: { language: string; narrative: string };
    }

    interface Narratives {
      [index: number]: {
        narrative: NarrativeArray;
      };
    }

    const language = window['globalLang'];
    let { data } = toRefs(props);
    const tdData = data.value as Narratives;
    const type = inject('types');
    return { tdData, type, language };
  },
});
</script>
