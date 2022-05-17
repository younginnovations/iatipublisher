<template>
  <div class="iati-list-table overflow-auto">
    <table class="">
      <thead>
        <tr class="bg-n-10">
          <th scope="col" id="title">
            <a
              href="#"
              class="text-n-50 transition duration-500 hover:text-spring-50"
            >
              <span class="sorting-indicator descending">
                <svg-vue icon="descending-arrow"></svg-vue>
              </span>
              <span>Activity Title</span>
            </a>
          </th>
          <th scope="col" id="date">
            <a
              href="#"
              class="text-n-50 transition duration-500 hover:text-spring-50"
            >
              <span class="sorting-indicator ascending">
                <svg-vue icon="ascending-arrow"></svg-vue>
              </span>
              <span>Updated On</span>
            </a>
          </th>
          <th scope="col" id="status">
            <span class="hidden">Status</span>
          </th>
          <th scope="col" id="publish">
            <span class="hidden">Status</span>
          </th>
          <th scope="col" id="cb">
            <span class="">
              <svg-vue icon="checkbox"></svg-vue>
            </span>
          </th>
        </tr>
      </thead>
      <tbody>
        <!--      Loop starts here-->

        <tr
          v-for="datum in props.data.data"
          :key="datum['id']"
          @click="goToDetail(datum['id'])"
        >
          <td class="title">
            <a
              :href="'/activities/' + datum['id']"
              class="hover:text-sp50 inline-flex items-start text-n-50 transition duration-500"
            >
              <svg-vue
                icon="approved-cloud"
                class="mr-3 mt-1 shrink-0 text-base text-spring-50"
              ></svg-vue>
              <span>{{ datum['title'][0]['narrative'] }}</span>
            </a>
          </td>

          <td class="text-n-40">{{ formatDate(datum.created_at) }}</td>

          <td>
            <button
              class="inline-flex items-center text-n-40 transition duration-500 hover:text-spring-50"
            >
              <span class="mr-1 text-base">
                <svg-vue icon="document-write"></svg-vue>
              </span>
              <span class="text-sm leading-relaxed">{{ datum['status'] }}</span>
            </button>
          </td>

          <td>
            <button
              class="button primary-outline-btn w-20"
              v-if="
                datum['status'] != 'draft' && datum['status'] != 'published'
              "
            >
              {{
                datum['status'] == 'ready_to_publish' ? 'Publish' : 'RePublish'
              }}
            </button>
          </td>

          <th class="check-column">
            <label class="sr-only" for="">
              Select "{{ datum['title'][0]['narrative'] }}"
            </label>
            <label class="checkbox">
              <input
                type="checkbox"
                :value="datum.id"
                v-model="state.selected"
                @change="emitShowOrHide"
              />
              <span class="checkmark"></span>
            </label>
          </th>
        </tr>

        <!--  Loop ends here  -->
      </tbody>
    </table>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive } from 'vue';
import moment from 'moment';

export default defineComponent({
  name: 'table-layout',
  components: {},
  emits: ['showOrHide'],
  props: {
    data: {
      type: [Object],
      required: true,
    },
  },
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

    function goToDetail(id: Number) {
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
