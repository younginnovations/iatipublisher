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
            class="edit-button mr-2.5 flex items-center text-xs font-bold uppercase"
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
            <span v-if="post.type === '1'">General Description</span>
            <span v-else-if="post.type === '2'">Objective Description</span>
            <span v-else-if="post.type === '3'">Target Groups Description</span>
            <span v-else>Other Description</span>
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
            <span v-if="post.type === '1'">Planned start date:</span>
            <span v-else-if="post.type === '2'">Actual start date:</span>
            <span v-else-if="post.type === '3'">Planned start date:</span>
            <span v-else>Actual end date:</span>
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
              <span v-if="post.relationship_type === '1'">Parent</span>
              <span v-else-if="post.relationship_type === '2'">Child</span>
              <span v-else-if="post.relationship_type === '3'">Sibling</span>
              <span v-else-if="post.relationship_type === '4'">Co-funded</span>
              <span v-else>Third Party</span>
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
              <span v-if="post.condition_type === '1'">Policy Condition:</span>
              <span v-else-if="post.condition_type === '2'"
                >Performance Condition:</span
              >
              <span v-else>Fiduciary Condition</span>
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
            <span v-if="data.content === 1">Pipeline/identification</span>
            <span v-else-if="data.content === 2">Implementation</span>
            <span v-else-if="data.content === 3">Finalisation</span>
            <span v-else-if="data.content === 4">Closed</span>
            <span v-else-if="data.content === 5">Cancelled</span>
            <span v-else>Suspended</span>
          </template>

          <template v-else-if="title === 'activity_scope'">
            <span v-if="data.content === 1">Global</span>
            <span v-else-if="data.content === 2">Regional</span>
            <span v-else-if="data.content === 3">Multi-national</span>
            <span v-else-if="data.content === 4">National</span>
            <span v-else-if="data.content === 5"
              >Sub-national: Multi-first-level administrative areas</span
            >
            <span v-else-if="data.content === 6"
              >Sub-national: Single first-level administrative area</span
            >
            <span v-else-if="data.content === 7"
              >Sub-national: Single second-level administrative area</span
            >
            <span v-else>Single location</span>
          </template>

          <template v-else-if="title === 'collaboration_type'">
            <span v-if="data.content === 1">Bilateral</span>
            <span v-else-if="data.content === 2">Multilateral (inflows)</span>
            <span v-else-if="data.content === 3"
              >Bilateral, core contributions to NGOs and other private bodies /
              PPPs</span
            >
            <span v-else-if="data.content === 4">Multilateral outflows</span>
            <span v-else-if="data.content === 6">Private sector outflows</span>
            <span v-else-if="data.content === 7"
              >Bilateral, ex-post reporting on NGOs' activities funded through
              core contributions</span
            >
            <span v-else>Bilateral, triangular co-operation</span>
          </template>

          <template v-else-if="title === 'default_flow_type'">
            <span v-if="data.content === 10">ODA</span>
            <span v-else-if="data.content === 20">OOF</span>
            <span v-else-if="data.content === 21">Non-export credit OOF</span>
            <span v-else-if="data.content === 22"
              >Officially supported export credits</span
            >
            <span v-else-if="data.content === 30">Private grants</span>
            <span v-else-if="data.content === 35">Private market</span>
            <span v-else-if="data.content === 36"
              >Private Foreign Direct Investment</span
            >
            <span v-else-if="data.content === 37"
              >Other Private flows at market terms</span
            >
            <span v-else-if="data.content === 40">Non flow</span>
            <span v-else>Other flows</span>
          </template>

          <template v-else-if="title === 'default_tied_status'">
            <span v-if="data.content === 3">Partially tied</span>
            <span v-else-if="data.content === 4">Tied</span>
            <span v-else>Untied</span>
          </template>

          <template v-else-if="title === 'capital_spend'">
            <span>{{ data.content }}%</span>
          </template>

          <template v-else-if="title === 'default_finance_type'">
            <span>{{ data.content }}</span>
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
