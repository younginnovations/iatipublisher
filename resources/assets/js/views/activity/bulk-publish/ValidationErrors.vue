<template>
  <div
    v-if="data.critical.length > 0"
    class="mb-6 text-sm leading-relaxed text-n-50"
  >
    <div class="title mb-6 flex">
      <svg-vue
        icon="warning"
        class="mr-1 mt-0.5 shrink-0 text-lg text-crimson-40"
      />
      <div>
        <b
          >{{ language.common_lang.critical_error_found }}
          {{ data.critical.length }}
          {{ language.common_lang.activities_nocase }}.</b
        >
        {{ criticalMessage }}
      </div>
    </div>
    <div class="rounded-lg bg-rose px-6">
      <div class="critical-errors">
        <ErrorItem :data="data.critical" :message="criticalMessage" />
      </div>
    </div>
  </div>

  <div
    v-if="data.errors.length > 0"
    class="mb-6 text-sm leading-relaxed text-n-50"
  >
    <div class="title mb-6 flex">
      <svg-vue
        icon="warning-fill"
        class="mr-1 mt-0.5 shrink-0 text-lg text-camel-40"
      />
      <div>
        <b
          >{{ language.common_lang.errors_and_warnings_found }}
          {{ data.errors.length }}
          {{ language.common_lang.activities_nocase }}.</b
        >
        {{ warningMessage }}
      </div>
    </div>
    <div class="rounded-lg bg-eggshell px-6">
      <div class="warning-errors">
        <ErrorItem :data="data.errors" :message="warningMessage" />
      </div>
    </div>
  </div>

  <div
    v-if="data.no_errors.length > 0"
    class="mb-6 text-sm leading-relaxed text-n-50"
  >
    <div class="title mb-6 flex">
      <svg-vue
        icon="tick"
        class="mr-1 mt-0.5 shrink-0 text-lg text-spring-50"
      />
      <!-- eslint-disable vue/no-v-html -->
      <div v-html="noErrorMessage"></div>
      <!--eslint-enable-->
    </div>
    <div class="rounded-lg bg-mint px-6">
      <div class="no-errors">
        <ErrorItem :data="data.no_errors" />
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { defineProps } from 'vue';
import ErrorItem from './ErrorItem.vue';

const language = window['globalLang'];
defineProps({
  data: { type: Object, required: true },
});

const criticalMessage = language.common_lang.message.critical;

const warningMessage = language.common_lang.message.warning;

const noErrorMessage = language.common_lang.message.no_error;
</script>
