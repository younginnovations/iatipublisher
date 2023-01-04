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
          class="primary-btn"
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
        <div class="popup-model h-auto">
          <div class="mb-4 text-2xl font-bold text-bluecoral">
            Change Password
          </div>
          <div>
            <div class="mb-5 flex flex-col gap-2">
              <label class="text-sm text-n-50"
                >Current Password <span class="text-[red]"> * </span>
              </label>
              <span class="relative max-w-[calc(50%_-_12px)]">
                <svg-vue
                  @click="
                    () => {
                      showCurrentPassword = !showCurrentPassword;
                    }
                  "
                  icon="hide-password"
                  class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer text-lg"
                ></svg-vue>
                <input
                  class="w-full rounded border border-n-30 p-3"
                  v-model="passwordData.current_password"
                  :type="showCurrentPassword ? 'text' : 'password'"
                />
              </span>
            </div>
          </div>
          <div class="mb-5 flex space-x-6">
            <div class="flex w-full flex-col gap-2">
              <label class="text-sm text-n-50"
                >New Password <span class="text-[red]"> * </span>
              </label>
              <span class="relative">
                <svg-vue
                  @click="
                    () => {
                      showNewPassword = !showNewPassword;
                    }
                  "
                  icon="hide-password"
                  class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer text-lg"
                ></svg-vue>
                <input
                  class="w-full rounded border border-n-30 p-3"
                  v-model="passwordData.password"
                  :type="showNewPassword ? 'text' : 'password'"
              /></span>
            </div>
            <div class="flex w-full flex-col gap-2">
              <label class="text-sm text-n-50"
                >Confirm Password <span class="text-[red]"> * </span>
              </label>
              <span class="relative">
                <svg-vue
                  @click="
                    () => {
                      showConfirmPassword = !showConfirmPassword;
                    }
                  "
                  icon="hide-password"
                  class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer text-lg"
                ></svg-vue
                ><input
                  class="w-full rounded border border-n-30 p-3"
                  v-model="passwordData.password_confirmation"
                  :type="showConfirmPassword ? 'text' : 'password'"
              /></span>
            </div>
          </div>
          <div class="mt-6 flex justify-end space-x-2">
            <button
              class="secondary-btn font-bold"
              @click="
                () => {
                  editPasswordForm = false;
                }
              "
            >
              Cancel
            </button>
            <button class="primary-btn !px-10" @click="updatePassword">
              Save
            </button>
          </div>
        </div>
      </PopupModal>
      <!-- profile edit popup form -->
      <PopupModal :modal-active="editProfileForm">
        <div class="popup-model">
          <div class="mb-4 text-2xl font-bold text-bluecoral">
            Edit your profile
          </div>
          <div class="grid grid-cols-2 gap-6">
            <div class="col-span-2 flex flex-col items-start gap-2">
              <label class="text-sm text-n-50"
                >Full Name<span class="text-[red]"> * </span></label
              >
              <input
                class="w-full rounded border border-n-30 p-3"
                v-model="formData.full_name"
                type="text"
              />
            </div>
            <div class="flex flex-col items-start gap-2">
              <label class="text-sm text-n-50"
                >Username<span class="text-[red]"> * </span></label
              >
              <input
                class="w-full rounded border border-n-30 p-3"
                v-model="formData.username"
                type="text"
              />
            </div>

            <div class="flex flex-col items-start gap-2">
              <label class="text-sm text-n-50"
                >Email<span class="text-[red]"> * </span></label
              >
              <input
                class="w-full rounded border border-n-30 p-3"
                v-model="formData.email"
                type="email"
              />
            </div>
          </div>
          <div class="mt-6 flex justify-end space-x-2">
            <button
              class="secondary-btn font-bold"
              @click="
                () => {
                  editProfileForm = false;
                }
              "
            >
              Cancel
            </button>
            <button class="primary-btn !px-10" @click="updateProfile">
              Save
            </button>
          </div>
        </div>
      </PopupModal>
      <div class="flex justify-between border-b border-n-30 py-6">
        <span class="inline-flex items-center space-x-2">
          <span><svg-vue icon="user-profile" class="text-base"></svg-vue></span>
          <h6 class="text-sm font-bold">Your Information</h6></span
        >
        <div class="inline-flex">
          <div class="inline-flex cursor-pointer space-x-1">
            <span><svg-vue icon="key" class="text-base"></svg-vue></span>
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

      <div class="flex space-x-2 border-b border-n-20 py-6">
        <div class="text-base font-bold text-n-40">Name</div>
        <div class="text-base">{{ user.full_name }}</div>
      </div>
      <div class="flex space-x-2 border-b border-n-20 py-6">
        <div class="text-base font-bold text-n-40">Username</div>
        <div class="text-base">{{ user.username }}</div>
      </div>
      <div class="flex space-x-2 border-b border-n-20 py-6">
        <div class="text-base font-bold text-n-40">Language Preference</div>
        <div class="text-base">English</div>
      </div>
      <div class="flex space-x-2 py-6">
        <div class="text-base font-bold text-n-40">Email</div>
        <div>
          <a>{{ user.email }}</a>
          <div
            v-if="!user.email_verified_at"
            class="mt-1 max-w-[550px] text-n-40"
          >
            You haven't verified your email address yet. Please check for
            verification email sent to you and verify your account,
            <a
              class="cursor-pointer font-bold underline"
              @click="resendVerificationEmail()"
              >resend verification email</a
            >
            if you haven't received such and email.
          </div>
        </div>
      </div>
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
const showCurrentPassword = ref(false);
const showNewPassword = ref(false);
const showConfirmPassword = ref(false);

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
