<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    class="elements-detail"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="tb-title category">
      <span v-if="post.region_vocabulary">{{
        types.regionVocabulary[post.region_vocabulary]
      }}</span>
      <span v-else>Vocabulary Missing</span>
    </div>
    <div class="ml-5">
      <table>
        <tbody>
          <tr v-if="post.region_vocabulary == '1'">
            <td>Region Code</td>
            <td>
              <span v-if="post.region_code">{{
                types.region[post.region_code]
              }}</span>
              <span v-else>Missing</span>
            </td>
          </tr>
          <tr v-else>
            <td>Custom Code</td>
            <td>
              <span v-if="post.custom_code">{{ post.custom_code }}</span>
              <span v-else>Missing</span>
            </td>
          </tr>
          <tr>
            <td>Percentage</td>
            <td>
              <span v-if="post.percentage">
                ({{ roundFloat(post.percentage) }}%)
              </span>
              <span v-else>Missing</span>
            </td>
          </tr>
          <tr v-if="post.region_vocabulary == '99'">
            <td>Vocabulary-uri</td>
            <td>
              <a
                v-if="post.vocabulary_uri"
                target="_blank"
                :href="post.vocabulary_uri"
              >
                {{ post.vocabulary_uri }}
              </a>
              <span v-else>Missing</span>
            </td>
          </tr>
          <tr>
            <td>Narrative</td>
            <td>
              <div
                v-for="(narrative, k) in post.narrative"
                :key="k"
                class="description-content"
                :class="{ 'mb-4': k !== post.narrative.length - 1 }"
              >
                <div class="language mb-1.5">
                  (Language:
                  {{
                    narrative.language
                      ? types.languages[narrative.language]
                      : 'Missing'
                  }})
                </div>
                <div class="w-[500px] max-w-full text-xs">
                  {{ narrative.narrative ?? 'Missing' }}
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, inject } from 'vue';

defineProps({
  data: {
    type: Object,
    required: true,
  },
});

interface Types {
  regionVocabulary: [];
  region: [];
  languages: [];
}

const types = inject('types') as Types;

function roundFloat(num: string) {
  return parseFloat(num).toFixed(2);
}
</script>
