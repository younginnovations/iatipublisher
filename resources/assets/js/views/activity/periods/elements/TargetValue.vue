<template>
  <div class="target mt-6 ml-4">
    <div v-for="(tValue, v) in targetValue" :key="v" class="item">
      <table class="mb-3 w-full">
        <tbody>
          <tr>
            <td><span class="category flex">Target Value</span></td>
            <td>
              <div :class="elementSpacing">
                {{ tValue.value ?? 'Missing' }}
              </div>

              <div class="flex" :class="elementSpacing">
                <div>Location Reference:&nbsp;</div>
                <div>
                  {{
                    getLocation(tValue.location)
                      ? getLocation(tValue.location)
                      : 'Missing'
                  }}
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
                    {{ dim.name ?? 'Missing' }} ({{ dim.value ?? 'Missing' }})
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
                    <div class="language mb-1.5">
                      (Language:
                      {{
                        com.language
                          ? dlType.language[com.language]
                          : 'Missing'
                      }})
                    </div>
                    <div class="w-[500px] max-w-full">
                      {{ com.narrative ? com.narrative : 'Missing' }}
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <table class="mb-3 w-full">
        <tbody>
          <tr>
            <td colspan="2">
              <div class="category flex">Document Link</div>
              <div class="divider my-4 h-px w-full border-b border-n-20"></div>
            </td>
          </tr>
        </tbody>
      </table>
      <DocumentLink :data="tValue.document_link" :type="dlType" />
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
import { getLocation } from 'Composable/utils';

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
    };
  },
});
</script>
