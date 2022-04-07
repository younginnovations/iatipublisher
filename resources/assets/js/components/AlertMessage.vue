<template>
  <div
    class="flex border-l-2 px-3 py-2.5 text-sm leading-relaxed"
    :class="type"
  >
    <svg-vue :icon="icon" class="mr-2 mt-0.5 text-lg"></svg-vue>
    <b><slot /></b>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'alert-message',
  components: {},
  props: {
    type: String,
  },
  setup(props) {
    let icon = 'tick';
    if (props.type === 'failure') {
      icon = 'close';
    }
    return { icon };
  },
});
</script>

<style lang="scss" scoped>
.success {
  @apply border-spring-50 bg-mint;
  svg {
    @apply text-spring-50;
  }
}

.failure {
  @apply bg-rose text-crimson-40;
  svg {
    @apply text-crimson-40;
  }
}
</style>
