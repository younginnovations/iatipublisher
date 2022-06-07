<template>
  <radial-progress-bar
    :diameter="80"
    :completed-steps="props.isPercent ? completedPercent : completedSteps"
    :total-steps="props.isPercent ? totalPercent : totalSteps"
    :isClockwise="false"
    innerStrokeColor="#17997b26"
    startColor="#17997B"
    stopColor="#17997B"
    :strokeWidth="7"
    :innerStrokeWidth="7"
  >
    <!-- Inner content here -->
    <p v-if="!props.isPercent" class="text-base text-n-30">
      <span class="text-spring-50">{{ completedSteps }} / </span
      >{{ totalSteps }}
    </p>
    <p v-if="props.isPercent" class="z-50 text-base text-spring-50">
      {{ completedPercent }} %
    </p>
  </radial-progress-bar>
</template>

<script lang="ts">
import { ref, defineComponent } from 'vue';
import RadialProgressBar from 'vue3-radial-progress';

export default defineComponent({
  props: {
    isPercent: {
      type: Boolean,
      required: false,
    },
  },
  components: {
    RadialProgressBar,
  },
  setup(props) {
    const completedSteps = ref(1);
    const totalSteps = ref(3);

    const completedPercent = ref(70);
    const totalPercent = ref(100);

    return {
      completedSteps,
      totalSteps,
      completedPercent,
      totalPercent,
      props,
    };
  },
});
</script>
