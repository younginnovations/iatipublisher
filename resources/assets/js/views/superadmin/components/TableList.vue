<template>
  <div>
    <div class="iati-list-table">
      <table>
        <thead>
          <tr class="bg-n-10">
            <th id="organisation_name" scope="col">
              <a
                class="text-n-50 transition duration-500 hover:text-spring-50"
                :class="
                  orderType === 'name'
                    ? sortingDirection()
                    : defaultSortDirection
                "
                :href="sortBy('name')"
              >
                <span class="sorting-indicator">
                  <svg-vue
                    :icon="`${
                      orderType === 'name'
                        ? sortingDirection()
                        : defaultSortDirection
                    }-arrow`"
                  />
                </span>
                <span>Organisation Name</span>
              </a>
            </th>
            <th id="activities" scope="col" style="width: 173px">
              <a
                class="text-n-50 transition duration-500 hover:text-spring-50"
                :class="
                  orderType === 'all_activities_count'
                    ? sortingDirection()
                    : defaultSortDirection
                "
                :href="sortBy('all_activities_count')"
              >
                <span class="sorting-indicator">
                  <svg-vue
                    :icon="`${
                      orderType === 'all_activities_count'
                        ? sortingDirection()
                        : defaultSortDirection
                    }-arrow`"
                  />
                </span>
                <span>Activities</span>
              </a>
            </th>
            <th id="updated_on" scope="col" style="width: 173px">
              <a
                class="text-n-50 transition duration-500 hover:text-spring-50"
                :class="
                  orderType === 'updated_at'
                    ? sortingDirection()
                    : defaultSortDirection
                "
                :href="sortBy('updated_at')"
              >
                <span class="sorting-indicator">
                  <svg-vue
                    :icon="`${
                      orderType === 'updated_at'
                        ? sortingDirection()
                        : defaultSortDirection
                    }-arrow`"
                  />
                </span>
                <span>Updated On</span>
              </a>
            </th>
            <th id="proxy" scope="col" style="width: 158px">
              <span></span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="organisationData.status === 'fetching'">
            <td colspan="4">Fetching Data...</td>
          </tr>
          <tr v-else-if="organisationData.status === 'empty'">
            <td colspan="4">No Data Available</td>
          </tr>
          <tr v-for="data in organisationData.data.data" v-else :key="data.id">
            <td>
              <div v-if="data.name" class="ellipsis relative">
                <span class="ellipsis overflow-hidden">
                  {{ data?.name[0]?.narrative ?? 'Name Missing' }}
                </span>
              </div>
              <div v-else>Name Missing</div>
              <div class="text-blue-40">{{ data?.user?.email }}</div>
            </td>
            <td class="text-n-40">
              {{ data.all_activities_count }} activities
            </td>
            <td class="text-n-40">
              {{ dateFormat(data.updated_at, 'DD MMMM, YYYY') }}
            </td>
            <td>
              <BtnComponent
                text="proxy"
                type="outline"
                icon="smile"
                @click="proxyUser(data?.user?.id)"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="mt-6">
      <Pagination
        v-if="organisationData.data && organisationData.data.last_page > 1"
        :data="organisationData.data"
        @fetch-activities="fetchOrganisation"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, onMounted, inject, ref } from 'vue';
import axios from 'axios';

import dateFormat from 'Composable/dateFormat';

import BtnComponent from 'Components/ButtonComponent.vue';
import Pagination from 'Components/TablePagination.vue';

// inject
interface ToastInterface {
  visibility: boolean;
  message: string;
  type: boolean;
}
const toastMessage = inject('toastData') as ToastInterface;

interface LoaderInterface {
  status: boolean;
  text: string;
}

const loader = inject('loader') as LoaderInterface;

//typeface
interface organizationInterface {
  data: oDataInterface;
  status: string;
}

interface oDataInterface {
  data: {
    id: number;
    name: {
      narrative: string;
    }[];
    organization_url: string;
    user: {
      email: string;
      id: number;
    };
    all_activities_count: number;
    updated_at: Date;
  }[];
  last_page: number;
}

// reactivity
let organisationData: organizationInterface = reactive({
  data: {} as oDataInterface,
  status: 'fetching',
});

//lifecycle
onMounted(async () => {
  fetchOrganisation(1);
});

/**
 * Fetching organization list
 *
 */
const currentURL = window.location.href;
const fetchOrganisation = (active_page: number) => {
  let queryString = '';
  if (currentURL.includes('?')) {
    queryString = window.location.search;
  }
  const endpoint = `/list-organisations/page/${active_page}${queryString}`;

  axios.get(endpoint).then((res) => {
    const response = res.data;

    if (response.success) {
      if (response.data.data.length === 0) {
        organisationData.status = 'empty';
      } else {
        organisationData.status = 'success';
        organisationData.data = response.data;
      }
    }
  });
};

/**
 * Proxy User
 */
// display/hide validator loader
const proxyUser = (id: number) => {
  loader.status = true;
  loader.text = 'Proxy Login';
  const endpoint = `/proxy-organisation/${id}`;

  axios.get(endpoint).then((res) => {
    const response = res.data;

    if (response.success) {
      setTimeout(() => {
        window.location.replace('/activities');
      }, 1000);
    } else {
      loader.status = false;
      toastMessage.message = response.message;
      toastMessage.type = response.success;
    }
  });
};

/**
 * Sorting By update on
 */
let query = '',
  defaultSortDirection = 'ascending',
  sortDirection = 'desc';

let orderType = ref('');

const queryString = window.location.search,
  urlParams = new URLSearchParams(queryString);
orderType.value = urlParams.get('orderBy') ?? '';

const sortingDirection = () => {
  return sortDirection === 'asc' ? 'descending' : 'ascending';
};

const sortBy = (order) => {
  if (currentURL.includes('?')) {
    query = urlParams.get('q') ?? '';
    sortDirection = urlParams.get('direction') === 'desc' ? 'asc' : 'desc';
  }

  return `?q=${query}&orderBy=${order}&direction=${sortDirection}`;
};
</script>
