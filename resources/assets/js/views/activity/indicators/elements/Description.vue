<template>
  <tr>
    <td>Description</td>
    <td>
      <template v-for="(description, t) in descriptionData.narrative" :key="t">
        <div
          class="description-content"
          :class="{
            'mb-3': t !== descriptionData.narrative.length - 1,
          }"
        >
          <div class="text-n-30">
            (Language:<ConditionalTextDisplay
              :success-text="descType[description.language]"
              :condition="description.language"
            />)
          </div>
          <div class="description text-xs">
            {{ description.narrative }}
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
  name: 'IndicatorDescription',
  components: { ConditionalTextDisplay },
  props: {
    data: {
      type: Object,
      required: true,
    },
    descType: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    let { data } = toRefs(props);
    const descriptionData = data.value;
    return { descriptionData };
  },
});
</script>
