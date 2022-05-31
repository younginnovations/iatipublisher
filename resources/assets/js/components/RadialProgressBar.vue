<template>
  <radial-progress-bar
    :diameter="80"
    :completed-steps="completedSteps"
    :total-steps="totalSteps"
    :isClockwise="false"
    innerStrokeColor="#17997b26"
    startColor="#17997B"
    stopColor="#17997B"
    :strokeWidth="7"
    :innerStrokeWidth="7"
  >
    <!-- Inner content here -->
    <p class="text-base text-n-30">
      <span class="text-spring-50">{{ completedSteps }} / </span
      >{{ totalSteps }}
    </p>
  </radial-progress-bar>
</template>

<script lang="ts">
import { ref, defineComponent } from 'vue';
import RadialProgressBar from 'vue3-radial-progress';

export default defineComponent({
  components: {
    RadialProgressBar,
  },
  setup() {
    const completedSteps = ref(1);
    const totalSteps = ref(3);

    return {
      completedSteps,
      totalSteps,
    };
  },
});
</script>
