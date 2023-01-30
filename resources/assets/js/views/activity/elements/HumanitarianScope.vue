<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    class="elements-detail"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="category">
      <span v-if="post.type">
        {{ types.humanitarianScopeType[post.type] ?? 'Missing' }}
      </span>
      <span v-else>Vocabulary Missing</span>
    </div>
    <div class="ml-5">
      <table>
        <tbody>
          <tr>
            <td>Vocabulary</td>
            <td>
              {{
                types.humanitarianScopeVocabulary[post.vocabulary] ?? 'Missing'
              }}
            </td>
          </tr>
          <tr v-if="post.vocabulary === '99'">
            <td>Vocabulary URI</td>
            <td>
              <a
                v-if="post.vocabulary_uri"
                target="_blank"
                :href="post.vocabulary_uri"
              >
                {{ post.vocabulary_uri }}
              </a>
              <span v-else class="italic">Missing</span>
            </td>
          </tr>
          <tr>
            <td>Code</td>
            <td>
              {{ post.code ?? 'Missing' }}
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
                <div class="w-[500px] max-w-full">
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
  humanitarianScopeVocabulary: [];
  languages: [];
  humanitarianScopeType: [];
}

const types = inject('types') as Types;
</script>
