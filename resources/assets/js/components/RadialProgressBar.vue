<template>
  <radial-progress-bar
    :diameter="80"
    :completed-steps="completedPercent"
    :total-steps="totalPercent"
    :isClockwise="false"
    innerStrokeColor="#17997b26"
    startColor="#17997B"
    stopColor="#17997B"
    :strokeWidth="6"
    :innerStrokeWidth="6"
  >
    <!-- Your inner content here -->
    <p class="z-10 text-base text-spring-50">{{ completedPercent }} %</p>
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
    const completedPercent = ref(60);
    const totalPercent = ref(100);

    return {
      completedPercent,
      totalPercent,
    };
  },
});
</script>
