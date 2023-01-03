<template>
  <div class="px-10 py-4">
    <Loader v-if="isLoaderVisible" />
    <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
      <div class="flex">
        <a class="whitespace-nowrap font-bold text-n-40" href="/users"> users </a>
      </div>
    </nav>
    <PageTitle title="Users" back-link="">
      <div class="flex justify-end space-x-2">
        <button ref="dropdownBtn" class="button secondary-btn font-bold">
          <svg-vue icon="download-file" /> Download All
        </button>
        <button
          class="primary-btn"
          @click="
            () => {
              addUserForm = true;
            }
          "
        >
          <svg-vue class="text-base" icon="plus-outlined" /> Add a new superadmin
        </button>
      </div>
    </PageTitle>
    <Toast
      v-if="toastData.visibility"
      :message="toastData.message"
      :type="toastData.type"
    />

    <div>
      <PopupModal :modal-active="addUserForm || editUserForm">
        <div>
          <div class="mb-4 font-bold">Add a user</div>
          <div>
            <div class="flex">
              <label>Full Name</label>
              <input v-model="formData.full_name" type="text" />
            </div>
            <div class="flex justify-between">
              <div class="flex">
                <label>Username</label>
                <input v-model="formData.username" type="text" />
              </div>
              <div class="flex">
                <label>Email</label>
                <input v-model="formData.email" type="email" />
              </div>
            </div>
            <div class="flex">
              <label>Status</label>
              <Multiselect
                v-model="formData.status"
                :options="status"
                placeholder="Select status"
                :searchable="true"
              />
            </div>
            <div class="flex">
              <label>Role</label>
              <Multiselect
                v-model="formData.role"
                :options="roles"
                placeholder="Select user role"
                :searchable="true"
              />
            </div>

            <div class="flex">
              <div class="flex">
                <label>New Password</label>
                <input v-model="formData.password" type="password" />
              </div>
              <div class="flex">
                <label>Confirm Password</label>
                <input v-model="formData.password_confirmation" type="password" />
              </div>
            </div>
          </div>
          <div class="flex justify-end">
            <button
              @click="
                () => {
                  addUserForm = false;
                  editUserForm = false;
                }
              "
            >
              Cancel
            </button>
            <button @click="addUserForm ? createUser() : updateUser()">Save</button>
          </div>
        </div>
      </PopupModal>
      <div class="filters mb-4 flex justify-between">
        <div class="select filters inline-flex items-center space-x-2">
          <svg-vue class="w-[130px] cursor-pointer text-lg" icon="funnel" />
          <Multiselect
            v-model="filter.organization"
            :options="Object.values(organizations)"
            placeholder="ORGANISATION"
            :searchable="true"
            mode="multiple"
            :close-on-select="false"
            :clear-on-select="false"
          />

          <Multiselect
            v-model="filter.roles"
            :options="Object.values(props.roles)"
            placeholder="ROLE"
            :searchable="true"
            mode="multiple"
            :close-on-select="false"
            :clear-on-select="false"
          />
          <Multiselect
            v-model="filter.status"
            :options="Object.values(status)"
            mode="multiple"
            placeholder="STATUS"
            :searchable="true"
          />
        </div>
        <div class="open-text">
          <svg-vue
            class="absolute top-1/2 left-2 -translate-y-1/2 text-base"
            icon="magnifying-glass"
          />
          <input type="text" placeholder="Search for users" />
        </div>
      </div>

      <div class="mb-4 flex items-center gap-2" v-if="isFilterApplied">
        <span class="text-sm font-bold uppercase text-n-40">filtered by:</span>

        <span class="flex gap-2" v-if="filter.organization.length">
          <span
            v-for="(item, index) in filter.organization"
            :key="index"
            class="flex items-center space-x-1 rounded-full border border-n-30 py-1 px-2 text-xs"
          >
            <span class="text-n-40">Org:</span><span>{{ item }}</span>
            <svg-vue
              @click="filter.organization.splice(index, 1)"
              class="mx-2 mt-1 cursor-pointer text-xs"
              icon="cross"
            />
          </span>
        </span>
        <span class="flex gap-2" v-if="filter.role.length">
          <span
            v-for="(item, index) in filter.role"
            :key="index"
            class="flex items-center space-x-1 rounded-full border border-n-30 px-2 py-1 text-xs"
          >
            <span class="text-n-40">Roles:</span><span>{{ item }}</span>
            <svg-vue
              class="mx-2 mt-1 cursor-pointer text-xs"
              icon="cross"
              @click="filter.role.splice(index, 1)"
            />
          </span>
        </span>
        <span class="flex gap-2" v-if="filter.status.length">
          <span
            v-for="(item, index) in filter.status"
            :key="index"
            class="flex items-center space-x-1 rounded-full border border-n-30 py-1 px-2 text-xs"
          >
            <span class="text-n-40">Status:</span><span>{{ item }}</span>
            <svg-vue
              class="mx-2 mt-1 cursor-pointer text-xs"
              icon="cross"
              @click="filter.status.splice(index, 1)"
            />
          </span>
        </span>
        <div class="open-text"><input type="text" placeholder="Search" /></div>
        <div @click="fetchUsersList(usersData['current_page'])">Search</div>
      </div>

      <div class="iati-list-table text-n-40">
        <table>
          <thead>
            <tr class="bg-n-10">
              <th id="title" scope="col">
                <span>Users</span>
              </th>
              <th id="measure" scope="col" width="190px">
                <span>Email</span>
              </th>
              <th id="aggregation_status" scope="col" width="208px">
                <span>Organisation Name</span>
              </th>
              <th id="title" scope="col">
                <span>User Role</span>
              </th>
              <th id="measure" scope="col" width="190px">
                <span>Status</span>
              </th>
              <th id="aggregation_status" scope="col" width="208px">
                <span>Joined on</span>
              </th>
              <th id="action" scope="col" width="190px">
                <span>Action</span>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(user, index) in usersData?.data" :key="index">
              <td>
                <div class="ellipsis relative">
                  <p>
                    {{ user.full_name }}
                  </p>
                  <span>
                    {{ user.username }}
                  </span>
                </div>
              </td>
              <td class="capitalize">
                {{ user.email }}
              </td>
              <td>
                {{ organizations[user.organization_id] }}
              </td>
              <td>
                {{ roles[user.role_id] }}
              </td>
              <td>{{ user.status }}</td>
              <td>{{ formatDate(user.created_at) }}</td>
              <td>
                <p @click="editUser(user)">Edit</p>
                <p @click="deleteUser(user.id)">Delete</p>
                <p @click="toggleUserStatus(user.id)">Toggle</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="mt-6">
        <Pagination
          v-if="usersData && usersData?.last_page > 1"
          :data="usersData"
          @fetch-activities="fetchUsersList"
        />
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { defineProps, reactive, ref, onUpdated, computed, onMounted } from "vue";
import Loader from "../../components/Loader.vue";
import PageTitle from "Components/sections/PageTitle.vue";
import Toast from "Components/ToastMessage.vue";
import axios from "axios";
import PopupModal from "Components/PopupModal.vue";
import encrypt from "Composable/encryption";
import Multiselect from "@vueform/multiselect";
import moment from "moment";
import Pagination from "Components/TablePagination.vue";

const props = defineProps({
  organizations: { type: Object, required: true },
  status: { type: Object, required: true },
  roles: { type: Object, required: true },
});

const toastData = reactive({
  visibility: false,
  message: "",
  type: false,
});

const filter = reactive({ organization: [], role: [], status: [] });

const isLoaderVisible = ref(false);
const addUserForm = ref(false);
const editUserForm = ref(false);
// const downloadUsers = ref(false);
const usersData = reactive({});
const isEmpty = ref(true);
const editUserId = ref("");

const formData = reactive({
  username: "",
  full_name: "",
  email: "",
  status: "",
  role: "",
  password: "",
  password_confirmation: "",
});

const isFilterApplied = computed(() => {
  return !!filter.organization.length || !!filter.role.length || !!filter.status.length;
});

onMounted(async () => {
  axios.get(`/users/page/1`).then((res) => {
    const response = res.data;
    Object.assign(usersData, response.data);
    isEmpty.value = response.data.data.length ? false : true;
  });

  setTimeout(() => {
    toastData.visibility = false;
  }, 5000);
});

const createUser = () => {
  let passwordData = {
    password: encrypt(formData.password, process.env.MIX_ENCRYPTION_KEY ?? ""),
    password_confirmation: encrypt(
      formData.password_confirmation,
      process.env.MIX_ENCRYPTION_KEY ?? ""
    ),
  };

  axios
    .post("/user", { ...formData, ...passwordData })
    .then((res) => {
      toastData.visibility = true;
      toastData.message = res.data.message;
      toastData.type = res.data.success;
      isLoaderVisible.value = false;
    })
    .catch((error) => {
      toastData.visibility = true;
      toastData.message = error.data.message;
      toastData.type = false;
      isLoaderVisible.value = false;
    });

  addUserForm.value = false;
};

const editUser = (user) => {
  formData.username = user.username;
  formData.full_name = user.full_name;
  formData.email = user.email;
  formData.role = user.role;
  formData.password = user.password;
  formData.password_confirmation = user.password;
  editUserId.value = user.id;
  editUserForm.value = true;
};

const updateUser = () => {
  let passwordData = {
    password: encrypt(formData.password, process.env.MIX_ENCRYPTION_KEY ?? ""),
    password_confirmation: encrypt(
      formData.password_confirmation,
      process.env.MIX_ENCRYPTION_KEY ?? ""
    ),
  };

  axios
    .patch(`/user/${editUserId.value}}`, { ...formData, ...passwordData })
    .then((res) => {
      toastData.visibility = true;
      toastData.message = res.data.message;
      toastData.type = res.data.success;
      isLoaderVisible.value = false;
    })
    .catch((error) => {
      toastData.visibility = true;
      toastData.message = error.data.message;
      toastData.type = false;
      isLoaderVisible.value = false;
    });

  addUserForm.value = false;
  editUserId.value = "";
};

function fetchUsersList(active_page: number) {
  let route = `/users/page/${active_page}`;
  let params = new URLSearchParams();

  for (const filter_key in filter) {
    if (filter[filter_key].length > 0) {
      params.append(filter_key, filter[filter_key]);
    }
  }

  axios.get(route, { params: params }).then((res) => {
    const response = res.data;
    Object.assign(usersData, response.data);
    isEmpty.value = response.data ? false : true;
  });
}

function deleteUser(id: number) {
  axios
    .delete(`/user/${id}`)
    .then((res) => {
      if (res.status) {
        toastData.visibility = true;
        toastData.message = res.data.message;
        toastData.type = res.data.success;
      }
    })
    .catch((err) => {
      console.log(err);
    });
}

function toggleUserStatus(id: number) {
  axios
    .patch(`/user/status/${id}`)
    .then((res) => {
      if (res.status) {
        toastData.visibility = true;
        toastData.message = res.data.message;
        toastData.type = res.data.success;

        fetchUsersList(usersData["current_page"]);
      }
    })
    .catch((err) => {
      console.log(err);
    });
}

function formatDate(date: Date) {
  return moment(date).format("LL");
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
