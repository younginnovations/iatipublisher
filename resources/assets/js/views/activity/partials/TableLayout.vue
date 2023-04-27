<template>
  <div class="iati-list-table mb-10">
    <table>
      <thead>
        <tr class="bg-n-10">
          <th id="title" scope="col">
            <span>Activity Title</span>
          </th>
          <th id="publishing-progress" scope="col" class="progress-bar-header">
            <div class="">Publishing Progress</div>
          </th>
          <th id="date" scope="col">
            <a
              class="text-n-50 transition duration-500 hover:text-spring-50"
              :href="sortByDateUrl()"
            >
              <span class="sorting-indicator" :class="sortingDirection()">
                <svg-vue :icon="`${sortingDirection()}-arrow`" />
              </span>
              <span>Updated On</span>
            </a>
          </th>
          <th id="status" scope="col">
            <span class="hidden">Status</span>
          </th>
          <th id="publish" scope="col">
            <span class="hidden">Publish</span>
          </th>
          <th id="cb" scope="col">
            <span
              class="cursor-pointer"
              @click="toggleSelectAll(data.data, selectAllValue)"
            >
              <svg-vue icon="checkbox" />
            </span>
          </th>
        </tr>
      </thead>
      <tbody v-if="data.total > 0">
        <tr
          v-for="datum in data.data"
          :key="datum['id']"
          :class="{
            'already-published':
              datum['linked_to_iati'] && datum['status'] === 'draft',
          }"
        >
          <td class="title">
            <div
              class="flex items-start transition duration-500 hover:text-spring-50"
            >
              <PreviouslyPublished
                v-if="datum['linked_to_iati'] && datum['status'] === 'draft'"
                class="absolute top-0 left-0"
              />
              <div class="ellipsis relative w-full">
                <a
                  :href="'/activity/' + datum['id']"
                  class="ellipsis w-full !max-w-full overflow-hidden text-n-50"
                  >{{
                    datum['default_title_narrative'] &&
                    datum['default_title_narrative'] !== ''
                      ? datum['default_title_narrative']
                      : 'Untitled'
                  }}</a
                >
                <div class="w-52">
                  <span class="ellipsis__title--hover">{{
                    datum['default_title_narrative'] &&
                    datum['default_title_narrative'] !== ''
                      ? datum['default_title_narrative']
                      : 'Untitled'
                  }}</span>
                </div>
              </div>
            </div>
          </td>

          <td class="text-n-40">
            <div class="progress-bar-parent">
              <div class="progress-bar-wrapper">
                <div class="progress-bar-container bg-spring-10">
                  <div
                    class="progress-bar-fill bg-spring-50"
                    :style="{ width: datum['complete_percentage'] + '%' }"
                  ></div>
                </div>
              </div>
              <div class="progress-bar-number">
                <span class="text-xs font-semibold text-spring-50"
                  >{{ datum['complete_percentage'] }}%</span
                >
              </div>
            </div>
          </td>

          <td class="text-n-40">
            {{ formatDate(datum.updated_at) }}
          </td>

          <td>
            <button
              class="inline-flex items-center transition duration-500 hover:text-spring-50"
              :class="{
                'text-n-40': datum['status'] === 'draft',
                'text-spring-50': datum['status'] === 'published',
              }"
            >
              <span class="mr-1 text-base">
                <svg-vue
                  :icon="
                    datum['status'] === 'draft' ? 'document-write' : 'tick'
                  "
                />
              </span>
              <span class="text-sm leading-relaxed">{{ datum['status'] }}</span>
            </button>
          </td>

          <td>
            <div class="flex flex-wrap gap-2">
              <UnPublish
                v-if="datum.linked_to_iati"
                type="outline"
                :activity-id="datum['id']"
              />

              <Publish
                v-if="datum['status'] !== 'published'"
                :linked-to-iati="datum.linked_to_iati"
                :status="datum.status"
                :core-completed="datum.coreCompleted"
                type="outline"
                :activity-id="datum['id']"
              />
            </div>
          </td>

          <th
            class="check-column"
            @click="(event: Event) => event.stopPropagation()"
          >
            <label class="sr-only" for="">
              Select "{{ datum['default_title_narrative'] }}"
            </label>
            <label class="checkbox">
              <input
                v-model="store.state.selectedActivities"
                :value="datum.id"
                type="checkbox"
              />
              <span class="checkmark" />
            </label>
          </th>
        </tr>
      </tbody>
      <tbody v-else>
        <td v-if="loader" colspan="5" class="text-center">
          <div colspan="5" class="spin"></div>
        </td>
        <td v-else colspan="5" class="text-center">Activities not found</td>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import moment from 'moment';
import { useToggle } from '@vueuse/core';

// Vuex Store
import { useStore } from 'Store/activities/index';

import PreviouslyPublished from 'Components/status/PreviouslyPublished.vue';
import Publish from 'Components/buttons/PublishButton.vue';
import UnPublish from 'Components/buttons/UnPublishButton.vue';
// import Shimmer from "Components/ShimmerLoading.vue";

const [selectAllValue, selectAllToggle] = useToggle();

defineProps({
  data: { type: Object, required: true },
  loader: { type: Boolean, required: false },
});

const store = useStore();

function formatDate(date: Date) {
  return moment(date).fromNow();
}

function toggleSelectAll(
  activities: { [x: string]: { id: number } },
  selectAllValue: boolean
) {
  if (!selectAllValue) {
    let ids = [] as number[];
    for (const datum in activities) {
      ids.push(activities[datum].id);
    }
    store.dispatch('updateSelectedActivities', ids);
  } else {
    store.dispatch('updateSelectedActivities', []);
  }
  selectAllToggle();
}

//Sorting by update_at
const currentURL = window.location.href;
let query = '',
  direction = 'asc';

const sortingDirection = () => {
  return direction === 'asc' ? 'descending' : 'ascending';
};

const sortByDateUrl = () => {
  if (currentURL.includes('?')) {
    const queryString = window.location.search,
      urlParams = new URLSearchParams(queryString);
    query = urlParams.get('q') ?? '';
    direction = urlParams.get('direction') === 'desc' ? 'asc' : 'desc';
  }

  return `?q=${query}&orderBy=updated_at&direction=${direction}`;
};
</script>
<style scoped>
@keyframes spinner {
  0% {
    transform: translate3d(-50%, -50%, 0) rotate(0deg);
  }
  100% {
    transform: translate3d(-50%, -50%, 0) rotate(360deg);
  }
}

.spin::before {
  animation: 1.5s linear infinite spinner;
  animation-play-state: inherit;
  border: solid 3px #cfd0d1;
  border-bottom-color: grey;
  border-radius: 50%;
  content: '';
  height: 20px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate3d(-50%, -50%, 0);
  width: 20px;
  will-change: transform;
}
.spin {
  height: 40px;
  position: relative;
  width: 100%;
  margin: auto;
}
</style>
