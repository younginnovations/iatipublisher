<template>
  <div
    :id="elementName"
    class="px-3 py-3 activities__content--element text-n-50"
    :class="{
      'basis-full': width === 'full',
      'basis-6/12': width === '',
    }"
  >
    <div class="p-4 bg-white rounded-lg">
      <div class="flex mb-4">
        <div class="flex title grow">
          <div class="text-sm font-bold title">{{ elementName }}</div>
        </div>
        <div class="flex items-center icons">
          <HoverText hover-text="example text" class="text-n-40"></HoverText>
        </div>
      </div>
      <div class="w-full h-px mb-4 divider bg-n-20"></div>
      <div>
        <template
          v-if="elementName === 'title' || elementName === 'description'"
        >
          <TitleDescription :data="elementData" :type="types.language" />
        </template>

        <template v-else-if="elementName === 'aggregation_status'">
          <span class="text-sm capitalize">{{
            parseInt(data) ? 'True' : data ? 'False' : 'Missing'
          }}</span>
        </template>

        <template v-else-if="elementName === 'document_link'">
          <DocumentLink :data="elementData" :type="types" />
        </template>

        <template v-else-if="elementName === 'reference'">
          <Reference :data="elementData" :type="resultVocabulary" />
        </template>

        <template v-else-if="elementName === 'type'">
          <ResultType :data="Number(elementData)" :type="resultType" />
        </template>

        <template v-else>
          {{ data }}
        </template>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import HoverText from 'Components/HoverText.vue';
import {
  TitleDescription,
  DocumentLink,
  Reference,
  ResultType,
} from './elements/Index';

export default defineComponent({
  name: 'ActivityElement',
  components: {
    HoverText,
    TitleDescription,
    DocumentLink,
    Reference,
    ResultType,
  },
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
    elementName: {
      type: String,
      required: true,
    },
    editUrl: {
      type: String,
      required: true,
    },
    width: {
      type: String,
      required: false,
      default: '',
    },
    types: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    let { data, types } = toRefs(props),
      elementData = data.value,
      resultType = types.value.resultType,
      resultVocabulary = types.value.resultVocabulary,
      language = types.value.language;

    return { elementData, resultType, resultVocabulary, language };
  },
});
</script>
