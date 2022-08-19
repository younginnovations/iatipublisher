<template>
  <div class="iati-list-table">
    <table>
      <thead>
        <tr class="bg-n-10">
          <th id="title" scope="col">
            <a
              class="transition duration-500 text-n-50 hover:text-spring-50"
              href="#"
            >
              <span class="sorting-indicator descending">
                <svg-vue icon="descending-arrow" />
              </span>
              <span>Activity Title</span>
            </a>
          </th>
          <th id="date" scope="col">
            <a
              class="transition duration-500 text-n-50 hover:text-spring-50"
              href="#"
            >
              <span class="sorting-indicator ascending">
                <svg-vue icon="ascending-arrow" />
              </span>
              <span>Updated On</span>
            </a>
          </th>
          <th id="status" scope="col">
            <span class="hidden">Status</span>
          </th>
          <th id="publish" scope="col">
            <span class="hidden">Status</span>
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
      <tbody>
        <tr v-for="datum in data.data" :key="datum['id']">
          <td class="title">
            <div
              class="inline-flex items-start transition duration-500 hover:text-spring-50"
            >
              <svg-vue
                class="mt-1 mr-3 text-base shrink-0 text-spring-50"
                icon="approved-cloud"
              ></svg-vue>
              <div class="relative ellipsis">
                <a
                  :href="'/activities/' + datum['id']"
                  class="overflow-hidden ellipsis text-n-50"
                  >{{ datum['title'][0]['narrative'] ?? 'Untitled' }}</a
                >
                <div class="w-52">
                  <span class="ellipsis__title--hover">{{
                    datum['title'][0]['narrative'] ?? 'Untitled'
                  }}</span>
                </div>
              </div>
            </div>
          </td>

          <td class="text-n-40">
            {{ formatDate(datum.created_at) }}
          </td>

          <td>
            <button
              class="inline-flex items-center transition duration-500 text-n-40 hover:text-spring-50"
            >
              <span class="mr-1 text-base">
                <svg-vue icon="document-write" />
              </span>
              <span class="text-sm leading-relaxed">{{ datum['status'] }}</span>
            </button>
          </td>

          <td>
            <button
              v-if="
                datum['status'] !== 'draft' && datum['status'] !== 'published'
              "
              class="w-20 button primary-outline-btn"
            >
              {{
                datum['status'] === 'ready_to_publish' ? 'Publish' : 'RePublish'
              }}
            </button>
          </td>

          <th class="check-column" @click="(e) => e.stopPropagation()">
            <label class="sr-only" for="">
              Select "{{ datum['title'][0]['narrative'] }}"
            </label>
            <label class="checkbox">
              <input
                v-model="store.state.selectedActivities"
                :value="datum.id"
                type="checkbox"
                @change="emitShowOrHide"
              />
              <span class="checkmark" />
            </label>
          </th>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';
import moment from 'moment';
import { useToggle } from '@vueuse/core';

// Vuex Store
import { useStore } from 'Store/activities/index';

const [selectAllValue, selectAllToggle] = useToggle();

defineProps({
  data: { type: Object, required: true },
});

const emit = defineEmits(['showOrHide']);

const store = useStore();

const emitShowOrHide = () => {
  emit('showOrHide', store.state.selectedActivities);
};

function formatDate(date: Date) {
  return moment(date).fromNow();
}

function toggleSelectAll(
  activities: { [x: string]: { id: number } },
  selectAllValue: boolean
) {
  if (!selectAllValue) {
    let ids = [];
    for (const datum in activities) {
      ids.push(activities[datum].id);
    }
    store.dispatch('updateSelectedActivities', ids);
  } else {
    store.dispatch('updateSelectedActivities', []);
  }
  selectAllToggle();
}
</script>
