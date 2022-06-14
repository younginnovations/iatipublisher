<template>
  <div class="iati-list-table overflow-auto">
    <table>
      <thead>
        <tr class="bg-n-10">
          <th
            id="title"
            scope="col"
          >
            <a
              class="text-n-50 transition duration-500 hover:text-spring-50"
              href="#"
            >
              <span class="sorting-indicator descending">
                <svg-vue icon="descending-arrow" />
              </span>
              <span>Activity Title</span>
            </a>
          </th>
          <th
            id="date"
            scope="col"
          >
            <a
              class="text-n-50 transition duration-500 hover:text-spring-50"
              href="#"
            >
              <span class="sorting-indicator ascending">
                <svg-vue icon="ascending-arrow" />
              </span>
              <span>Updated On</span>
            </a>
          </th>
          <th
            id="status"
            scope="col"
          >
            <span class="hidden">Status</span>
          </th>
          <th
            id="publish"
            scope="col"
          >
            <span class="hidden">Status</span>
          </th>
          <th
            id="cb"
            scope="col"
          >
            <span class="">
              <svg-vue icon="checkbox" />
            </span>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="datum in props.data.data"
          :key="datum['id']"
          @click="goToDetail(datum['id'])"
        >
          <td class="title">
            <a
              :href="'/activities/' + datum['id']"
              class="hover:text-sp50 inline-flex max-w-screen-md items-start text-n-50 transition duration-500"
            >
              <svg-vue
                class="mr-3 mt-1 shrink-0 text-base text-spring-50"
                icon="approved-cloud"
              />
              <span class="ellipsis">{{
                datum['title'][0]['narrative'] ?? 'Untitled'
              }}</span>
            </a>
          </td>

          <td class="text-n-40">
            {{ formatDate(datum.created_at) }}
          </td>

          <td>
            <button
              class="inline-flex items-center text-n-40 transition duration-500 hover:text-spring-50"
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
              class="button primary-outline-btn w-20"
            >
              {{
                datum['status'] === 'ready_to_publish' ? 'Publish' : 'RePublish'
              }}
            </button>
          </td>

          <th
            class="check-column"
            @click="(e) => e.stopPropagation()"
          >
            <label
              class="sr-only"
              for=""
            >
              Select "{{ datum['title'][0]['narrative'] }}"
            </label>
            <label class="checkbox">
              <input
                v-model="state.selected"
                :value="datum.id"
                type="checkbox"
                @change="emitShowOrHide"
              >
              <span class="checkmark" />
            </label>
          </th>
        </tr>
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
      window.location.href = '/activities/' + id;
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

<style lang="scss">
.ellipsis {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  @apply overflow-hidden text-ellipsis;
}
</style>
