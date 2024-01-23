<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    class="elements-detail"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="category">
      <span v-if="post.type">
        <ConditionalTextDisplay
          :success-text="types.humanitarianScopeType[post.type]"
          :condition="types.humanitarianScopeType[post.type]"
        />
      </span>
      <span v-else> Type Missing </span>
    </div>
    <div class="ml-5">
      <table>
        <tbody>
          <tr>
            <td>Vocabulary</td>
            <td>
              <ConditionalTextDisplay
                :success-text="
                  types.humanitarianScopeVocabulary[post.vocabulary]
                "
                :condition="types.humanitarianScopeVocabulary[post.vocabulary]"
                failure-text="vocabulary"
              />
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
              <span v-else class="italic">
                <MissingDataItem item="vocabulary URI" />
              </span>
            </td>
          </tr>
          <tr>
            <td>Code</td>
            <td>
              <ConditionalTextDisplay
                :condition="post.code"
                :success-text="post.code"
                failure-text="code"
              />
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
                  <ConditionalTextDisplay
                    :condition="narrative.language"
                    :success-text="types.languages[narrative.language]"
                  />)
                </div>
                <div class="w-[500px] max-w-full">
                  <ConditionalTextDisplay
                    :condition="narrative.narrative"
                    :success-text="narrative.narrative"
                    failure-text="narrative"
                  />
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
import ConditionalTextDisplay from 'Components/ConditionalTextDisplay.vue';
import MissingDataItem from 'Components/MissingDataItem.vue';

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
