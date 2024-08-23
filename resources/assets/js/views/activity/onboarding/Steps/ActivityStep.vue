<template>
  <div class="flex h-full flex-col justify-around pt-[97px]">
    <div>
      <h3 class="pb-[2px] text-[20px] font-bold leading-9 text-n-50">
        Create an Activity
      </h3>

      <div
        class="mt-3 rounded-lg bg-n-10 pt-[20px] pl-[27px] pb-[20px] pr-[62px]"
      >
        <ul class="w-full max-w-[655px]">
          <li class="flex gap-2">
            <svg-vue
              class="mt-1 text-base text-bluecoral"
              icon="organisation-elements/org_identifier"
            ></svg-vue
            ><span>Add your first activity.</span>
          </li>
          <li class="flex items-baseline gap-2 py-5">
            <svg-vue
              icon="core-square"
              class="translate-y-1 text-base text-bluecoral"
            ></svg-vue>

            <span class="text-base">
              Populate the core data elements about your activity, plus any
              optional elements that are relevant.
            </span>
          </li>
          <li class="flex gap-2">
            <svg-vue
              class="mt-1 text-base text-bluecoral"
              icon="tick-cloud-square"
            ></svg-vue
            ><span>Publish your activity when ready.</span>
          </li>
        </ul>
      </div>
    </div>
    <div class="mt-3 flex w-full items-center justify-between">
      <button class="text-xs font-bold text-n-40" @click="previousStep">
        Previous
      </button>
      <div class="flex items-center gap-4">
        <button class="button primary-btn text-xs" @click="proceedStep">
          Get Started
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import axios from 'axios';
import { defineEmits } from 'vue';

const emit = defineEmits(['proceedStep', 'previousStep']);

const proceedStep = () => {
  axios
    .get('/organisation-onboarding/complete-activity')
    .then(() => {
      emit('proceedStep');
    })
    .catch((err) => {
      console.log(err);
    });
};

const previousStep = () => {
  emit('previousStep');
};
</script>
