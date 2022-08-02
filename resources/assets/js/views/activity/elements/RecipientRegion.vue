<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="category">
      <span v-if="post.region_vocabulary">{{
        types.regionVocabulary[post.region_vocabulary]
      }}</span>
      <span v-else class="italic">Vocabulary Not Available</span>
    </div>
    <div class="flex space-x-1 text-sm">
      <div v-if="post.region_vocabulary === '1'">
        <span v-if="post.region_code">{{
          types.region[post.region_code]
        }}</span>
        <span v-else class="italic">Not Available</span>
      </div>
      <div v-else>
        <span v-if="post.custom_code">{{ post.custom_code }}</span>
        <span v-else class="italic">Not Available</span>
      </div>
      <span v-if="post.percentage">({{ roundFloat(post.percentage) }}%)</span>
    </div>
    <div class="ml-5 elements-detail">
      <table>
        <tr>
          <td v-if="post.region_vocabulary === '99'">Vocabulary-uri</td>
          <td v-if="post.region_vocabulary === '99'">
            <a
              v-if="post.vocabulary_uri"
              target="_blank"
              :href="post.vocabulary_uri"
              >{{ post.vocabulary_uri }}</a
            >
            <span v-else class="italic">Not Available</span>
          </td>
        </tr>
      </table>
    </div>
    <div
      v-for="(narrative, k) in post.narrative"
      :key="k"
      class="ml-5 item elements-detail"
      :class="{ 'mb-4': k !== post.narrative.length - 1 }"
    >
      <table class="flex flex-col">
        <tr class="multiline">
          <td>Narrative</td>
          <td>
            <div v-if="narrative.narrative" class="flex flex-col">
              <span v-if="narrative.language" class="language">
                (Language: {{ types.languages[narrative.language] }})
              </span>
              <span v-if="narrative.narrative" class="description">
                {{ narrative.narrative }}
              </span>
            </div>
            <span v-else class="italic">Not Available</span>
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, inject } from 'vue';

export default defineComponent({
  name: 'ActivityRecipientRegion',
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  setup() {
    interface Types {
      regionVocabulary: [];
      region: [];
      languages: [];
    }

    const types = inject('types') as Types;

    function roundFloat(num: string) {
      return parseFloat(num).toFixed(2);
    }

    return { types, roundFloat };
  },
});
</script>
