<template>
  <div class="filters mb-4 flex flex-wrap justify-between gap-2">
    <!--Filter options start-->
    <div class="select filters inline-flex items-center space-x-2">
      <svg-vue class="w-10 text-lg" icon="funnel" />
      <span class="organization">
        <Multiselect
          id="country-filter"
          v-model="filter.country"
          placeholder="COUNTRY"
          mode="multiple"
          :searchable="true"
          :options="countries"
          :taggable="true"
          :close-on-select="false"
          :clear-on-select="false"
          :hide-selected="false"
          label="country"
        />
      </span>
      <span class="organization">
        <Multiselect
          id="setup-completeness"
          v-model="filter.completeness"
          placeholder="SETUP COMPLETENESS"
          :options="setupCompleteness"
          :taggable="true"
          :close-on-select="false"
          :clear-on-select="false"
          :hide-selected="false"
          label="setupCompleteness"
        />
      </span>
      <span class="organization">
        <Multiselect
          id="setup-completeness"
          v-model="filter.registrationType"
          placeholder="REGISTRATION TYPE"
          :options="registrationTypes"
          :taggable="true"
          :close-on-select="false"
          :clear-on-select="false"
          :hide-selected="false"
          label="registrationType"
        />
      </span>

      <!--Multiselect with search -->
      <div class="organization multiselect-lookalike">
        <div
          class="flex justify-between align-middle text-xs font-bold uppercase text-bluecoral"
          style="width: 100%; height: 100%"
          @click="toggleShowMultiSelect"
        >
          <span style="height: fit-content">Publisher Type</span>
          <span
            :class="rotateClass"
            style="height: fit-content; font-size: 20px; margin-top: -2px"
          >
            <svg-vue icon="arrow-down"></svg-vue>
          </span>
        </div>
        <div v-show="showMultiSelectWithSearch" class="multiselect-wrapper">
          <MultiSelectWithSearch
            header="Publisher Type"
            :list-items="props.publisherTypes"
            @change-selected-publisher="setSelectedPublisher"
          ></MultiSelectWithSearch>
        </div>
      </div>

      <span class="organization">
        <Multiselect
          id="dataLicense"
          v-model="filter.dataLicense"
          :options="dataLicenses"
          placeholder="DATA LICENSE"
          mode="multiple"
          :taggable="true"
          :close-on-select="false"
          :clear-on-select="false"
          :hide-selected="false"
          label="dataLicense"
        />
      </span>
      <span></span>
    </div>
    <!--Filter options end-->

    <!--Date range start-->
    <div class="h-[38px] px-4">
      <DateRangeWidget
        :dropdown-range="dropdownRange"
        @trigger-set-date-range="setDateRangeDate"
        @trigger-set-date-type="setDateType"
      />
    </div>
    <!--Date range start-->
  </div>

  <!--Filter tag pills start-->
  <div
    v-if="isFilterApplied"
    class="mb-4 flex max-w-full flex-wrap items-center gap-2"
  >
    <span class="text-sm font-bold uppercase text-n-40">Filtered by: </span>

    <span v-if="filter.country" class="inline-flex flex-wrap gap-2">
      <span
        v-for="(item, index) in filter.country"
        :key="index"
        class="flex items-center space-x-1 rounded-full border border-n-30 py-1 px-2 text-xs"
      >
        <span class="text-n-40">Country:</span>
        <span
          class="max-w-[500px] overflow-x-hidden text-ellipsis whitespace-nowrap"
          >{{ item }}</span
        >
        <svg-vue
          class="mx-2 mt-1 cursor-pointer text-xs"
          icon="cross"
          @click="filter.country.splice(index, 1)"
        />
      </span>
    </span>

    <span v-if="filter.completeness" class="inline-flex flex-wrap gap-2">
      <span
        class="flex items-center space-x-1 rounded-full border border-n-30 py-1 px-2 text-xs"
      >
        <span class="text-n-40">Setup Completeness:</span>
        <span
          class="max-w-[500px] overflow-x-hidden text-ellipsis whitespace-nowrap"
          >{{ filter.completeness }}</span
        >
        <svg-vue
          class="mx-2 mt-1 cursor-pointer text-xs"
          icon="cross"
          @click="filter.completeness = ''"
        />
      </span>
    </span>

    <span v-if="filter.registrationType" class="inline-flex flex-wrap gap-2">
      <span
        class="flex items-center space-x-1 rounded-full border border-n-30 py-1 px-2 text-xs"
      >
        <span class="text-n-40">Registration Type:</span>
        <span
          class="max-w-[500px] overflow-x-hidden text-ellipsis whitespace-nowrap"
          >{{ filter.registrationType }}</span
        >
        <svg-vue
          class="mx-2 mt-1 cursor-pointer text-xs"
          icon="cross"
          @click="filter.registrationType = ''"
        />
      </span>
    </span>

    <span v-if="filter.publisherType" class="inline-flex flex-wrap gap-2">
      <span
        v-for="(item, index) in filter.publisherType"
        :key="index"
        class="flex items-center space-x-1 rounded-full border border-n-30 py-1 px-2 text-xs"
      >
        <span class="text-n-40">Publisher type:</span>
        <span
          class="max-w-[500px] overflow-x-hidden text-ellipsis whitespace-nowrap"
          >{{ item }}</span
        >
        <svg-vue
          class="mx-2 mt-1 cursor-pointer text-xs"
          icon="cross"
          @click="filter.publisherType.splice(index, 1)"
        />
      </span>
    </span>
    <span v-if="filter.dataLicense" class="inline-flex flex-wrap gap-2">
      <span
        v-for="(item, index) in filter.dataLicense"
        :key="index"
        class="flex items-center space-x-1 rounded-full border border-n-30 py-1 px-2 text-xs"
      >
        <span class="text-n-40">Data License:</span>
        <span
          class="max-w-[500px] overflow-x-hidden text-ellipsis whitespace-nowrap"
          >{{ item }}</span
        >
        <svg-vue
          class="mx-2 mt-1 cursor-pointer text-xs"
          icon="cross"
          @click="filter.dataLicense.splice(index, 1)"
        />
      </span>
    </span>
    <span
      v-if="filter.start_date && filter.end_date"
      class="inline-flex flex-wrap gap-2"
    >
      <span
        class="flex items-center space-x-1 rounded-full border border-n-30 py-1 px-2 text-xs"
      >
        <span class="text-n-40">Date range</span>
        <svg-vue
          class="mx-2 mt-1 cursor-pointer text-xs"
          icon="cross"
          @click="
            () => {
              filter.start_date = '';
              filter.end_date = '';
            }
          "
        />
      </span>
    </span>

    <button class="font-bold uppercase text-bluecoral" @click="resetAllFilters">
      Clear Filter
    </button>
  </div>
  <!--Filter tag pills end-->

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
                <span>Organisation</span>
              </a>
            </th>
            <th id="country" scope="col" style="width: 173px">
              <a
                class="text-n-50 transition duration-500 hover:text-spring-50"
                :class="
                  orderType === 'country'
                    ? sortingDirection()
                    : defaultSortDirection
                "
                :href="sortBy('country')"
              >
                <span class="sorting-indicator">
                  <svg-vue
                    :icon="`${
                      orderType === 'country'
                        ? sortingDirection()
                        : defaultSortDirection
                    }-arrow`"
                  />
                </span>
                <span>Country</span>
              </a>
            </th>
            <th id="registered_on" scope="col" style="width: 173px">
              <a
                class="text-n-50 transition duration-500 hover:text-spring-50"
                :class="
                  orderType === 'registered_on'
                    ? sortingDirection()
                    : defaultSortDirection
                "
                :href="sortBy('registered_on')"
              >
                <span class="sorting-indicator">
                  <svg-vue
                    :icon="`${
                      orderType === 'registered_on'
                        ? sortingDirection()
                        : defaultSortDirection
                    }-arrow`"
                  />
                </span>
                <span>Registered On</span>
              </a>
            </th>
            <th id="last_login" scope="col" style="width: 173px">
              <a
                class="text-n-50 transition duration-500 hover:text-spring-50"
                :class="
                  orderType === 'last_logged_in'
                    ? sortingDirection()
                    : defaultSortDirection
                "
                :href="sortBy('last_logged_in')"
              >
                <span class="sorting-indicator">
                  <svg-vue
                    :icon="`${
                      orderType === 'last_logged_in'
                        ? sortingDirection()
                        : defaultSortDirection
                    }-arrow`"
                  />
                </span>
                <span>Last Login</span>
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
            <th id="publisher_type" scope="col" style="width: 173px">
              <a
                class="text-n-50 transition duration-500 hover:text-spring-50"
                :class="
                  orderType === 'publisher_type'
                    ? sortingDirection()
                    : defaultSortDirection
                "
                :href="sortBy('publisher_type')"
              >
                <span class="sorting-indicator">
                  <svg-vue
                    :icon="`${
                      orderType === 'publisher_type'
                        ? sortingDirection()
                        : defaultSortDirection
                    }-arrow`"
                  />
                </span>
                <span>Publisher Type</span>
              </a>
            </th>
            <th id="data_licence" scope="col" style="width: 173px">
              <a
                class="text-n-50 transition duration-500 hover:text-spring-50"
                :class="
                  orderType === 'data_license'
                    ? sortingDirection()
                    : defaultSortDirection
                "
                :href="sortBy('data_license')"
              >
                <span class="sorting-indicator">
                  <svg-vue
                    :icon="`${
                      orderType === 'data_license'
                        ? sortingDirection()
                        : defaultSortDirection
                    }-arrow`"
                  />
                </span>
                <span>Data licence</span>
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
              <div>
                <div v-if="data.name" class="ellipsis relative">
                  <span class="ellipsis overflow-hidden">
                    {{ data?.name[0]?.narrative ?? 'Name Missing' }}
                  </span>
                </div>

                <div v-else>Name Missing</div>
                <div class="text-blue-40">{{ data?.user?.email }}</div>
                <div class="flex">
                  <span
                    class="flex w-fit"
                    :class="
                      registryApiKeyStatus[data.id]
                        ? 'text-spring-50'
                        : 'text-crimson-50'
                    "
                  >
                    <svg-vue
                      class="text-md mt-1 cursor-pointer"
                      :icon="
                        registryApiKeyStatus[data.id]
                          ? 'tick'
                          : 'circle-red-cross'
                      "
                    ></svg-vue>
                    <span class="px-1"> Registry API Key </span>
                  </span>
                  <span
                    class="mx-2 flex w-fit"
                    :class="
                      defaultValueStatus[data.id]
                        ? 'text-spring-50'
                        : 'text-crimson-50'
                    "
                  >
                    <svg-vue
                      class="text-md mt-1 cursor-pointer"
                      :icon="
                        defaultValueStatus[data.id]
                          ? 'tick'
                          : 'circle-red-cross'
                      "
                    ></svg-vue>
                    <span class="px-1"> Default Values </span>
                  </span>
                </div>
              </div>
            </td>
            <td class="text-n-40">
              <div>
                {{ data.country }}
              </div>
            </td>
            <td class="text-n-40">
              <div>
                <div class="pb-1">
                  {{ dateFormat(data.created_at, 'MMMM, DD, YYYY') }}
                </div>
                <div class="text-xs">
                  Previously
                  {{ data.registration_type !== 'registry-wala' ? 'not' : '' }}
                  registered in IATI platform
                </div>
              </div>
            </td>
            <td class="text-n-40">
              <div>
                {{
                  data.latest_logged_in_user
                    ? dateFormat(
                        data.latest_logged_in_user.last_logged_in,
                        'MMMM, DD,YYYY'
                      )
                    : 'Not Available'
                }}
              </div>
            </td>
            <td class="text-n-40">
              <div>
                <div class="px-1">
                  {{ data.all_activities_count }} activities
                </div>
                <div class="text-xs">
                  Last updated on:
                  {{
                    dateFormat(
                      data.latest_updated_activity.updated_at,
                      'MMMM, DD, YYYY'
                    )
                  }}
                </div>
              </div>
            </td>
            <td class="text-n-40">
              <div>
                {{ data.publisher_type }}
              </div>
            </td>
            <td class="text-n-40">
              <div>
                {{ data.data_license }}
              </div>
            </td>
            <td>
              <div>
                <BtnComponent
                  text="proxy"
                  type="outline"
                  icon="smile"
                  @click="proxyUser(<number>data?.user?.id)"
                />
              </div>
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
    <div></div>
  </div>
</template>
<script setup lang="ts">
import {
  reactive,
  onMounted,
  inject,
  ref,
  defineProps,
  watch,
  computed,
} from 'vue';
import axios from 'axios';
import MultiSelectWithSearch from 'Components/MultiSelectWithSearch.vue';

import dateFormat from 'Composable/dateFormat';

import BtnComponent from 'Components/ButtonComponent.vue';
import Pagination from 'Components/TablePagination.vue';
import Multiselect from '@vueform/multiselect';
import { watchIgnorable } from '@vueuse/core';
import DateRangeWidget from 'Components/DateRangeWidget.vue';

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

const props = defineProps({
  countries: { type: Object, required: true },
  setupCompleteness: { type: Object, required: true },
  registrationTypes: { type: Object, required: true },
  publisherTypes: { type: Object, required: true },
  dataLicenses: { type: Object, required: true },
});

let filter = reactive({
  country: [],
  completeness: '',
  registrationType: '',
  publisherType: [],
  dataLicense: [],
  start_date: '',
  end_date: '',
  date_type: 'created_at',
});

let registryApiKeyStatus: boolean[] = reactive([]);
let defaultValueStatus: boolean[] = reactive([]);
let showMultiSelectWithSearch = ref(false);
let dropdownRange = {
  created_at: 'User registered date',
  // last_logged_in: 'Last Logged in'
  //there is no last logged in column in organisation
};

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
  let endpoint = `/list-organisations/page/${active_page}${queryString}`;

  if (isFilterApplied.value) {
    queryString = queryString ?? '&q=';
    endpoint = queryString !== '' ? endpoint : `${endpoint}`;

    for (const filter_key in filter) {
      if (filter[filter_key]) {
        if (filter[filter_key].length > 0) {
          urlParams.append(filter_key, filter[filter_key]);
        }
      }
    }
  }

  axios
    .get(endpoint, { params: isFilterApplied.value ? urlParams : '' })
    .then((res) => {
      const response = res.data;

      if (response.success) {
        if (response.data.data.length === 0) {
          organisationData.status = 'empty';
        } else {
          organisationData.status = 'success';
          organisationData.data = response.data;
          refreshStatusArrays(organisationData.data);
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

let range = '';

const sortingDirection = () => {
  return sortDirection === 'asc' ? 'descending' : 'ascending';
};

const { ignoreUpdates } = watchIgnorable(filter, () => undefined);

const sortBy = (order) => {
  if (currentURL.includes('?')) {
    query = urlParams.get('q') ?? '';
    sortDirection = urlParams.get('direction') === 'desc' ? 'asc' : 'desc';

    if (urlParams.get('fixed') ?? false) {
      range = `&fixed=${urlParams.get('fixed')}`;
    } else {
      let startDate = urlParams.get('start_date') ?? false;
      let endDate = urlParams.get('end_date') ?? false;

      if (startDate && endDate) {
        range = `&start_date=${startDate}&end_date=${endDate}`;
      }
    }
  }

  return `?q=${query}&orderBy=${order}&direction=${sortDirection}${range}`;
};

watch(
  () => [
    filter.country,
    filter.completeness,
    filter.registrationType,
    filter.publisherType,
    filter.dataLicense,
    filter.start_date,
    filter.end_date,
    filter.date_type,
  ],
  () => {
    fetchOrganisation(organisationData.data['current_page']);
  },
  { deep: true }
);

let resetAllFilters = () => {
  ignoreUpdates(() => {
    filter.country = [];
    filter.completeness = '';
    filter.registrationType = '';
    filter.publisherType = [];
    filter.dataLicense = [];
    filter.start_date = '';
    filter.end_date = '';
    filter.date_type = 'created_at';
  });
};

const isFilterApplied = computed(() => {
  return (
    filter.country.length +
      filter.publisherType.length +
      filter.dataLicense.length !=
      0 ||
    filter.completeness !== '' ||
    filter.registrationType !== '' ||
    filter.start_date != '' ||
    filter.end_date != ''
  );
});

const refreshStatusArrays = (orgData) => {
  for (let orgDatum of orgData.data) {
    registryApiKeyStatus[orgDatum.id] =
      orgDatum?.settings.publishing_info.token_verification ?? false;
    defaultValueStatus[orgDatum.id] = checkIfDefaultValuesAreValid(
      orgDatum?.settings
    );
  }
};

const checkIfDefaultValuesAreValid = (settings) => {
  if (settings) {
    let defaultValues = settings.default_values;
    let activityDefaultValues = settings.activity_default_values;
    return !!(
      (defaultValues.default_currency ?? false) &&
      (defaultValues.default_language ?? false) &&
      (activityDefaultValues.hierarchy ?? false) &&
      (activityDefaultValues.budget_not_provided ?? false) &&
      (activityDefaultValues.humanitarian != null ||
        activityDefaultValues.humanitarian != '' ||
        activityDefaultValues.humanitarian != false)
    );
  }

  return false;
};

const setDateRangeDate = (startDate, endDate) => {
  filter.start_date = startDate;
  filter.end_date = endDate;
};

const setDateType = (dateType) => {
  filter.date_type = dateType;
};

const rotateClass = ref('');

const toggleShowMultiSelect = () => {
  showMultiSelectWithSearch.value = !showMultiSelectWithSearch.value;
  if (showMultiSelectWithSearch.value) {
    rotateClass.value = 'rotate-180';
  } else {
    rotateClass.value = 'rotate-0';
  }
};

const setSelectedPublisher = (publisherTypes) => {
  filter.publisherType = publisherTypes;
};
</script>

<style>
.rotate-180 {
  transform: rotate(180deg);
  transition: 300ms;
}
.rotate-0 {
  transform: rotate(0deg);
  transition: 300ms;
}
.multiselect-wrapper {
  position: absolute;
  z-index: 5;
  width: 424px;
  height: fit-content;
  background: white;
  overflow-y: auto;
  top: 42px;
  left: 0;
}
.multiselect-lookalike {
  position: relative;
  align-items: center;
  background-color: #fff !important;
  border: 1px solid #d1d5db;
  border-radius: 4px;
  width: 160px !important;
  height: 40px;
  padding: 12px;
  cursor: pointer;
}
</style>
