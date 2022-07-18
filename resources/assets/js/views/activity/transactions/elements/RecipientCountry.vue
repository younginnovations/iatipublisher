<template>
  <div class="elements-detail wider">
    <div
      v-for="(cou, c) in country"
      :key="c"
      class="item"
      :class="{
        'mb-4': c !== Object.keys(country).length - 1,
      }"
    >
      <div class="category">
        <span>{{ countryCode[cou.country_code] }}</span>
      </div>
      <div class="ml-4">
        <table class="mb-3">
          <tr>
            <td>Description</td>
            <td>
              <div
                v-for="(sd, i) in cou.narrative"
                :key="i"
                class="mb-4 title-content"
                :class="{
                  'mb-4': i !== cou.narrative.length - 1,
                }"
              >
                <div class="language mb-1.5">(Language: {{ sd.language }})</div>
                <div class="text-sm description">
                  {{ sd.narrative }}
                </div>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

export default defineComponent({
  name: 'TransactionRecipientCountry',
  components: {},
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
    countryCode: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { data } = toRefs(props);

    interface ArrayObject {
      [index: number]: {
        country_code: string;
        narrative: [{ language: string; narrative: string }];
      };
    }
    const country = data.value as ArrayObject;
    return { country };
  },
});
</script>
