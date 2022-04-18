<template>
  <div>
    <div class="dropdown__content">
      <div class="flex flex-col">
        <strong class="text-sm font-bold text-n-50">{{ props.name }}</strong>
        <p class="mt-2 mb-4 text-sm text-n-50">
          {{ props.text }}
        </p>
        <a class="read__more" href="#">{{ props.btnText }}</a>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    name: String,
    text: String,
    btnText: String,
  },
  setup(props) {
    return {
      props,
    };
  },
});
</script>
