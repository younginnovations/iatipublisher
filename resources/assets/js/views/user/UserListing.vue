<template>
  <div class="px-6 py-4 md:px-10">
    <Loader v-if="isLoaderVisible" />
    <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
      <div class="flex">
        <a class="whitespace-nowrap font-bold text-n-40" href="/users">
          users
        </a>
      </div>
    </nav>
    <PageTitle title="Users" back-link="">
      <div class="inline-flex flex-col items-end justify-end gap-2 md:flex-row">
        <Toast
          v-if="
            toastData.visibility &&
            toastData.message &&
            toastData.message !== ''
          "
          :message="toastData.message"
          :type="toastData.type"
        />
        <button
          v-if="usersData['total'] > 0"
          ref="dropdownBtn"
          class="button secondary-btn whitespace-nowrap font-bold"
          @click="downloadAll"
        >
          <svg-vue icon="download-file" />
          {{ checklist.length === 0 ? 'Download All' : '' }}
        </button>
        <button
          v-if="userRole !== 'general_user'"
          class="primary-btn whitespace-nowrap"
          @click="
            () => {
              emptyFormData();
              setFormError();
              addUserForm = true;
            }
          "
        >
          <svg-vue class="text-base" icon="plus-outlined" /> Add a new
          {{ userRole === 'admin' ? 'user' : 'iati admin' }}
        </button>
      </div>
    </PageTitle>

    <div>
      <PopupModal :modal-active="addUserForm || editUserForm">
        <div
          class="popup-model"
          @keyup.enter="addUserForm ? createUser() : updateUser()"
        >
          <div class="mb-5 text-2xl font-bold text-bluecoral">
            {{ addUserForm ? 'Add a new ' : 'Edit ' }}
            {{ userRole === 'admin' ? 'user' : 'IATI Admin' }}
          </div>
          <div class="grid grid-cols-2 gap-6">
            <div class="col-span-2 flex flex-col items-start gap-2">
              <label class="text-sm text-n-50"
                >Full Name<span class="text-crimson-50"> * </span></label
              >
              <input
                v-model="formData.full_name"
                :class="
                  formError['full_name'] ? 'border-crimson-50' : 'border-n-30'
                "
                class="w-full rounded border p-3"
                type="text"
              />
              <span v-if="formError['full_name']" class="error">{{
                formError['full_name'][0]
              }}</span>
            </div>

            <div class="flex flex-col items-start gap-2">
              <label class="text-sm text-n-50"
                >Username<span class="text-crimson-50"> *</span></label
              >
              <input
                v-model="formData.username"
                :class="
                  formError['username'] ? 'border-crimson-50' : 'border-n-30'
                "
                class="w-full rounded border p-3"
                type="text"
              />
              <span v-if="formError['username']" class="error">{{
                formError['username'][0]
              }}</span>
            </div>
            <div class="flex flex-col items-start gap-2">
              <label class="text-sm text-n-50"
                >Email<span class="text-crimson-50"> * </span></label
              >
              <input
                v-model="formData.email"
                :class="
                  formError['email'] ? 'border-crimson-50' : 'border-n-30'
                "
                class="w-full rounded border p-3"
                type="email"
              />
              <span v-if="formError['email']" class="error">{{
                formError['email'][0]
              }}</span>
            </div>

            <div
              v-if="addUserForm"
              :class="formError['status'] && 'error__multiselect'"
              class="flex flex-col items-start gap-2"
            >
              <label class="text-sm text-n-50"
                >Status<span class="text-crimson-50"> * </span></label
              >
              <Multiselect
                v-model="formData.status"
                :options="status"
                placeholder="Select status"
                :searchable="true"
              />
              <span v-if="formError['status']" class="error">{{
                formError['status'][0]
              }}</span>
            </div>
            <div
              v-if="userRole === 'admin'"
              :class="formError['role_id'] && 'error__multiselect'"
              class="flex flex-col items-start gap-2"
            >
              <label class="text-sm text-n-50"
                >Role<span class="text-crimson-50"> * </span></label
              >
              <Multiselect
                v-model="formData.role_id"
                :options="roles"
                placeholder="Select user role"
                :searchable="true"
              />
              <span v-if="formError['role_id']" class="error">{{
                formError['role_id'][0]
              }}</span>
            </div>

            <div class="flex flex-col items-start gap-2">
              <label class="text-sm text-n-50"
                >New password<span v-if="!editUserForm" class="text-crimson-50">
                  *
                </span></label
              >
              <input
                v-model="formData.password"
                :class="
                  formError['password'] ? 'border-crimson-50' : 'border-n-30'
                "
                class="w-full rounded border border-n-30 p-3"
                type="password"
              />

              <span v-if="formError['password']" class="error">{{
                formError['password'][0]
              }}</span>
            </div>
            <div class="flex flex-col items-start gap-2">
              <label class="text-sm text-n-50"
                >Confirm Password<span
                  v-if="!editUserForm"
                  class="text-crimson-50"
                >
                  *
                </span></label
              >

              <input
                v-model="formData.password_confirmation"
                :class="
                  formError['password_confirmation']
                    ? 'border-crimson-50'
                    : 'border-n-30'
                "
                class="w-full rounded border border-n-30 p-3"
                type="password"
              />
              <span v-if="formError['password_confirmation']" class="error">{{
                formError['password_confirmation'][0]
              }}</span>
            </div>
          </div>

          <div class="mt-6 flex justify-end space-x-2">
            <button
              class="secondary-btn font-bold"
              @click="
                () => {
                  addUserForm = false;
                  editUserForm = false;
                }
              "
            >
              Cancel
            </button>
            <button
              class="primary-btn !px-10"
              @click="addUserForm ? createUser() : updateUser()"
            >
              Save
            </button>
          </div>
        </div>
      </PopupModal>
      <PopupModal :modal-active="deleteModal">
        <div class="title mb-6 flex">
          <svg-vue class="mr-1 mt-0.5 text-lg text-crimson-40" icon="delete" />
          <b>Delete user</b>
        </div>
        <p class="rounded-lg bg-rose p-4">
          Are you sure you want to delete this user?
        </p>
        <div class="mt-6 flex justify-end space-x-2">
          <button
            class="secondary-btn font-bold"
            @click="
              () => {
                deleteModal = false;
              }
            "
          >
            Cancel
          </button>
          <button class="primary-btn !px-10" @click="deleteUser(deleteId)">
            Delete
          </button>
        </div>
      </PopupModal>

      <div class="filters mb-4 flex flex-wrap justify-between gap-2">
        <div class="select filters inline-flex items-center space-x-2">
          <svg-vue class="w-10 text-lg" icon="funnel" />
          <span
            v-if="userRole === 'superadmin' || userRole === 'iati_admin'"
            class="organization"
            ><Multiselect
              v-model="filter.organization"
              :options="organizations"
              placeholder="ORGANISATION"
              :searchable="true"
              mode="multiple"
              :taggable="true"
              :close-on-select="false"
              :clear-on-select="false"
              label="name"
            />
          </span>

          <span class="role">
            <Multiselect
              v-model="filter.roles"
              :options="roles"
              placeholder="ROLE"
              :searchable="true"
              mode="multiple"
              :close-on-select="false"
              :clear-on-select="false"
            />
            <span v-if="filter.roles.length > 0" class="status">
              <!-- placeholder -->
              <!-- role -->
            </span></span
          >
          <span class="status"
            ><Multiselect
              v-model="filter.status"
              :options="status"
              placeholder="STATUS"
              :searchable="true"
            />
          </span>
          <span></span>
        </div>
        <div class="open-text h-[38px]">
          <svg-vue
            class="absolute top-1/2 left-2 w-10 -translate-y-1/2 text-base"
            icon="magnifying-glass"
          />
          <input
            v-model="filter.q"
            type="text"
            placeholder="Search for users"
          />
        </div>
      </div>

      <div
        v-if="isFilterApplied"
        class="mb-4 flex max-w-full flex-wrap items-center gap-2"
      >
        <span class="text-sm font-bold uppercase text-n-40">filtered by: </span>

        <span v-if="filter.organization" class="inline-flex flex-wrap gap-2">
          <span
            v-for="(item, index) in filter.organization"
            :key="index"
            class="flex items-center space-x-1 rounded-full border border-n-30 py-1 px-2 text-xs"
          >
            <span class="text-n-40">Org:</span
            ><span>{{ textBubbledata(item, 'org') }}</span>
            <svg-vue
              class="mx-2 mt-1 cursor-pointer text-xs"
              icon="cross"
              @click="filter.organization.splice(index, 1)"
            />
          </span>
        </span>
        <span v-if="filter.roles" class="inline-flex flex-wrap gap-2">
          <span
            v-for="(item, index) in filter.roles"
            :key="index"
            class="flex items-center space-x-1 rounded-full border border-n-30 px-2 py-1 text-xs"
          >
            <span class="text-n-40">Roles:</span
            ><span>{{ textBubbledata(item, 'roles') }}</span>
            <svg-vue
              class="mx-2 mt-1 cursor-pointer text-xs"
              icon="cross"
              @click="filter.roles.splice(index, 1)"
            />
          </span>
        </span>
        <span v-if="filter.status" class="inline-flex flex-wrap gap-2">
          <span
            v-for="(item, index) in filter.status"
            :key="index"
            class="flex items-center space-x-1 rounded-full border border-n-30 py-1 px-2 text-xs"
          >
            <span class="text-n-40">Status:</span
            ><span>{{ textBubbledata(item, 'status') }}</span>
            <svg-vue
              class="mx-2 mt-1 cursor-pointer text-xs"
              icon="cross"
              @click="
                () => {
                  filter.status = '';
                }
              "
            />
          </span>
        </span>
        <button
          class="font-bold uppercase text-bluecoral"
          @click="
            () => {
              filter.organization = [];
              filter.roles = [];
              filter.status = '';
            }
          "
        >
          Clear Filter
        </button>
      </div>

      <div class="iati-list-table user-list-table text-n-40">
        <table>
          <thead>
            <tr class="bg-n-10">
              <th id="title" scope="col">
                <span class="inline-flex items-center">
                  <span
                    v-if="
                      filter.direction === 'desc' &&
                      filter.orderBy === 'username'
                    "
                  >
                    <svg-vue
                      class="mx-2 h-3 w-2 cursor-pointer"
                      icon="sort-descending"
                      @click="sort('username')"
                    />
                  </span>
                  <span v-else>
                    <svg-vue
                      class="mx-2 h-3 w-2 cursor-pointer"
                      icon="sort-ascending"
                      @click="sort('username')"
                    />
                  </span>

                  <span>Users</span>
                </span>
              </th>
              <th id="measure" scope="col" width="190px">
                <span>Email</span>
              </th>
              <th
                v-if="userRole === 'superadmin' || userRole === 'iati_admin'"
                id="aggregation_status"
                scope="col"
                width=" 208px"
              >
                <span class="inline-flex items-center">
                  <span
                    v-if="
                      filter.orderBy === 'publisher_name' &&
                      filter.direction === 'desc'
                    "
                    class="mx-2 h-3 w-2 cursor-pointer"
                    @click="sort('publisher_name')"
                  />
                </span>
                <span class="whitespace-nowrap">Organisation Name</span>
              </th>
              <th id="title" scope="col">
                <span>User Role</span>
              </th>
              <th>
                <span>Status</span>
              </th>
              <th
                id="aggregation_status"
                class="flex items-center"
                scope="col"
                width="208px"
              >
                <span
                  v-if="
                    filter.direction === 'desc' &&
                    filter.orderBy === 'created_at'
                  "
                  class="inline-flex items-center"
                >
                  <svg-vue
                    class="mx-2 h-3 w-2 cursor-pointer"
                    icon="sort-descending"
                    @click="sort('created_at')"
                  />
                </span>
                <span v-else>
                  <svg-vue
                    class="mx-2 h-3 w-2 cursor-pointer"
                    icon="sort-ascending"
                    @click="sort('created_at')"
                  />
                </span>
                <span class="whitespace-nowrap">Joined On</span>
              </th>
              <th
                v-if="userRole !== 'general_user'"
                id="action"
                scope="col"
                width="190px"
              >
                <span>Action</span>
              </th>
              <th id="cb" scope="col">
                <span class="cursor-pointer">
                  <svg-vue icon="checkbox" @click="toggleSelectall" />
                </span>
              </th>
            </tr>
          </thead>
          <tbody v-if="usersData?.data.length > 0">
            <tr v-for="(user, index) in usersData?.data" :key="index">
              <td>
                <div class="ellipsis relative">
                  <p
                    class="w-32 overflow-x-hidden overflow-ellipsis whitespace-nowrap"
                  >
                    {{ user['full_name'] }}
                  </p>
                  <div class="w-52">
                    <span class="ellipsis__title--hover">{{
                      user['full_name']
                    }}</span>
                  </div>
                </div>
                <div class="ellipsis relative">
                  <p
                    class="w-32 overflow-x-hidden overflow-ellipsis whitespace-nowrap"
                  >
                    {{ user['username'] }}
                  </p>
                  <div class="w-52">
                    <span class="ellipsis__title--hover">{{
                      user['username']
                    }}</span>
                  </div>
                </div>
              </td>
              <td class="capitalize">
                {{ user['email'] }}
              </td>
              <td v-if="userRole === 'superadmin' || userRole === 'iati_admin'">
                <div class="ellipsis relative">
                  <p
                    class="w-32 overflow-x-hidden overflow-ellipsis whitespace-nowrap"
                  >
                    {{
                      user['publisher_name'] ? user['publisher_name'] : '- -'
                    }}
                  </p>

                  <div class="w-52">
                    <span class="ellipsis__title--hover"
                      >{{
                        user['publisher_name'] ? user['publisher_name'] : '- -'
                      }}
                    </span>
                  </div>
                </div>
              </td>
              <td class="capitalize">
                {{ user['role'] }}
              </td>
              <td :class="user['status'] ? 'text-spring-50' : 'text-n-40'">
                {{ user['status'] ? 'Active' : 'Inactive' }}
              </td>
              <td>{{ formatDate(user['created_at']) }}</td>
              <td
                v-if="userRole !== 'general_user'"
                class="flex h-full items-center space-x-6"
              >
                <p @click="editUser(user)">
                  <svg-vue
                    class="cursor-pointer text-base"
                    icon="edit-action"
                  />
                </p>
                <!-- <p @click="deleteUser(user['id'])"> -->
                <p @click="openDeletemodel(user['id'])">
                  <svg-vue class="cursor-pointer text-base" icon="delete" />
                </p>
                <p @click="toggleUserStatus(user['id'])">
                  <span
                    :class="user['status'] ? 'bg-spring-50' : 'bg-n-40'"
                    class="relative block h-4 w-7 cursor-pointer rounded-full"
                  >
                    <span
                      :class="
                        user['status'] ? 'translate-x-0' : 'translate-x-full'
                      "
                      class="absolute top-1/2 left-[2px] block h-3 w-3 -translate-y-1/2 rounded-full bg-white duration-200"
                    />
                  </span>
                </p>
              </td>
              <td>
                <span class="relative h-5 w-5"
                  ><input
                    v-model="checklist"
                    class="user-checklist"
                    :value="user['id']"
                    type="checkbox"
                  />
                  <span class="pseudo-checkbox" />
                  <svg-vue class="ticked-svg text-spring-50" icon="ticked" />
                </span>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <td colspan="8" class="text-center">Users not found</td>
          </tbody>
        </table>
      </div>

      <div class="mt-6">
        <Pagination
          v-if="usersData && usersData['last_page'] > 1"
          :data="usersData"
          @fetch-activities="fetchUsersList"
        />
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { defineProps, reactive, ref, computed, watch, onMounted } from 'vue';
import Loader from '../../components/Loader.vue';
import PageTitle from 'Components/sections/PageTitle.vue';
import Toast from 'Components/ToastMessage.vue';
import axios from 'axios';
import PopupModal from 'Components/PopupModal.vue';
import encrypt from 'Composable/encryption';
import Multiselect from '@vueform/multiselect';
import moment from 'moment';
import Pagination from 'Components/TablePagination.vue';
import { watchIgnorable } from '@vueuse/core';
import { response } from 'express';

const props = defineProps({
  organizations: { type: Object, required: true },
  status: { type: Object, required: true },
  roles: { type: Object, required: true },
  userRole: { type: String, required: true },
});

const toastData = reactive({
  visibility: false,
  message: '',
  type: false,
});

const filter = reactive({
  organization: [],
  roles: [],
  status: '',
  orderBy: '',
  direction: '',
  q: '',
});

const isLoaderVisible = ref(false);
const addUserForm = ref(false);
const editUserForm = ref(false);
const usersData = reactive({ data: [] });
const isEmpty = ref(true);
const allSelected = ref<boolean[]>([]);
const deleteModal = ref(false);
const deleteId = ref();

const selectedIds = ref({});
const checklist = ref([]);
const currentpageData = ref([]);

const editUserId = ref('');

const formData = reactive({
  username: '',
  full_name: '',
  email: '',
  status: '',
  role_id: '',
  password: '',
  password_confirmation: '',
});

const formError = reactive({
  username: '',
  full_name: '',
  email: '',
  status: '',
  role_id: '',
  password: '',
  password_confirmation: '',
});

const isFilterApplied = computed(() => {
  return (
    !!filter.organization.length ||
    !!filter.roles.length ||
    filter.status ||
    filter.status != null
  );
});

const { ignoreUpdates } = watchIgnorable(toastData, () => undefined, {
  flush: 'sync',
});

watch(
  () => toastData.visibility,
  () => {
    setTimeout(() => {
      toastData.visibility = false;
      ignoreToastUpdate();
    }, 2000);
  }
);

const ignoreToastUpdate = () => {
  ignoreUpdates(() => {
    toastData.message = '';
  });
};

onMounted(async () => {
  axios.get(`/users/page/1`).then((res) => {
    const response = res.data;
    for (let i = 0; i < response.data.data.length; i++) {
      response.data.data[i].role = response.data.data[i].role
        .split('_')
        .join(' ');
    }
    Object.assign(usersData, response.data);
    isEmpty.value = response.data.data.length ? false : true;
  });

  setTimeout(() => {
    toastData.visibility = false;
  }, 5000);
});

const textBubbledata = (id, field) => {
  switch (field) {
    case 'org':
      return props.organizations[+id];
    case 'roles':
      return props.roles[+id];
    case 'status':
      return props.status[+id];
  }
};

const clearFilter = () => {
  filter.organization = [];
  filter.roles = [];
  filter.status = '';
  filter.direction = '';
  filter.orderBy = '';
  filter.q = '';
};

const createUser = () => {
  isLoaderVisible.value = true;
  let passwordData = {
    password: encrypt(formData.password, process.env.MIX_ENCRYPTION_KEY ?? ''),
    password_confirmation: encrypt(
      formData.password_confirmation,
      process.env.MIX_ENCRYPTION_KEY ?? ''
    ),
  };

  axios
    .post('/user', { ...formData, ...passwordData })
    .then((res) => {
      toastData.visibility = true;
      toastData.message = res.data.message;
      toastData.type = res.data.success;
      isLoaderVisible.value = false;
      setFormError();
      setFormError(res.data.errors);

      if (res.data.success) {
        clearFilter();
        fetchUsersList(usersData['current_page'], true);
        addUserForm.value = false;
        emptyFormData();
        setFormError();
      }
    })
    .catch((error) => {
      toastData.visibility = true;
      toastData.message = error.data.message;
      toastData.type = false;
      isLoaderVisible.value = false;
      addUserForm.value = false;
    })
    .finally(() => {
      isLoaderVisible.value = false;
    });
};

const editUser = (user) => {
  formData.username = user.username;
  formData.full_name = user.full_name;
  formData.email = user.email;
  formData.role_id = user.role_id;
  editUserId.value = user.id;
  editUserForm.value = true;
};

const emptyFormData = () => {
  for (const key in formData) {
    formData[key] = '';
  }
};
const setFormError = (errors = {}) => {
  if (Object.keys(errors).length) {
    for (const key in errors) {
      formError[key] = errors[key];
    }
  } else {
    for (const key in formError) {
      formError[key] = '';
    }
  }
};

const updateUser = () => {
  isLoaderVisible.value = true;
  let passwordData = {
    password: encrypt(formData.password, process.env.MIX_ENCRYPTION_KEY ?? ''),
    password_confirmation: encrypt(
      formData.password_confirmation,
      process.env.MIX_ENCRYPTION_KEY ?? ''
    ),
  };

  axios
    .patch(`/user/${editUserId.value}`, { ...formData, ...passwordData })
    .then((res) => {
      toastData.visibility = true;
      toastData.message = res.data.message;
      toastData.type = res.data.success;
      isLoaderVisible.value = false;
      setFormError();
      setFormError(res.data.errors);

      if (res.data.success) {
        editUserForm.value = false;
        fetchUsersList(usersData['current_page']);
        editUserId.value = '';
        emptyFormData();
        setFormError();
        window.scrollTo(0, 0);
      }
    })
    .catch((error) => {
      editUserId.value = '';
      toastData.visibility = true;
      toastData.message = error.data.message;
      toastData.type = false;
      isLoaderVisible.value = false;
    })
    .finally(() => {
      isLoaderVisible.value = false;
    });
};

watch(
  () => [filter.organization, filter.roles, filter.q, filter.status],
  () => {
    fetchUsersList(usersData['current_page'], true);
  },
  { deep: true }
);

function fetchUsersList(active_page: number, filtered = false) {
  let route = `/users/page/${filtered ? '1' : active_page}`;

  let params = new URLSearchParams();

  for (const filter_key in filter) {
    if (filter[filter_key]) {
      if (filter[filter_key].length > 0) {
        params.append(filter_key, filter[filter_key]);
      }
    }
  }

  axios.get(route, { params: params }).then((res) => {
    const response = res.data;
    Object.assign(usersData, response.data);
    isEmpty.value = response.data ? false : true;
  });
}

const openDeletemodel = (id) => {
  deleteModal.value = true;
  deleteId.value = id;
};

function deleteUser(id: number) {
  deleteModal.value = false;
  window.scrollTo(0, 0);

  axios
    .delete(`/user/${id}`)
    .then((res) => {
      if (res.data.message) {
        toastData.visibility = true;
        toastData.message = res.data.message;
        toastData.type = res.data.success;
      }

      if (res.data.success) {
        fetchUsersList(usersData['current_page']);
      }
    })
    .catch((err) => {
      console.log(err);
    });
}

const sort = (param) => {
  filter.direction =
    filter.direction === 'asc' && filter.orderBy === param ? 'desc' : 'asc';
  filter.orderBy = param;

  fetchUsersList(1);
};

function toggleUserStatus(id: number) {
  window.scrollTo(0, 0);
  isLoaderVisible.value = true;

  axios
    .patch(`/user/status/${id}`)
    .then((res) => {
      if (res.status) {
        toastData.visibility = true;
        toastData.message = res.data.message;
        toastData.type = res.data.success;

        fetchUsersList(usersData['current_page']);
      }
    })
    .catch((err) => {
      console.log(err);
    })
    .finally(() => {
      isLoaderVisible.value = false;
    });
}

function formatDate(date: Date) {
  return moment(date).format('LL');
}

const toggleSelectall = () => {
  currentpageData.value = usersData.data.map((value) => {
    return value['id'];
  });
  for (let i = 0; i < usersData.data.length; i++) {
    if (!checklist.value.includes(usersData.data[i]['id']))
      checklist.value[checklist.value.length + i] = usersData.data[i]['id'];
  }
  selectedIds.value[usersData['current_page']] = checklist.value;
  if (allSelected.value[usersData['current_page']]) {
    checklist.value = checklist.value.filter(
      (n) => !Object.values(currentpageData.value).includes(n)
    );
  }
  checklist.value = checklist.value.filter(function (el) {
    return el != null;
  });
  allSelected.value[usersData['current_page']] =
    !allSelected.value[usersData['current_page']];
};
watch(
  () => checklist.value,
  (value) => {
    selectedIds.value[usersData['current_page']] = [];

    currentpageData.value = usersData.data.map((value) => {
      return value['id'];
    });
    for (let i = 0; i < checklist.value.length; i++) {
      if (currentpageData.value.includes(checklist.value[i])) {
        selectedIds.value[usersData['current_page']][i] = checklist.value[i];
      }
    }
    selectedIds.value[usersData['current_page']] = selectedIds.value[
      usersData['current_page']
    ].filter(function (el) {
      return el != null;
    });
  }
);

const downloadAll = () => {
  let route = `/users/download/`;
  let params = new URLSearchParams();
  let allPageSelected;
  allPageSelected = Object.values(selectedIds.value).flat();

  if (checklist.value.length == 0) {
    for (const filter_key in filter) {
      if (filter[filter_key].length > 0) {
        params.append(filter_key, filter[filter_key]);
      }
    }
  } else {
    params.append('users', allPageSelected);
  }

  axios.get(route, { params: params }).then((res) => {
    const response = res.data;
    console.group(res);
    let blob = new Blob([response], {
      type: 'application/csv',
    });
    let link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = res.headers['content-disposition'];
    link.click();
  });
};
</script>
<style scoped src="@vueform/multiselect/themes/default.css"></style>
