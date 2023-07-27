<template>
  <tr>
    <td>{{ translate.commonText('title') }}</td>
    <td>
      <template v-for="(title, t) in titleData.narrative" :key="t">
        <div
          class="title-content"
          :class="{
            'mb-3': t !== titleData.narrative.length - 1,
          }"
        >
          <div class="language mb-1 text-n-30">
            ({{ translate.commonText('language') }}:
            {{ titleType[title.language] ?? translate.missingText() }})
          </div>
          <div class="description text-xs">
            {{ title.narrative ?? translate.missingText() }}
          </div>
        </div>
      </template>
    </td>
  </tr>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import { Translate } from 'Composable/translationHelper';

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
    const translate = new Translate();
    let { data } = toRefs(props);
    const titleData = data.value;
    return { titleData, translate };
  },
});
</script>
