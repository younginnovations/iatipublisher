<template>
  <div
    v-for="(reporting_org, index) in data.content"
    :key="index"
    class="item"
    :class="{
      'mb-4 border-b border-n-20 pb-4':
        Number(index) != data.content.length - 1,
    }"
  >
    <div class="elements-detail mb-4">
      <div class="category">
        <span>{{
          reporting_org.type
            ? types?.organizationType[reporting_org.type]
            : translate.missingText('type')
        }}</span>
      </div>
      <table>
        <tbody>
          <tr>
            <td>{{ translate.commonText('reference') }}</td>
            <td>
              {{
                reporting_org.ref ??
                translate.missingText('element', 'common.reference')
              }}
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('secondary_reporter') }}</td>
            <td>
              {{
                parseInt(reporting_org.secondary_reporter)
                  ? translate.commonText('true')
                  : reporting_org.secondary_reporter
                  ? translate.commonText('false')
                  : translate.missingText()
              }}
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('narrative') }}</td>
            <td>
              <div
                v-for="(narrative, j) in reporting_org.narrative"
                :key="j"
                class="description-content"
                :class="{
                  'mb-4': j != reporting_org.narrative.length - 1,
                }"
              >
                <div class="language mb-1.5">
                  ({{
                    narrative.language
                      ? `${translate.commonText('language')}: ${
                          types?.languages[narrative.language]
                        }`
                      : `${translate.commonText(
                          'language'
                        )} : ${translate.missingText()}`
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{
                    narrative.narrative ?? translate.missingText('narrative')
                  }}
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, inject } from 'vue';
import { Translate } from 'Composable/translationHelper';

defineProps({
  data: { type: Object, required: true },
});

interface Types {
  languages: [];
  organizationType: [];
}

const translate = new Translate();
const types = inject('types') as Types;
</script>
