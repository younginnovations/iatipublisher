<template>
  <div>
    <Loader v-if="isLoaderVisible" />
    <PageTitle breadCrumb-data="{}" title="Users" back-link="">
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
          <div class="mb-4 font-bold">Change Password</div>
          <div>
            <div class="flex">
              <label>Full Name</label>
              <input v-model="formData.full_name" type="text" />
            </div>
            <div class="flex justify-end">
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
              <input v-model="formData.status" type="password" />
            </div>
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
      <table>
        <thead>
          <tr>
            Users
          </tr>
          <tr>
            Email
          </tr>
          <tr>
            Organisation Name
          </tr>
          <tr>
            User Role
          </tr>
          <tr>
            Status
          </tr>
          <tr>
            Joined on
          </tr>
        </thead>
        <tr v-for="(user, index) in users" :key="index">
          <td>
            <span>
              {{ user.full_name }}
            </span>
            <span>
              {{ user.username }}
            </span>
          </td>
          <td>{{ user.email }}</td>
          <td>{{ user.org_id }}</td>
          <td>{{ user.role_id }}</td>
          <td>{{ user.status }}</td>
          <td>{{ user.created_on }}</td>
          <td>{{ user.created_on }}</td>
        </tr>
      </table>
    </div>
  </div>
</template>
<script setup lang="ts">
import { defineProps, reactive, ref } from "vue";
import Loader from "../../components/Loader.vue";
import PageTitle from "Components/sections/PageTitle.vue";
import Toast from "Components/ToastMessage.vue";
import axios from "axios";
import PopupModal from "Components/PopupModal.vue";
import encrypt from "Composable/encryption";

const props = defineProps({ users: { type: Object, required: true } });

const toastData = reactive({
  visibility: false,
  message: "",
  type: false,
});
const isLoaderVisible = ref(false);
const addUserForm = ref(false);
const downloadUsers = ref(false);

const formData = reactive({
  username: "",
  full_name: "",
  email: "",
  status: "",
  password: "",
  password_confirmation: "",
});

// const resendVerificationEmail = () => {
//   isLoaderVisible.value = true;

//   axios
//     .post("/user/verification/email")
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
// };

const createUser = () => {
  let passwordFormData = {
    password: encrypt(formData.password, process.env.MIX_ENCRYPTION_KEY ?? ""),
    password_confirmation: encrypt(
      formData.password_confirmation,
      process.env.MIX_ENCRYPTION_KEY ?? ""
    ),
    form_type: "password",
  };

  axios
    .post("/update/password", passwordFormData)
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

// const updateProfile = () => {
//   axios
//     .post("/update/profile", formData)
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

//   editProfileForm.value = false;
// };
</script>
