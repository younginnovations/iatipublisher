<template>
  <div :class="layout" class="activities__content--element px-3 py-3">
    <div class="rounded-lg bg-white p-4">
      <div class="mb-4 flex">
        <div class="title flex grow">
          <svg-vue
            class="mr-1.5 text-xl text-bluecoral"
            icon="align-center"
          ></svg-vue>
          <div class="title text-sm font-bold">{{ title }}</div>
          <div
            v-if="status"
            class="status ml-2.5 flex text-xs leading-5 text-spring-50"
          >
            <b class="mr-2 text-base leading-3">.</b>
            <span>{{ status }}</span>
          </div>
        </div>
        <div class="icons flex">
          <a
            class="edit-button mr-2.5 flex items-center text-xs font-bold uppercase"
            href="/1/title-form"
          >
            <svg-vue class="mr-0.5 text-base" icon="edit"></svg-vue>
            <span>Edit</span>
          </a>
          <svg-vue class="mr-1.5" icon="core"></svg-vue>
          <HoverText
            v-if="tooltip"
            :hover_text="tooltip"
            class="text-n-40"
          ></HoverText>
        </div>
      </div>
      <div class="divider mb-4 h-px w-full bg-n-20"></div>
      <template>
        <div v-for="(post, index) in content" class="content">
          <!--          <template v-switch="element_name">-->
          <!--            <template v-case="title">-->
          <!--              <div v-if="post.language" class="language mb-1.5 text-sm italic text-n-30">-->
          <!--                (Language: {{ post.language }})-->
          <!--              </div>-->
          <!--            </template>-->
          <!--          </template>-->
          <div v-if="post.activity_identifier" class="text-sm">
            {{ post.activity_identifier }}
          </div>
          <div v-if="post.narrative" class="text-sm">{{ post.narrative }}</div>
        </div>
      </template>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import HoverText from '../../../components/HoverText.vue';

export default defineComponent({
  name: 'activity-element',
  components: { HoverText },
  props: {
    title: {
      type: String,
      required: true,
    },
    element_name: {
      type: String,
      required: true,
    },
    status: {
      type: String,
      required: false,
    },
    tooltip: {
      type: String,
      required: false,
    },
    content: {
      type: Array,
      required: true,
    },
    width: {
      type: String,
      required: false,
    },
  },
  setup(props) {
    let layout = 'basis-6/12';
    if (props.width === 'full') {
      layout = 'basis-full';
    }

    return { layout };
  },
});
</script>

<style lang="scss" scoped>
.activities__content--element {
  .edit-button {
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s ease;
  }

  &:hover .edit-button {
    opacity: 1;
    visibility: visible;
  }
}
</style>
