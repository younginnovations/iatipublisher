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
            : 'Type Missing'
        }}</span>
      </div>
      <table>
        <tbody>
          <tr>
            <td>Reference</td>
            <td>
              <ConditionalTextDisplay
                :success-text="reporting_org.ref"
                :condition="reporting_org.ref"
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
                  reporting_org.secondary_reporter === '0'
                    ? 'False'
                    : 'secondary reporter'
                "
                :show-failure-text-as-plain-text="
                  reporting_org.secondary_reporter === '0'
                "
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
                    :condition="narrative.language && types.languages"
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
  content: { type: Object, required: true },
});

interface TypesInterface {
  languages: [];
  organizationType: [];
}

const types = inject('orgTypes') as TypesInterface;
</script>
