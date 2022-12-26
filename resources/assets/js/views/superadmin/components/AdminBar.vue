<template>
  <div class="adminBar bg-eggshell px-10 py-3">
    <div class="inline-flex text-sm leading-normal">
      <svg-vue icon="smile" class="mt-1 mr-1 text-base text-spring-50" />
      <span class="mr-1">
        {{ language.common_lang.logged_in_as }}
        <b class="capitalize"> {{ name }} </b>,
        <b>{{ organizationName }}</b>
      </span>
      <span class="cursor-pointer text-spring-50" @click="switchBack()">
        <b>{{ language.button_lang.switch_back }}</b>
      </span>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';

const language = window['globalLang'];
defineProps({
  name: { type: String, required: true },
  organizationName: { type: String, required: true },
});

/**
 * Switch Back
 */
const switchBack = () => {
  window.location.replace('/list-organisations');
};
</script>
