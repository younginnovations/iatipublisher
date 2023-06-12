<template>
  <div class="errors" :class="bgColor">
    <div class="errors__head cursor-pointer" @click="accordionToggle">
      <div class="errors__head--title">
        <svg-vue
          class="mr-2 text-base"
          :class="iconColor"
          icon="alert"
        ></svg-vue>
        <div class="font-bold capitalize">{{ errorType }}</div>
      </div>
      <svg-vue
        class="text-xl text-blue-50 transition-transform duration-500"
        :class="{ 'rotate-180': toggle, '': !toggle }"
        icon="arrow-down"
      ></svg-vue>
    </div>
    <div class="errors__list">
      <ul class="errors__list__error">
        <li v-for="(error, e) in errors" :key="e" class="errors__list__item">
          <div v-if="error.context.length > 1">
            {{ error.message }}
            <ul class="errors__list__item__element">
              <li v-for="(element, index) in error.context" :key="index">
                <a :href="error.context[index].iati_path">{{
                  element.message
                }}</a>
              </li>
            </ul>
          </div>
          <div v-else-if="error.context.length === 1">
            <a :href="error.context['0'].iati_path">{{ error.message }}</a>
          </div>
          <div v-else>
            {{ error.message }}
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, toRefs, ref, watch } from 'vue';

//props
const props = defineProps({
  errors: { type: Object, required: true },
  type: { type: String, default: 'error' },
});

//props destructuring
const { type, errors } = toRefs(props);

const errorType = ref('');

// colors based on type props value
let bgColor = '',
  iconColor = '';
switch (type.value) {
  case 'critical':
    bgColor = 'bg-lavender-60 border-lavender-50';
    iconColor = 'text-lavender-50';
    break;

  case 'warnings':
    bgColor = 'bg-eggshell border-camel-50';
    iconColor = 'text-camel-50';
    break;

  default:
    bgColor = 'bg-rose border-crimson-40';
    iconColor = 'text-crimson-40';
    break;
}

const toggle = ref(false);

const accordionToggle = (e: Event) => {
  const currentTarget = e.currentTarget as HTMLElement;
  const target = (
    currentTarget.parentElement as HTMLElement
  ).querySelector<HTMLElement>('.errors__list');
  const elHeight = target?.querySelector('ul')?.clientHeight;

  if (toggle.value) {
    if (target != null) {
      target.style.cssText = `height: ${elHeight}px;`;
      setTimeout(function () {
        target.style.cssText = ``;
      }, 100);
      toggle.value = false;
    }
  } else {
    if (target != null) {
      target.style.cssText = `height: ${elHeight}px;`;

      setTimeout(function () {
        target.style.cssText = `height: auto;`;
      }, 600);

      toggle.value = true;
    }
  }
};

const updateErrorCountMessage = () => {
  errorType.value =
    errors.value.length +
    ' ' +
    type.value.charAt(0).toUpperCase() +
    type.value.slice(1);
};

updateErrorCountMessage();

watch(
  () => errors.value,
  () => {
    updateErrorCountMessage();
  }
);
</script>

<style lang="scss" scoped>
.errors {
  @apply border-l-2;

  &__head {
    @apply flex justify-between p-4;

    &--title {
      @apply flex grow items-center text-sm leading-relaxed;
    }
  }

  &__list {
    @apply h-0 overflow-hidden px-4 transition-all duration-500;

    &__error {
      @apply px-6;
    }

    &__item {
      @apply py-4 text-sm leading-normal;

      &__element {
        @apply list-disc px-4 text-blue-50;
      }
    }

    &__item:not(:last-child) {
      @apply border-b border-n-20;
    }
  }
}
</style>
