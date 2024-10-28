<template>
  <div class="target ml-4 mt-6">
    <div v-for="(tValue, v) in targetValue" :key="v" class="item">
      <table class="mb-3 w-full">
        <tbody>
          <tr>
            <td><span class="category flex">Target Value</span></td>
            <td v-if="!isEveryValueNull(tValue)">
              <div :class="elementSpacing">
                {{ tValue.value ?? '' }}
                <span
                  v-if="!tValue.value"
                  class="text-xs italic text-light-gray"
                  >N/A</span
                >
              </div>

              <div class="flex" :class="elementSpacing">
                <div>Location Reference:&nbsp;</div>
                <div>
                  {{
                    getLocation(tValue.location)
                      ? getLocation(tValue.location)
                      : ''
                  }}
                  <span
                    v-if="!getLocation(tValue.location)"
                    class="text-xs italic text-light-gray"
                    >N/A</span
                  >
                </div>
              </div>

              <div class="flex" :class="elementSpacing">
                <div>Dimension:&nbsp;</div>
                <div>
                  <div
                    v-for="(dim, d) in tValue.dimension"
                    :key="d"
                    class="dimension"
                  >
                    {{ dim.name ?? '' }}
                    <span
                      v-if="!dim.name"
                      class="text-xs italic text-light-gray"
                      >N/A</span
                    >
                    ({{ dim.value ?? ''
                    }}<span
                      v-if="!dim.value"
                      class="text-xs italic text-light-gray"
                      >N/A</span
                    >)
                  </div>
                </div>
              </div>

              <div class="flex" :class="elementSpacing">
                <div>Comment:&nbsp;</div>
                <div>
                  <div
                    v-for="(com, c) in tValue.comment[0].narrative"
                    :key="c"
                    class="description-content"
                    :class="{
                      'mb-1.5': c !== tValue.comment[0].narrative.length - 1,
                    }"
                  >
                    <div class="language subtle-darker mb-1.5">
                      (Language:
                      {{ com.language ? dlType.language[com.language] : '' }}
                      <span
                        v-if="!com.language"
                        class="text-xs italic text-light-gray"
                        >N/A</span
                      >)
                    </div>
                    <div class="w-[500px] max-w-full">
                      {{ com.narrative ? com.narrative : '' }}
                      <span
                        v-if="!com.narrative"
                        class="text-xs italic text-light-gray"
                        >N/A</span
                      >
                    </div>
                  </div>
                </div>
              </div>
            </td>
            <td v-else>
              <span class="text-xs italic text-light-gray">N/A</span>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="!isEveryValueNull(tValue.document_link)">
        <table class="mb-3 w-full">
          <tbody>
            <tr>
              <td colspan="2">
                <div class="category flex">Document Link</div>
                <div
                  class="divider my-4 h-px w-full border-b border-n-20"
                ></div>
              </td>
            </tr>
          </tbody>
        </table>
        <DocumentLink :data="tValue.document_link" :type="dlType" />
      </div>
      <div v-else>
        <table class="mb-3 w-full">
          <tbody>
            <tr>
              <td>
                <div class="category flex">Document Link</div>
              </td>
              <td>
                <span class="text-xs italic text-light-gray">N/A</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div
        v-if="Number(v) != targetValue.length - 1"
        class="divider my-10 h-px w-full border-b border-n-20"
      ></div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';

// component
import { DocumentLink } from 'Activity/indicators/elements/Index';

//composable
import { getLocation, isEveryValueNull } from 'Composable/utils';

export default defineComponent({
  name: 'TargetValue',
  components: { DocumentLink },
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    let { data } = toRefs(props);

    // vue inject
    // const languageType = inject('types').language;
    const dlType = inject('types');

    const elementSpacing = 'mb-1';

    const targetValue = data.value;

    return {
      targetValue,
      elementSpacing,
      location,
      getLocation,
      // languageType,
      dlType,
      isEveryValueNull,
    };
  },
});
</script>
