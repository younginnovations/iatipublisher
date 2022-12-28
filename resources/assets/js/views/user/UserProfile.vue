<template>
  <div>
    <Loader v-if="isLoaderVisible" />
    <PageTitle bread-crumb-data="{}" :title="user.full_name" back-link="">
      <div class="flex justify-end">
        <a
          @click="
            () => {
              editProfileForm = true;
            }
          "
          ><svg-vue icon="edit" class=""></svg-vue>Edit your profile</a
        >
      </div>
    </PageTitle>
    <Toast
      v-if="toastData.visibility"
      :message="toastData.message"
      :type="toastData.type"
    />

    <div>
      <PopupModal :modal-active="editPasswordForm">
        <div>
          <div class="mb-4 font-bold">Change Password</div>
          <div>
            <div class="flex">
              <label>Current Password</label>
              <input v-model="passwordData.current_password" type="password" />
            </div>
          </div>
          <div class="flex">
            <div class="flex">
              <label>New Password</label>
              <input v-model="passwordData.password" type="password" />
            </div>
            <div class="flex">
              <label>Confirm Password</label>
              <input v-model="passwordData.password_confirmation" type="password" />
            </div>
          </div>
          <div class="flex justify-end">
            <button
              @click="
                () => {
                  editPasswordForm = false;
                }
              "
            >
              Cancel
            </button>
            <button @click="updatePassword">Save</button>
          </div>
        </div>
      </PopupModal>
      <!-- profile edit popup form -->
      <PopupModal :modal-active="editProfileForm">
        <div>
          <div class="mb-4 font-bold">Edit Profile</div>
          <div>
            <div class="flex">
              <label>Username</label>
              <input v-model="formData.username" type="text" />
            </div>
            <div class="flex">
              <label>Full Name</label>
              <input v-model="formData.full_name" type="text" />
            </div>
            <div class="flex">
              <label>Email</label>
              <input v-model="formData.email" type="email" />
            </div>
          </div>
          <div class="flex justify-end">
            <button
              @click="
                () => {
                  editProfileForm = false;
                }
              "
            >
              Cancel
            </button>
            <button @click="updateProfile">Save</button>
          </div>
        </div>
      </PopupModal>
      <div class="flex justify-between">
        <p>Your Information</p>
        <div>
          <a
            @click="
              () => {
                editPasswordForm = true;
              }
            "
          >
            <!-- <svg-vue icon=""></svg-vue> -->
            Change your password
          </a>
        </div>
      </div>
      <table>
        <tr>
          <td>Name</td>
          <td>{{ user.full_name }}</td>
        </tr>
        <tr>
          <td>Username</td>
          <td>{{ user.username }}</td>
        </tr>
        <tr>
          <td>Email</td>
          <td>
            {{ user.email
            }}<span v-if="!user.email_verified_at"
              >You haven't verified your email address yet. Please check for verification
              email sent to you and verify your account,
              <a @click="resendVerificationEmail()">resend verification email</a>
              if you haven't received such and email.</span
            >
          </td>
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

const props = defineProps({ user: { type: Object, required: true } });

const toastData = reactive({
  visibility: false,
  message: "",
  type: false,
});
const isLoaderVisible = ref(false);
const editProfileForm = ref(false);
const editPasswordForm = ref(false);

const formData = reactive({
  username: props.user.username,
  full_name: props.user.full_name,
  email: props.user.email,
});

const passwordData = reactive({
  current_password: "",
  password: "",
  password_confirmation: "",
});

const resendVerificationEmail = () => {
  isLoaderVisible.value = true;

  axios
    .post("/user/verification/email")
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
};

const updatePassword = () => {
  let passwordFormData = {
    current_password: encrypt(
      passwordData.current_password,
      process.env.MIX_ENCRYPTION_KEY ?? ""
    ),
    password: encrypt(passwordData.password, process.env.MIX_ENCRYPTION_KEY ?? ""),
    password_confirmation: encrypt(
      passwordData.password_confirmation,
      process.env.MIX_ENCRYPTION_KEY ?? ""
    ),
    form_type: "password",
  };
  console.log(passwordFormData);

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

  editPasswordForm.value = false;
};

const updateProfile = () => {
  axios
    .post("/update/profile", formData)
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

  editProfileForm.value = false;
};
</script>
