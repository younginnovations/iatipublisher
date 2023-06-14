<template>
  <div class="target mt-6 ml-4">
    <div v-for="(tValue, v) in targetValue" :key="v" class="item">
      <table class="mb-3 w-full">
        <tbody>
          <tr>
            <td>
              <span class="category flex">{{
                language.common_lang.target_value
              }}</span>
            </td>
            <td>
              <div :class="elementSpacing">
                {{ tValue.value ?? language.common_lang.missing.default }}
              </div>

              <div class="flex" :class="elementSpacing">
                <div>{{ language.common_lang.location_reference }}:&nbsp;</div>
                <div>
                  {{
                    getLocation(tValue.location)
                      ? getLocation(tValue.location)
                      : language.common_lang.missing.default
                  }}
                </div>
              </div>

              <div class="flex" :class="elementSpacing">
                <div>{{ language.common_lang.dimension }}:&nbsp;</div>
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
                <div>{{ language.common_lang.comment }}:&nbsp;</div>
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
                      ({{ language.common_lang.language }}:
                      {{
                        com.language
                          ? dlType.language[com.language]
                          : language.common_lang.missing.default
                      }})
                    </div>
                    <div class="w-[500px] max-w-full">
                      {{
                        com.narrative
                          ? com.narrative
                          : language.common_lang.missing.default
                      }}
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
                {{ language.common_lang.document_link }}
              </div>
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
    const language = window['globalLang'];
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
      language,
    };
  },
});
</script>
