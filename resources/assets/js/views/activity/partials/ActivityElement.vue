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
            :href="`/activities/1/${title}`"
            class="
              edit-button
              mr-2.5
              flex
              items-center
              text-xs
              font-bold
              uppercase
            "
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
        <div v-for="(post, i) in data.content" :key="i" class="title-content">
          <div class="language mb-1.5 text-sm italic text-n-30">
            (Language: {{ post.language }})
          </div>
          <div v-if="post.narrative" class="text-sm">
            {{ post.narrative }}
          </div>
          <div v-if="i !== data.content.length - 1" class="mb-4"></div>
        </div>
      </template>

      <template v-else-if="title === 'identifier'">
        <div class="identifier-content">
          <div v-if="data.content.activity_identifier" class="mb-4 text-sm">
            {{ data.content.activity_identifier }}
          </div>
          <div v-if="data.content.iati_identifier_text" class="text-sm">
            {{ data.content.iati_identifier_text }}
          </div>
        </div>
      </template>

      <template v-else-if="title === 'description'">
        <div
          v-for="(post, key, i) in data.content"
          :key="key"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="description-type mb-4 text-sm font-bold">
            {{ props.types.descriptionType[post.type] }}
          </div>
          <div
            v-for="(item, i) in post.narrative"
            :key="i"
            :class="{ 'mb-4': i !== post.narrative.length - 1 }"
            class="description-content"
          >
            <div class="language mb-1.5 text-sm italic text-n-30">
              (Language: {{ item.language }})
            </div>
            <div v-if="item.narrative" class="text-sm">
              {{ item.narrative }}
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'activity_date'">
        <div
          v-for="(post, key, i) in data.content"
          :key="key"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="date-type mb-4 flex gap-1 text-sm font-bold">
            {{ props.types.activityDate[post.type] }}
            <span class="text-sm font-normal italic text-n-30">{{
              post.date
            }}</span>
          </div>
          <div
            v-for="(item, i) in post.narrative"
            :key="i"
            :class="{ 'mb-4': i !== post.narrative.length - 1 }"
            class="date-content"
          >
            <div class="language mb-1.5 text-sm italic text-n-30">
              (Language: {{ item.language }})
            </div>
            <div v-if="item.narrative" class="text-sm">
              {{ item.narrative }}
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'recipient_country'">
        <div
          v-for="(post, key, i) in data.content"
          :key="key"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="recipient_country-code mb-4 flex gap-1 text-sm font-bold">
            <span>{{ post.country_code }}:</span>
            <span
              v-if="post.percentage"
              class="text-sm font-normal italic text-n-30"
              >{{ post.percentage }}%</span
            >
          </div>

          <div
            v-for="(item, i) in post.narrative"
            :key="i"
            :class="{ 'mb-4': i !== post.narrative.length - 1 }"
            class="recipient_country-content"
          >
            <div class="language mb-1.5 text-sm italic text-n-30">
              (Language: {{ item.language }})
            </div>
            <div v-if="item.narrative" class="text-sm">
              {{ item.narrative }}
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'related_activity'">
        <div
          v-for="(post, key, i) in data.content"
          :key="key"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="related-content">
            <div class="type mb-1.5 text-sm italic text-n-30">
              {{ props.types.relatedActivityType[post.relationship_type] }}
            </div>
            <div class="text-sm">@ref: {{ post.activity_identifier }}</div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'legacy_data'">
        <div
          v-for="(post, key, i) in data.content"
          :key="key"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="related-content">
            <div class="text-sm">@name: {{ post.name }}</div>
            <div class="text-sm">@value: {{ post.value }}</div>
            <div class="text-sm">
              @iati-equivalent: {{ post.iati - equivalent }}
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'conditions'">
        <div class="date-type mb-4 flex gap-1 text-sm font-bold">
          <span>Attached:</span>
          <span class="text-sm font-normal italic text-n-30">
            <span v-if="data.content.condition_attached === '0'">No</span>
            <span v-else-if="data.content.condition_attached === '1'">Yes</span>
          </span>
        </div>
        <div class="condition-contents">
          <div
            v-for="(post, key, i) in data.content.condition"
            :key="key"
            :class="{ 'mb-4': key !== data.content.condition.length - 1 }"
          >
            <div class="mb-4 text-sm font-bold">
              {{ props.types.conditionType[post.condition_type] }}
            </div>
            <div
              v-for="(item, i) in post.narrative"
              :key="i"
              :class="{ 'mb-4': i !== post.narrative.length - 1 }"
              class="description-content"
            >
              <div class="language mb-1.5 text-sm italic text-n-30">
                (Language: {{ item.language }})
              </div>
              <div v-if="item.narrative" class="text-sm">
                {{ item.narrative }}
              </div>
            </div>
          </div>
        </div>
      </template>

      <template v-else>
        <div class="content text-sm">
          <template v-if="title === 'activity_status'">
            {{ props.types.activityStatus[data.content] }}
          </template>

          <template v-else-if="title === 'activity_scope'">
            {{ props.types.activityScope[data.content] }}
          </template>

          <template v-else-if="title === 'collaboration_type'">
            {{ props.types.collaborationType[data.content] }}
          </template>

          <template v-else-if="title === 'default_flow_type'">
            {{ props.types.flowType[data.content] }}
          </template>

          <template v-else-if="title === 'default_tied_status'">
            {{ props.types.tiedStatus[data.content] }}
          </template>

          <template v-else-if="title === 'capital_spend'">
            <span>{{ data.content }}%</span>
          </template>

          <template v-else-if="title === 'default_finance_type'">
            <span> {{ props.types.financeType[data.content] }}</span>
          </template>

          <template v-else>
            <span>No content</span>
          </template>
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
    width: {
      type: String,
      required: false,
    },
    types: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const status = '';
    let layout = 'basis-6/12';
    if (props.width === 'full') {
      layout = 'basis-full';
    }

    return { layout, status, props };
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
