<template>
  <div class="target mt-6 ml-4">
    <div v-for="(tValue, v) in targetValue" :key="v" class="item">
      <table class="mb-3 w-full">
        <tbody>
          <tr>
            <td><span class="category flex">Target Value</span></td>
            <td>
              <div :class="elementSpacing">
                <ConditionalTextDisplay
                  :success-text="tValue.value"
                  :condition="tValue.value"
                />
              </div>

              <div class="flex" :class="elementSpacing">
                <div>Location Reference:&nbsp;</div>
                <div>
                  <ConditionalTextDisplay
                    :success-text="getLocation(tValue.location)"
                    :condition="getLocation(tValue.location)"
                    failure-text="location reference"
                  />
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
                    <ConditionalTextDisplay
                      :success-text="dim.name"
                      :condition="dim.name"
                    />
                    (<ConditionalTextDisplay
                      :success-text="dim.value"
                      :condition="dim.value"
                      failure-text="value"
                    />)
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
                      <ConditionalTextDisplay
                        :success-text="com.language"
                        :condition="dlType.language[com.language]"
                      />)
                    </div>
                    <div class="w-[500px] max-w-full">
                      <ConditionalTextDisplay
                        :success-text="com.narrative"
                        :condition="com.narrative"
                        failure-text="comment"
                      />
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
import ConditionalTextDisplay from 'Components/ConditionalTextDisplay.vue';

export default defineComponent({
  name: 'TargetValue',
  components: { ConditionalTextDisplay, DocumentLink },
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
