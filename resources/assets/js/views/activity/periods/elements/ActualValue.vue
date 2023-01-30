<template>
  <div class="target mt-6 ml-4">
    <div v-for="(tValue, v) in actualValue" :key="v" class="item">
      <table class="mb-3 w-full">
        <tbody>
          <tr>
            <td><span class="category flex">Actual Value</span></td>
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
                    class="item"
                    :class="{
                      'mb-1.5': c !== tValue.comment[0].narrative.length - 1,
                    }"
                  >
                    <div>
                      <span>
                        {{ com.narrative ? com.narrative : 'Missing' }}
                        &nbsp;
                      </span>
                      <span>
                        (Language:
                        {{
                          com.language
                            ? dlType.language[com.language]
                            : 'Missing'
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
              <div class="category flex">Document Link</div>
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
import getLocation from 'Composable/utils';

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
