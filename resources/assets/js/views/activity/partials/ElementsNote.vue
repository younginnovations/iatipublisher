<template>
  <div class="rounded-lg bg-white p-6 text-xs leading-relaxed text-n-40">
    <div class="mb-3">{{ language.common_lang.note }}</div>
    <div class="mb-3 flex justify-between">
      <div class="flex items-center space-x-1">
        <svg-vue class="text-sm" icon="core" />
        <span>{{ language.common_lang.core_elements }}</span>
      </div>
      <HoverText
        :hover-text="
          language.common_lang.cannot_publish_activity_until_mandatory
        "
        name=""
      />
    </div>

    <div class="mb-3 flex justify-between">
      <div class="flex items-center space-x-1">
        <svg-vue class="text-sm" icon="star" />
        <span>{{ language.common_lang.mandatory_sub_elements }}</span>
      </div>
      <HoverText
        :hover-text="
          language.common_lang.cannot_publish_activity_until_mandatory
        "
        name=""
      />
    </div>

    <div class="mb-3 flex justify-between">
      <div class="flex items-center space-x-1">
        <svg-vue class="text-sm" icon="moon" />
        <span>{{ language.common_lang.recommended_sub_elements }}</span>
      </div>
      <HoverText
        :hover-text="
          language.common_lang.cannot_publish_activity_until_mandatory
        "
        name=""
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import HoverText from '../../../components/HoverText.vue';

export default defineComponent({
  name: 'ElementNote',
  components: {
    HoverText,
  },
  setup() {
    const language = window['globalLang'];
    return { language };
  },
});
</script>
