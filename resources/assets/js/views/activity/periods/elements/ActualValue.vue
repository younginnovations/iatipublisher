<template>
  <div class="target mt-6 ml-4">
    <div v-for="(tValue, v) in actualValue" :key="v" class="item">
      <table class="mb-3 w-full">
        <tbody>
          <tr>
            <td>
              <span class="category flex">{{
                translate.commonText('actual_value')
              }}</span>
            </td>
            <td>
              <div :class="elementSpacing">
                {{ tValue.value ?? translate.missingText() }}
              </div>

              <div class="flex" :class="elementSpacing">
                <div>
                  {{ translate.commonText('location_reference') }}:&nbsp;
                </div>
                <div>
                  {{
                    getLocation(tValue.location)
                      ? getLocation(tValue.location)
                      : translate.missingText()
                  }}
                </div>
              </div>

              <div class="flex" :class="elementSpacing">
                <div>{{ translate.commonText('dimension') }}:&nbsp;</div>
                <div>
                  <div
                    v-for="(dim, d) in tValue.dimension"
                    :key="d"
                    class="dimension"
                  >
                    {{ dim.name ?? translate.missingText() }} ({{
                      dim.value ?? translate.missingText()
                    }})
                  </div>
                </div>
              </div>

              <div class="flex" :class="elementSpacing">
                <div>{{ translate.commonText('comment') }}:&nbsp;</div>
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
                        {{
                          com.narrative
                            ? com.narrative
                            : translate.missingText()
                        }}
                        &nbsp;
                      </span>
                      <span>
                        ({{ translate.commonText('language') }}:
                        {{
                          com.language
                            ? dlType.language[com.language]
                            : translate.missingText()
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
      <table class="mb-3 w-full">
        <tbody>
          <tr>
            <td colspan="2">
              <div class="category flex">
                {{ translate.commonText('document_link') }} }}
              </div>
              <div class="divider my-4 h-px w-full border-b border-n-20"></div>
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
import { getLocation } from 'Composable/utils';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  name: 'ActualValue',
  components: { DocumentLink },
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const translate = new Translate();
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
      translate,
    };
  },
});
</script>
