<template>
  <div class="iati-list-table">
    <table>
      <thead>
        <tr class="bg-n-10">
          <th id="title" scope="col">
            <span>Activity Title</span>
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
            <span class="hidden">Publish</span>
          </th>
          <th id="cb" scope="col">
            <span class="">
              <svg-vue icon="checkbox" />
            </span>
          </th>
        </tr>
      </thead>
      <tbody v-if="data.total > 0">
        <tr v-for="datum in props.data.data" :key="datum['id']">
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
                  :href="'/activity/' + datum['id']"
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
                v-model="state.selected"
                :value="datum.id"
                type="checkbox"
                @change="emitShowOrHide"
              />
              <span class="checkmark" />
            </label>
          </th>
        </tr>
      </tbody>
      <tbody v-else>
        <td colspan="5" class="text-center">Activities not found</td>
      </tbody>
    </table>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive } from 'vue';
import moment from 'moment';

export default defineComponent({
  name: 'TableLayout',
  components: {},
  props: {
    data: {
      type: [Object],
      required: true,
    },
  },
  emits: ['showOrHide'],
  setup(props, { emit }) {
    const state = reactive({
      selected: [],
    });

    const emitShowOrHide = () => {
      emit('showOrHide', state.selected);
    };

    function formatDate(date: Date) {
      return moment(date).fromNow();
    }

    function goToDetail(id: number) {
      window.location.href = '/activity/' + id;
    }

    return {
      state,
      emitShowOrHide,
      props,
      formatDate,
      goToDetail,
    };
  },
});
</script>
