<template>
  <div class="status ml-2.5 flex text-xs leading-5" :class="color">
    <b class="mr-2 text-base leading-3">.</b><span>{{ text }}</span>
  </div>
</template>

<script setup lang="ts">
import { defineProps, toRefs } from 'vue';
import { Translate } from 'Composable/translationHelper';

const translate = new Translate();
const props = defineProps({
  data: { type: Boolean, required: true },
});

const { data } = toRefs(props);

let color = data.value ? 'text-spring-50' : 'text-crimson-50',
  text = data.value
    ? translate.commonText('completed')
    : translate.commonText('not_completed');
</script>
