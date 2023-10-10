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
          <tbody>
            <tr>
              <td>Description</td>
              <td>
                <div
                  v-for="(sd, i) in cou.narrative"
                  :key="i"
                  class="title-content mb-4"
                  :class="{
                    'mb-4': i !== cou.narrative.length - 1,
                  }"
                >
                  <div class="language mb-1.5">
                    (Language:
                    <ConditionalTextDisplay
                      :success-text="type.languages[sd.language]"
                      :condition="sd.language"
                    />)
                  </div>
                  <div class="text-sm">
                    <ConditionalTextDisplay
                      :success-text="sd.narrative"
                      :condition="sd.narrative"
                      failure-text="narrative"
                    />
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';
import ConditionalTextDisplay from 'Components/ConditionalTextDisplay.vue';

export default defineComponent({
  name: 'TransactionRecipientCountry',
  components: { ConditionalTextDisplay },
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

    interface TypesInterface {
      countryCode: [];
      languages: [];
    }

    const type = inject('types') as TypesInterface;
    return { country, type };
  },
});
</script>
