<template>
  <div :class="layout" class="activities__content--element px-3 py-3">
    <div class="rounded-lg bg-white p-4">
      <div class="mb-4 flex">
        <div class="title flex grow">
          <template
            v-if="
              title === 'reporting_org' ||
              title === 'default_tied_status' ||
              title === 'crs_add' ||
              title === 'fss'
            "
          >
            <svg-vue
              class="mr-1.5 text-xl text-bluecoral"
              icon="activity-elements/building"
            ></svg-vue>
          </template>
          <template v-else-if="title === 'identifier'">
            <svg-vue
              class="mr-1.5 text-xl text-bluecoral"
              icon="activity-elements/iati_identifier"
            ></svg-vue>
          </template>
          <template v-else>
            <svg-vue
              :icon="'activity-elements/' + title"
              class="mr-1.5 text-xl text-bluecoral"
            ></svg-vue>
          </template>
          <div class="title text-sm font-bold">{{ title }}</div>
          <div
            v-if="'completed' in data"
            :class="{
              'text-spring-50': data.completed === true,
              'text-crimson-50': data.completed === false,
            }"
            class="status ml-2.5 flex text-xs leading-5"
          >
            <b class="mr-2 text-base leading-3">.</b>
            <span v-if="data.completed">completed</span>
            <span v-else>not completed</span>
          </div>
        </div>
        <div class="icons flex">
          <a
            class="mr-2.5 flex items-center text-xs font-bold uppercase"
            :href="`/activities/1/${title}`"
          >
            <svg-vue class="mr-0.5 text-base" icon="edit"></svg-vue>
            <span>Edit</span>
          </a>
          <template v-if="'core' in data">
            <svg-vue v-if="data.core" class="mr-1.5" icon="core"></svg-vue>
          </template>
          <HoverText
            v-if="tooltip"
            :hover_text="tooltip"
            class="text-n-40"
          ></HoverText>
        </div>
      </div>
      <div class="divider mb-4 h-px w-full bg-n-20"></div>
      <template v-if="title === 'title'">
        <!-- Title content -->
        <div
          v-for="(post, index) in content"
          :key="index"
          class="title-content"
        >
          <div
            v-if="post.language"
            class="language mb-1.5 text-sm italic text-n-30"
          >
            (Language: {{ post.language }})
          </div>
          <div v-if="post.narrative" class="text-sm">
            {{ post.narrative }}
          </div>
        </div>
      </template>

      <template v-if="title === 'identifier'">
        <!-- iati identifier -->
        <div class="identifier-content">
          <div v-if="content.activity_identifier" class="mb-4 text-sm">
            {{ content.activity_identifier }}
          </div>
          <div v-if="content.iati_identifier_text" class="text-sm">
            {{ content.iati_identifier_text }}
          </div>
        </div>
      </template>
      <template v-else>
        {{ content }}
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
    data: {
      type: Object,
      required: true,
    },
    title: {
      type: String,
      required: true,
    },
    tooltip: {
      type: String,
      required: false,
    },
    content: {
      type: Object || Array,
      required: true,
    },
    width: {
      type: String,
      required: false,
    },
  },
  setup(props) {
    const status = '';
    let layout = 'basis-6/12';
    if (props.width === 'full') {
      layout = 'basis-full';
    }

    return { layout, status };
  },
});
</script>

<style lang="scss" scoped>
.activities__content--element > div {
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
