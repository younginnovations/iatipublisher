<template>
  <a
    :href="link"
    class="px-4 py-3 text-xs leading-normal bg-white border border-dashed rounded add_indicator border-n-40 text-n-40"
    :class="{ 'flex w-full': btnText, 'inline-flex': !btnText }"
  >
    <div class="italic text-left grow">
      {{ description }}
    </div>
    <Btn v-if="btnText" :text="btnText" icon="add" />
  </a>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

// components
import Btn from 'Components/buttons/Link.vue';

export default defineComponent({
  name: 'HaveNotAddedYet',
  components: { Btn },
  props: {
    link: {
      type: String,
      required: true,
    },
    description: {
      type: String,
      required: true,
    },
    btnText: {
      type: String,
      required: false,
      default: '',
    },
  },
  setup() {
    return {};
  },
});
</script>
