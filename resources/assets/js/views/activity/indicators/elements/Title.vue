<template>
  <tr>
    <td>{{ language.common_lang.title }}</td>
    <td>
      <template v-for="(title, t) in titleData.narrative" :key="t">
        <div
          class="title-content"
          :class="{
            'mb-3': t !== titleData.narrative.length - 1,
          }"
        >
          <div class="language mb-1 text-n-30">
            ({{ language.common_lang.language }}:
            {{
              titleType[title.language] ?? language.common_lang.missing.default
            }})
          </div>
          <div class="description text-xs">
            {{ title.narrative ?? language.common_lang.missing.default }}
          </div>
        </div>
      </template>
    </td>
  </tr>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

export default defineComponent({
  name: 'IndicatorTitle',
  components: {},
  props: {
    data: {
      type: Object,
      required: true,
    },
    titleType: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const language = window['globalLang'];
    let { data } = toRefs(props);
    const titleData = data.value;
    return { titleData, language };
  },
});
</script>
