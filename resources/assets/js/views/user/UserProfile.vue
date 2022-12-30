<template>
  <div class="px-10">
    <Loader v-if="isLoaderVisible" />
    <nav aria-label="breadcrumbs" class="rank-math-breadcrumb my-4">
      <div class="flex">
        <a class="whitespace-nowrap font-bold" href="/activities">
          Your Activities
        </a>
        <span class="separator mx-4"> / </span>
        <div class="breadcrumb__title">
          <span
            class="breadcrumb__title last max-w-lg overflow-hidden text-n-30"
            >{{ user.full_name ?? 'Untitled' }}</span
          >
          <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">{{
            user.full_name ? user.full_name : 'Untitled'
          }}</span>
        </div>
      </div>
    </nav>

    <!-- <PageTitle
      bread-crumb-data="data"
      :title="user.full_name"
      back-link="/activities"
    >
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
    </PageTitle> -->
    <div class="flex justify-between">
      <div class="inline-flex items-center">
        <div class="mr-3">
          <a href="/activities">
            <svg-vue icon="arrow-short-left"></svg-vue>
          </a>
        </div>
        <div class="text-[30px] font-bold">{{ user.full_name }}</div>
      </div>
      <div>
        <button
          class="rounded bg-bluecoral p-3 text-white"
          @click="
            () => {
              editProfileForm = true;
            }
          "
        >
          <svg-vue icon="edit" class="mr-1 text-base"></svg-vue
          ><span class="text-xs uppercase">Edit your profile</span>
        </button>
      </div>
    </div>
    <Toast
      v-if="toastData.visibility"
      :message="toastData.message"
      :type="toastData.type"
    />

    <div class="my-4 rounded-lg bg-white p-8">
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
              <input
                v-model="passwordData.password_confirmation"
                type="password"
              />
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
      <div class="flex justify-between border-b border-n-30 py-6">
        <span class="inline-flex space-x-2">
          <span>i</span>
          <h6 class="text-sm font-bold">Your Information</h6></span
        >
        <div class="inline-flex">
          <div class="inline-flex cursor-pointer space-x-1">
            <span>i</span>
            <a
              class="text-sm font-bold text-bluecoral"
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
      </div>
      <table>
        <tr class="py-6">
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
              >You haven't verified your email address yet. Please check for
              verification email sent to you and verify your account,
              <a @click="resendVerificationEmail()"
                >resend verification email</a
              >
              if you haven't received such and email.</span
            >
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>
<script setup lang="ts">
import { defineProps, reactive, ref } from 'vue';
import Loader from '../../components/Loader.vue';
import PageTitle from 'Components/sections/PageTitle.vue';
import Toast from 'Components/ToastMessage.vue';
import axios from 'axios';
import PopupModal from 'Components/PopupModal.vue';
import encrypt from 'Composable/encryption';

const props = defineProps({ user: { type: Object, required: true } });

const toastData = reactive({
  visibility: false,
  message: '',
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
  current_password: '',
  password: '',
  password_confirmation: '',
});

const resendVerificationEmail = () => {
  isLoaderVisible.value = true;

  axios
    .post('/user/verification/email')
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
      process.env.MIX_ENCRYPTION_KEY ?? ''
    ),
    password: encrypt(
      passwordData.password,
      process.env.MIX_ENCRYPTION_KEY ?? ''
    ),
    password_confirmation: encrypt(
      passwordData.password_confirmation,
      process.env.MIX_ENCRYPTION_KEY ?? ''
    ),
    form_type: 'password',
  };
  console.log(passwordFormData);

  axios
    .post('/update/password', passwordFormData)
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
    .post('/update/profile', formData)
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
