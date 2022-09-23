<template>
  <div class="progress_bar">
    <div class="progress_bar__content">
      <div class="progress_bar__wrapper">
        <div class="progress_bar__viewer">
          <div class="progress_bar__shimmer"></div>
        </div>
      </div>
      <div
        class="progress_bar__state"
        :data-start="text"
        data-end="'Almost there!'"
      ></div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, onMounted, onUnmounted } from "vue";

defineProps({
  text: {
    type: String,
    required: true,
  },
  changeText: {
    type: Boolean,
    required: false,
    default: true,
  },
});

onMounted(() => {
  document.body.classList.add("overflow-y-hidden");
});

onUnmounted(() => {
  document.body.classList.remove("overflow-y-hidden");
});
</script>

<style lang="scss" scoped>
.progress_bar {
  @apply fixed left-0 bottom-0 flex w-full items-center justify-center bg-white;
  top: 60px;
  z-index: 999;
  height: calc(100vh - 60px);

  &__wrapper {
    @apply w-[250px] overflow-hidden rounded-2xl;
    background-color: #c4c4c4;
    overflow: hidden;
  }

  &__viewer {
    @apply bg-spring-50;
    border-radius: 4px;
    height: 4px;
    transform: scaleX(0);
    transform-origin: 0 0;
  }

  &.animate-loader &__viewer {
    animation: FillAnimation 6s cubic-bezier(0.01, 1.06, 0.71, 1) forwards;
  }

  &.animate-loader &__state::before {
    content: "";
    animation: TextChange 6s cubic-bezier(0.01, 1.06, 0.71, 1) forwards;
  }

  &__content {
    @apply flex flex-col;
  }

  &__state {
    @apply mt-6 text-center text-sm font-bold leading-normal text-blue-50;
  }
}

@keyframes FillAnimation {
  0% {
    transform: scaleX(0.028);
  }
  10% {
    transform: scaleX(0.028);
  }
  20% {
    transform: scaleX(0.028);
  }

  25% {
    transform: scaleX(0.24);
  }
  35% {
    transform: scaleX(0.24);
  }
  45% {
    transform: scaleX(0.24);
  }

  50% {
    transform: scaleX(0.624);
  }

  60% {
    transform: scaleX(0.624);
  }

  70% {
    transform: scaleX(0.624);
  }

  75% {
    transform: scaleX(0.928);
  }

  85% {
    transform: scaleX(0.928);
  }

  95% {
    transform: scaleX(0.928);
  }

  100% {
    transform: scaleX(1);
  }
}

@keyframes TextChange {
  0% {
    content: attr(data-start);
  }

  95% {
    content: attr(data-start);
  }

  100% {
    content: attr(data-end);
  }
}
</style>
