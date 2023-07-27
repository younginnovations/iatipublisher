<template>
  <div class="rounded-lg bg-white p-6 text-xs leading-relaxed text-n-40">
    <div class="mb-3">{{ translate.commonText('note') }}</div>
    <div class="mb-3 flex justify-between">
      <div class="flex items-center space-x-1">
        <svg-vue class="text-sm" icon="core" />
        <span>{{ translate.commonText('core_elements') }}</span>
      </div>
      <HoverText
        :hover-text="
          translate.commonText('cannot_publish_activity_until_mandatory')
        "
        name=""
      />
    </div>

    <div class="mb-3 flex justify-between">
      <div class="flex items-center space-x-1">
        <svg-vue class="text-sm" icon="star" />
        <span>{{ translate.commonText('mandatory_sub_elements') }}</span>
      </div>
      <HoverText
        :hover-text="
          translate.commonText('cannot_publish_activity_until_mandatory')
        "
        name=""
      />
    </div>

    <div class="mb-3 flex justify-between">
      <div class="flex items-center space-x-1">
        <svg-vue class="text-sm" icon="moon" />
        <span>{{ translate.commonText('recommended_sub_elements') }}</span>
      </div>
      <HoverText
        :hover-text="
          translate.commonText('cannot_publish_activity_until_mandatory')
        "
        name=""
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import HoverText from '../../../components/HoverText.vue';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  name: 'ElementNote',
  components: {
    HoverText,
  },
  setup() {
    const translate = new Translate();
    return { translate };
  },
});
</script>
