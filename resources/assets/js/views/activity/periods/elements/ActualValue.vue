<template>
  <div class="mt-6 ml-4 target">
    <div v-for="(tValue, v) in actualValue" :key="v" class="item">
      <table class="w-full mb-3">
        <tbody>
          <tr>
            <td><span class="flex category">Actual Value</span></td>
            <td>
              <div :class="elementSpacing">
                {{ tValue.value ?? 'Not available' }}
              </div>

              <div class="flex" :class="elementSpacing">
                <div>Location Reference:&nbsp;</div>
                <div>
                  {{
                    getLocation(tValue.location)
                      ? getLocation(tValue.location)
                      : 'Not Available'
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
                    {{ dim.name ?? 'Not Available' }} ({{
                      dim.value ?? 'Not Available'
                    }})
                  </div>
                </div>
              </div>

              <div class="flex" :class="elementSpacing">
                <div>Comment:&nbsp;</div>
                <div>
                  <div
                    v-for="(com, c) in tValue.comment[0].narrative"
                    :key="c"
                    class="item"
                    :class="{
                      'mb-1.5': c !== tValue.comment[0].narrative.length - 1,
                    }"
                  >
                    <div>
                      <span>
                        {{ com.narrative ? com.narrative : 'Not Available' }}
                        &nbsp;
                      </span>
                      <span>
                        (Language:
                        {{
                          com.language
                            ? dlType.language[com.language]
                            : 'Not Available'
                        }})
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <table class="w-full mb-3">
        <tbody>
          <tr>
            <td colspan="2">
              <div class="flex category">Document Link</div>
              <div class="w-full h-px my-4 border-b divider border-n-20"></div>
            </td>
          </tr>
        </tbody>
      </table>
      <DocumentLink :data="tValue.document_link" :type="dlType" />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';

// component
import { DocumentLink } from 'Activity/indicators/elements/Index';

//composable
import getLocation from 'Composable/utils';

export default defineComponent({
  name: 'actualValue',
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
    const dlType = inject('types');

    const elementSpacing = 'mb-1';

    const actualValue = data.value;

    return {
      actualValue,
      elementSpacing,
      location,
      getLocation,
      dlType,
    };
  },
});
</script>
