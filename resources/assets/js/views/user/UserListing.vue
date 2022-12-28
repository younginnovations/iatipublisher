<template>
  <div>
    <Loader v-if="isLoaderVisible" />
    <PageTitle bread-crumb-data="{}" title="Users" back-link="">
      <div class="flex justify-end">
        <button>Download all</button>
        <button
          @click="
            () => {
              addUserForm = true;
            }
          "
        >
          Add a new superadmin
        </button>
      </div>
    </PageTitle>
    <Toast
      v-if="toastData.visibility"
      :message="toastData.message"
      :type="toastData.type"
    />

    <div>
      <PopupModal :modal-active="addUserForm">
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
                }
              "
            >
              Cancel
            </button>
            <button @click="createUser">Save</button>
          </div>
        </div>
      </PopupModal>
      <div class="filters flex-between">
        <div class="select filters flex">
          <Multiselect
            v-model="filter.organization"
            :options="organizations"
            placeholder="Select organization"
            :searchable="true"
            :multiple="true"
            :close-on-select="false"
            :clear-on-select="false"
          />
          <Multiselect
            v-model="filter.roles"
            :options="roles"
            placeholder="Select roles"
            :searchable="true"
            mode="multiple"
            :close-on-select="false"
            :clear-on-select="false"
          />
          <Multiselect
            v-model="filter.status"
            :options="status"
            mode="multiple"
            placeholder="Select status"
            :searchable="true"
          />
        </div>
        <div class="open-text"><input type="text" placeholder="Search" /></div>
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
                <p>Edit</p>
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
import { defineProps, reactive, ref, onMounted } from "vue";
import Loader from "../../components/Loader.vue";
import PageTitle from "Components/sections/PageTitle.vue";
import Toast from "Components/ToastMessage.vue";
import axios from "axios";
import PopupModal from "Components/PopupModal.vue";
import encrypt from "Composable/encryption";
import Multiselect from "@vueform/multiselect";
import moment from "moment";
import Pagination from "Components/TablePagination.vue";

defineProps({
  organizations: { type: Object, required: true },
  status: { type: Object, required: true },
  roles: { type: Object, required: true },
});

const toastData = reactive({
  visibility: false,
  message: "",
  type: false,
});

const filter = reactive({ organization: [], roles: [], status: [] });

const isLoaderVisible = ref(false);
const addUserForm = ref(false);
// const downloadUsers = ref(false);
const usersData = reactive({});
const isEmpty = ref(true);

const formData = reactive({
  username: "",
  full_name: "",
  email: "",
  status: "",
  role: "",
  password: "",
  password_confirmation: "",
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

// const updateUser = (id: number) => {
//   let passwordData = {
//     password: encrypt(formData.password, process.env.MIX_ENCRYPTION_KEY ?? ""),
//     password_confirmation: encrypt(
//       formData.password_confirmation,
//       process.env.MIX_ENCRYPTION_KEY ?? ""
//     ),
//   };

//   axios
//     .put(`/user/${id}`, { ...formData, ...passwordData })
//     .then((res) => {
//       toastData.visibility = true;
//       toastData.message = res.data.message;
//       toastData.type = res.data.success;
//       isLoaderVisible.value = false;
//     })
//     .catch((error) => {
//       toastData.visibility = true;
//       toastData.message = error.data.message;
//       toastData.type = false;
//       isLoaderVisible.value = false;
//     });

//   addUserForm.value = false;
// };

function fetchUsersList(active_page: number) {
  console.log("test");
  axios.get(`/users/page/` + active_page).then((res) => {
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
