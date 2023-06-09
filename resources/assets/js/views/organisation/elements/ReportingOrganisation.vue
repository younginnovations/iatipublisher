<template>
  <div
    v-for="(reporting_org, index) in content"
    :key="index"
    class="item"
    :class="{
      'mb-4 border-b border-n-20 pb-4': Number(index) != content.length - 1,
    }"
  >
    <div class="elements-detail mb-4">
      <div class="category">
        <span>{{
          reporting_org.type
            ? types?.organizationType[reporting_org.type]
            : translation.common_lang.missing.type
        }}</span>
      </div>
      <table>
        <tbody>
          <tr>
            <td>{{ translation.common_lang.reference }}</td>
            <td>
              {{
                reporting_org.ref ?? translation.common_lang.missing.reference
              }}
            </td>
          </tr>
          <tr>
            <td>{{ translation.common_lang.secondary_reporter }}</td>
            <td>
              {{
                parseInt(reporting_org.secondary_reporter)
                  ? translation.common_lang.true
                  : reporting_org.secondary_reporter === '0'
                  ? translation.common_lang.false
                  : translation.common_lang.missing.default
              }}
            </td>
          </tr>
          <tr>
            <td>{{ translation.common_lang.narrative }}</td>
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
                      ? `${translation.common_lang.language}: ${
                          types?.languages[narrative.language]
                        }`
                      : `${translation.common_lang.language} : ${translation.common_lang.missing.default}`
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{
                    narrative.narrative ??
                    translation.common_lang.missing.narrative
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

defineProps({
  content: { type: Object, required: true },
});

interface TypesInterface {
  languages: [];
  organizationType: [];
}

const translation = window['globalLang'];
const types = inject('orgTypes') as TypesInterface;
</script>
