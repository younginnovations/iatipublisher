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
      <span v-else>{{
        language.common_lang.missing.element.replace(
          ':element',
          language.common_lang.vocabulary
        )
      }}</span>
    </div>
    <div class="ml-5">
      <table>
        <tbody>
          <tr>
            <td>{{ language.common_lang.vocabulary }}</td>
            <td>
              {{
                types.humanitarianScopeVocabulary[post.vocabulary] ??
                language.common_lang.missing.default
              }}
              {{
                types.humanitarianScopeVocabulary[post.vocabulary] ?? 'Missing'
              }}
            </td>
          </tr>
          <tr v-if="post.vocabulary === '99'">
            <td>{{ language.common_lang.vocabulary_uri }}</td>
            <td>
              <a
                v-if="post.vocabulary_uri"
                target="_blank"
                :href="post.vocabulary_uri"
              >
                {{ post.vocabulary_uri }}
              </a>
              <span v-else class="italic">{{
                language.common_lang.missing.default
              }}</span>
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.code }}</td>
            <td>
              {{ post.code ?? language.common_lang.missing.default }}
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.narrative }}</td>
            <td>
              <div
                v-for="(narrative, k) in post.narrative"
                :key="k"
                class="description-content"
                :class="{ 'mb-4': k !== post.narrative.length - 1 }"
              >
                <div class="language mb-1.5">
                  ({{ language.common_lang.language }}:
                  {{
                    narrative.language
                      ? types.languages[narrative.language]
                      : language.common_lang.missing.default
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{
                    narrative.narrative ?? language.common_lang.missing.default
                  }}
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

const language = window['globalLang'];
const types = inject('types') as Types;
</script>
