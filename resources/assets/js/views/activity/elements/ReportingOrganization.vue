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
            : 'Type Missing'
        }}</span>
      </div>
      <table>
        <tbody>
          <tr>
            <td>Reference</td>
            <td>
              <ConditionalTextDisplay
                :condition="reporting_org.ref"
                :success-text="reporting_org.ref"
                failure-text="reference"
              />
            </td>
          </tr>
          <tr>
            <td>Secondary Reporter</td>
            <td>
              <ConditionalTextDisplay
                :condition="parseInt(reporting_org.secondary_reporter)"
                success-text="True"
                :failure-text="
                  reporting_org.secondary_reporter
                    ? 'False'
                    : 'secondary reporter'
                "
                show-failure-text-as-plain-text="true"
              />
            </td>
          </tr>
          <tr>
            <td>Narrative</td>
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
                  (Language:
                  <ConditionalTextDisplay
                    :condition="narrative.language"
                    :success-text="types.languages[narrative.language]"
                  />)
                </div>
                <div class="w-[500px] max-w-full">
                  <ConditionalTextDisplay
                    :condition="narrative.narrative"
                    :success-text="narrative.narrative"
                    failure-text="narrative"
                  />
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
import ConditionalTextDisplay from 'Components/ConditionalTextDisplay.vue';

defineProps({
  data: { type: Object, required: true },
});

interface Types {
  languages: [];
  organizationType: [];
}

const types = inject('types') as Types;
</script>
