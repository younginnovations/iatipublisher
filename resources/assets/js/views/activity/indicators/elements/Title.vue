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
          <div class="language mb-1 text-n-30">
            (Language:
            <ConditionalTextDisplay
              :success-text="titleType[title.language]"
              :condition="titleType[title.language]"
            />)
          </div>
          <div class="description text-xs">
            <ConditionalTextDisplay
              :success-text="title.narrative"
              :condition="title.narrative"
              failure-text="title"
            />
          </div>
        </div>
      </template>
    </td>
  </tr>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import ConditionalTextDisplay from 'Components/ConditionalTextDisplay.vue';

export default defineComponent({
  name: 'IndicatorTitle',
  components: { ConditionalTextDisplay },
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
