<template>
  <tr>
    <td>Title</td>
    <td>
      <template v-for="(title, t) in titleData.narrative" :key="t">
        <div
          class="title-content"
          :class="{
            'mb-3': t !== titleData.narrative.length - 1,
          }"
        >
          <div class="mb-1 language">
            (Language: {{ titleType[title.language] }})
          </div>
          <div class="text-xs description">
            {{ title.narrative }}
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
    let { data } = toRefs(props);
    const titleData = data.value;
    return { titleData };
  },
});
</script>
