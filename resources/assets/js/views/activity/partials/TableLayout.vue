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

        <!--      ===================================-->
        <!--      First item with "Draft" status-->
        <!--      =======================================-->
        <tr>
          <td class="title">
            <a
              href="#"
              class="hover:text-sp50 inline-flex items-start text-n-50 transition duration-500"
            >
              <svg-vue
                icon="approved-cloud"
                class="mr-3 mt-1 shrink-0 text-base text-spring-50"
              ></svg-vue>
              <span>EU-Angola Dialogue Facility</span>
            </a>
          </td>

          <td class="text-n-40">2 days ago</td>

          <td>
            <button
              class="inline-flex items-center text-n-40 transition duration-500 hover:text-spring-50"
            >
              <span class="mr-1 text-base">
                <svg-vue icon="document-write"></svg-vue>
              </span>
              <span class="text-sm leading-relaxed">Draft</span>
            </button>
          </td>

          <td></td>

          <th class="check-column">
            <label class="sr-only" for="">
              Select "EU-Angola Dialogue Facility"
            </label>
            <label class="checkbox">
              <input
                type="checkbox"
                :value="1"
                v-model="state.selected"
                @change="showOrHide(state.selected)"
              />
              <span class="checkmark"></span>
            </label>
          </th>
        </tr>

        <!--      ========================================    -->
        <!--      Second item with "Ready to Publish" button  -->
        <!--      ============================================-->
        <tr>
          <td class="text-n-50">
            <a
              href="#"
              class="hover:text-sp50 inline-flex items-start text-n-50 transition duration-500"
            >
              <svg-vue
                icon="approved-cloud"
                class="mr-3 mt-1 shrink-0 text-base text-spring-50"
              ></svg-vue>
              <span
                >Support Program on Public Finance Management and Financial
                Sector reform</span
              >
            </a>
          </td>

          <td class="text-n-40">2 days ago</td>

          <td>
            <button
              class="inline-flex items-center text-n-40 transition duration-500 hover:text-spring-50"
            >
              <span class="mr-1 text-base">
                <svg-vue icon="tick"></svg-vue>
              </span>
              <span class="text-sm leading-relaxed">Ready to publish</span>
            </button>
          </td>

          <td>
            <button class="button primary-outline-btn w-20">Publish</button>
          </td>

          <th class="check-column">
            <label class="sr-only" for="">
              Select "Support Program on Public Finance Management and Financial
              Sector reform"
            </label>
            <label class="checkbox">
              <input
                type="checkbox"
                :value="2"
                v-model="state.selected"
                @change="showOrHide(state.selected)"
              />
              <span class="checkmark"></span>
            </label>
          </th>
        </tr>

        <!--      ========================================-->
        <!--        Third item with "Published" Status-->
        <!--      ============================================-->
        <tr>
          <td class="text-n-50">
            <a
              href="#"
              class="hover:text-sp50 inline-flex items-start text-n-50 transition duration-500"
            >
              <svg-vue
                icon="tick"
                class="mr-3 mt-1 shrink-0 text-base text-spring-50"
              ></svg-vue>
              <span
                >UNFPA Angola Improved national population data systems to map
                and address inequalities; to advance the achievement of the
                Sustainable Development Goals and the commitments of the
                Programme of Action of the International Conference on
                Population and Development; and to strengthen interventions in
                humanitarian crises activities</span
              >
            </a>
          </td>

          <td class="text-n-40">2 days ago</td>

          <td>
            <button
              class="inline-flex items-center text-n-40 transition duration-500 hover:text-spring-50"
            >
              <span class="mr-1 text-base text-spring-50">
                <svg-vue icon="tick"></svg-vue>
              </span>
              <span class="text-sm leading-relaxed">Published</span>
            </button>
          </td>

          <td></td>

          <th class="check-column">
            <label class="sr-only" for="">
              Select "UNFPA Angola Improved national population data systems to
              map and address inequalities; to advance the achievement of the
              Sustainable Development Goals and the commitments of the Programme
              of Action of the International Conference on Population and
              Development; and to strengthen interventions in humanitarian
              crises activities"
            </label>
            <label class="checkbox">
              <input
                type="checkbox"
                :value="3"
                v-model="state.selected"
                @change="showOrHide(state.selected)"
              />
              <span class="checkmark"></span>
            </label>
          </th>
        </tr>

        <!--      ========================================-->
        <!--        Fourth item with "Changes made" Status-->
        <!--      ============================================-->
        <tr>
          <td class="text-n-50">
            <a
              href="#"
              class="hover:text-sp50 inline-flex items-start text-n-50 transition duration-500"
            >
              <svg-vue
                icon="approved-cloud"
                class="mr-3 mt-1 text-base text-spring-50"
              ></svg-vue>
              <span>Programme in support of Higher Education</span>
            </a>
          </td>

          <td class="text-n-40">2 days ago</td>

          <td>
            <button
              class="inline-flex items-center text-n-40 transition duration-500 hover:text-spring-50"
            >
              <span class="mr-1 text-base">
                <svg-vue icon="history"></svg-vue>
              </span>
              <span class="text-sm leading-relaxed">Changes made</span>
            </button>
          </td>

          <td>
            <button class="button primary-outline-btn w-20">RePublish</button>
          </td>

          <th class="check-column">
            <label class="sr-only" for="">
              Select "Programme in support of Higher Education"
            </label>
            <label class="checkbox">
              <input
                type="checkbox"
                :value="4"
                v-model="state.selected"
                @change="showOrHide(state.selected)"
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

export default defineComponent({
  name: 'table-layout',
  components: {},
  props: {
    showOrHide: Function,
  },
  setup() {
    const state = reactive({
      selected: [],
    });

    return { state };
  },
});
</script>
