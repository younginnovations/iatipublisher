<template>
  <tr>
    <td>{{ translate.commonText('description') }}</td>
    <td>
      <template v-for="(description, t) in descriptionData.narrative" :key="t">
        <div
          class="description-content"
          :class="{
            'mb-3': t !== descriptionData.narrative.length - 1,
          }"
        >
          <div class="text-n-30">
            ({{ translate.commonText('language') }}:
            {{
              description.language
                ? descType[description.language]
                : translate.missing()
            }})
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
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  name: 'IndicatorDescription',
  components: {},
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
    const translate = new Translate();
    let { data } = toRefs(props);
    const descriptionData = data.value;
    return { descriptionData, translate };
  },
});
</script>
