<template>
  <CircleProgress
    :size="80"
    :percent="60"
    :viewport="true"
    :show-percent="true"
    fill-color="#17997B"
    empty-color="#17997b26"
    :border-width="7"
    :border-bg-width="7"
  />
</template>

<script>
import { ref, onMounted } from 'vue';
import CircleProgress from 'vue3-circle-progress';
import 'vue3-circle-progress/dist/circle-progress.css';
export default {
  name: 'App',
  components: {
    CircleProgress: CircleProgress,
  },
  setup() {
    const percent = ref(75);

    onMounted(() => {
      setInterval(() => {
        if (percent.value === 25) {
          percent.value = 75;
        } else {
          percent.value = 25;
        }
      }, 1000);
    });

    return {
      percent,
    };
  },
};
</script>

<style lang="scss">
.vue3-circular-progressbar {
  svg {
    height: 70px;
    width: 70px;
  }
  .current-counter[data-v-49af6a0a] {
    position: absolute;
    top: 45%;
    left: 40%;
    transform: translate(-50%, -50%);
  }
}
</style>
