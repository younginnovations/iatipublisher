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
        <span>{{ type.countryCode[cou.country_code] }}</span>
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
                <div class="language mb-1.5">
                  (
                  {{
                    sd.language
                      ? `Language: ${type.languages[sd.language]}`
                      : 'Language Not Available'
                  }})
                </div>
                <div class="text-sm">
                  {{ sd.narrative ?? 'Narrative Not Available' }}
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
import { defineComponent, toRefs, inject } from 'vue';

export default defineComponent({
  name: 'TransactionRecipientCountry',
  components: {},
  props: {
    data: {
      type: [Object, String],
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

    const type = inject('types');
    return { country, type };
  },
});
</script>
