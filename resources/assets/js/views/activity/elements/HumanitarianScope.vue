<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    class="elements-detail"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="category">
      <span v-if="post.type">
        {{ types.humanitarianScopeType[post.type] ?? translate.missing() }}
      </span>
      <span v-else>
        {{ translate.missing('vocabulary') }}
      </span>
    </div>
    <div class="ml-5">
      <table>
        <tbody>
          <tr>
            <td>{{ translate.commonText('vocabulary') }}</td>
            <td>
              {{
                types.humanitarianScopeVocabulary[post.vocabulary] ??
                translate.missing()
              }}
              {{
                types.humanitarianScopeVocabulary[post.vocabulary] ??
                translate.missing()
              }}
            </td>
          </tr>
          <tr v-if="post.vocabulary === '99'">
            <td>{{ translate.commonText('vocabulary_uri') }}</td>
            <td>
              <a
                v-if="post.vocabulary_uri"
                target="_blank"
                :href="post.vocabulary_uri"
              >
                {{ post.vocabulary_uri }}
              </a>
              <span v-else class="italic">{{ translate.missing() }}</span>
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('code') }}</td>
            <td>
              {{ post.code ?? translate.missing() }}
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('narrative') }}</td>
            <td>
              <div
                v-for="(narrative, k) in post.narrative"
                :key="k"
                class="description-content"
                :class="{ 'mb-4': k !== post.narrative.length - 1 }"
              >
                <div class="language mb-1.5">
                  ({{ translate.commonText('language') }}:
                  {{
                    narrative.language
                      ? types.languages[narrative.language]
                      : translate.missing()
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{ narrative.narrative ?? translate.missing() }}
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
import { Translate } from 'Composable/translationHelper';

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

const translate = new Translate();
const types = inject('types') as Types;
</script>
