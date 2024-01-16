<template>
  <div class="help">
    <button>
      <svg-vue
        class="text-n-40"
        :class="{
          'text-tiny': iconSize,
          iconSize: !iconSize,
        }"
        icon="help"
      />
    </button>
    <div
      :class="[
        position === 'right'
          ? 'help__text left-0 ' + width
          : 'help__text right-0 ' + width,
      ]"
    >
      <div v-if="showIatiReference" class="mb-2 italic text-bluecoral">
        {{ translate.commonText('iati_standard_reference') }}
      </div>
      <span class="font-bold text-bluecoral">{{ name }}</span>
      <!-- eslint-disable vue/no-v-html -->
      <p v-html="hoverText" />
      <!--eslint-enable-->
      <a
        v-if="link"
        :href="link"
        class="translate-text-hover-learn-more inline-block font-bold text-bluecoral"
        >{{ translate.button('learn_more') }}</a
      >
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  props: {
    name: {
      type: String,
      required: false,
      default: '',
    },
    hoverText: {
      type: String,
      required: true,
    },
    width: {
      type: String,
      required: false,
      default: 'w-60',
    },
    position: {
      type: String,
      required: false,
      default: '',
    },
    link: {
      type: String,
      required: false,
      default: '',
    },
    iconSize: {
      type: String,
      required: false,
      default: '',
    },
    showIatiReference: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  setup() {
    const translate = new Translate();
    return { translate };
  },
});
</script>

<style lang="scss">
.help {
  @apply relative;

  &__text {
    @apply invisible absolute top-4 z-20 space-y-1.5 rounded bg-eggshell p-4 text-left text-xs text-n-40 opacity-0 duration-200;
    transition: all 0.3s ease-out;
    box-shadow: 0px 4px 40px rgb(0 0 0 / 10%);

    p a {
      font-weight: 700;
    }
  }
}

.help:hover {
  .help__text {
    transform: translate(50%, 5px);
    visibility: visible;
    opacity: 1;
    @media (max-width: 1024px) {
      width: 200px;
    }
  }
}
</style>
