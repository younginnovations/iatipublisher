<template>
  <div class="target mt-6 ml-4">
    <div v-for="(tValue, v) in actualValue" :key="v" class="item">
      <table class="mb-3 w-full">
        <tbody>
          <tr>
            <td>
              <span class="category flex">{{
                language.common_lang.actual_value.upper_case
              }}</span>
            </td>
            <td>
              <div :class="elementSpacing">
                {{ tValue.value ?? language.common_lang.missing.default }}
              </div>

              <div class="flex" :class="elementSpacing">
                <div>
                  {{
                    language.common_lang.location_reference.upper_case
                  }}:&nbsp;
                </div>
                <div>
                  {{
                    getLocation(tValue.location)
                      ? getLocation(tValue.location)
                      : language.common_lang.missing.default
                  }}
                </div>
              </div>

              <div class="flex" :class="elementSpacing">
                <div>
                  {{ language.common_lang.dimension.upper_case }}:&nbsp;
                </div>
                <div>
                  <div
                    v-for="(dim, d) in tValue.dimension"
                    :key="d"
                    class="dimension"
                  >
                    {{ dim.name ?? language.common_lang.missing.default }} ({{
                      dim.value ?? language.common_lang.missing.default
                    }})
                  </div>
                </div>
              </div>

              <div class="flex" :class="elementSpacing">
                <div>{{ language.common_lang.comment.upper_case }}:&nbsp;</div>
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
                            : language.common_lang.missing.default
                        }}
                        &nbsp;
                      </span>
                      <span>
                        ({{ language.common_lang.language }}:
                        {{
                          com.language
                            ? dlType.language[com.language]
                            : language.common_lang.missing.default
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
                {{ language.common_lang.document_link.upper_case }}
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
    const language = window['globalLang'];
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
      language,
    };
  },
});
</script>
