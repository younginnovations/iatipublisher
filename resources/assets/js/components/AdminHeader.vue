<template>
  <header
    class="activity__header flex min-h-[60px] max-w-full gap-10 bg-bluecoral px-10 text-xs leading-normal text-white"
  >
    <Toast
      v-if="toastVisibility"
      class="toast -bottom-24"
      :message="toastMessage"
      :type="toastType"
    />
    <figure class="flex items-center grow-0">
      <a href="/activities">
        <svg-vue icon="logo" class="text-4xl" />
      </a>
    </figure>
    <nav class="flex grow-0">
      <ul class="flex flex-wrap">
        <li
          v-for="(language, index) in data.languages"
          :key="index"
          :class="data.languageNavLiClasses"
        >
          <a
            :class="[
              { nav__pointer: language.active },
              data.languageNavAnchorClasses,
            ]"
            :href="language.permalink"
          >
            <span class="">{{ language.language }}</span>
          </a>
        </li>
      </ul>
    </nav>
    <nav class="flex justify-end grow">
      <ul class="flex flex-wrap -mx-4">
        <li
          v-for="(menu, index) in data.menus"
          :key="index"
          :class="data.menuNavLiClasses"
        >
          <a
            :class="[{ nav__pointer: menu.active }, data.menuNavAnchorClasses]"
            :href="menu.permalink"
          >
            <span class="">{{ menu.name }}</span>
          </a>
        </li>
      </ul>
    </nav>
    <div class="flex items-center grow-0">
      <div class="flex items-center">
        <div class="search">
          <input
            v-model="searchValue"
            class="search__input"
            type="text"
            placeholder="Search activity..."
            @keyup.enter="searchFunction"
          />
          <svg-vue class="absolute text-base left-3 top-3" icon="search" />
          <span v-if="spinner" class="spinner" />
        </div>
        <button
          class="button secondary-btn mr-3.5 font-bold"
          @click="modalValue = true"
        >
          <svg-vue icon="add" />
        </button>
        <button class="button secondary-btn dropdown-btn">
          <svg-vue icon="user-profile" />
          <svg-vue class="dropdown__arrow" icon="dropdown-arrow" />
          <div class="profile__dropdown">
            <ul>
              <li class="border-b border-b-n-20">
                <div>
                  <svg-vue class="user-profile" icon="user-profile" />
                </div>
                <div class="flex flex-col leading-4 capitalize break-all">
                  <span class="text-n-50">{{ user.full_name }}</span
                  ><span class="text-tiny text-n-40">{{
                    organization.publisher_name
                  }}</span>
                </div>
              </li>
              <li class="border-b dropdown__list border-b-n-20">
                <svg-vue icon="user" />
                <a href="#">Your Profile</a>
              </li>
              <li class="dropdown__list" @click="logout">
                <svg-vue icon="logout"></svg-vue>
                <button class="text-sm">Logout</button>
              </li>
            </ul>
          </div>
        </button>
      </div>
    </div>

    <!--====================
        Add Activity Modal
    ========================-->
    <CreateModal
      :modal-active="modalValue"
      @close="modalToggle"
      @close-modal="modalToggle"
      @toast="toast"
    />
  </header>
</template>

<script setup lang="ts">
import { defineProps, ref, reactive, onMounted } from 'vue';
import type { Ref } from 'vue';

import axios from 'axios';
import { useToggle } from '@vueuse/core';

import CreateModal from '../views/activity/CreateModal.vue';
import Toast from './Toast.vue';

defineProps({
  user: { type: Object, required: true },
  organization: { type: Object, required: true },
});

const toastVisibility = ref(false);
const toastMessage = ref('');
const toastType = ref(false);

const data = reactive({
  languageNavLiClasses: 'flex',
  languageNavAnchorClasses:
    'flex text-white items-center uppercase nav__pointer-hover px-1.5',
  menuNavLiClasses: 'flex px-4',
  menuNavAnchorClasses:
    'flex text-white items-center uppercase nav__pointer-hover',
  languages: [
    {
      language: 'EN',
      permalink: '#',
      active: true,
    },
    {
      language: 'FR',
      permalink: '#',
      active: false,
    },
    {
      language: 'ES',
      permalink: '#',
      active: false,
    },
  ],
  menus: [
    {
      name: 'Activity DATA',
      permalink: '/activities',
      active: true,
    },
    {
      name: 'Organisation DATA',
      permalink: '#',
      active: false,
    },
    {
      name: 'Settings',
      permalink: '/setting',
      active: false,
    },
  ],
});

const [modalValue, modalToggle] = useToggle();

function toast(message: string, type: boolean) {
  toastVisibility.value = true;
  setTimeout(() => (toastVisibility.value = false), 5000);
  toastMessage.value = message;
  toastType.value = type;
}

function changeActiveMenu() {
  const path = window.location.pathname;

  data.menus.forEach((menu, key) => {
    data.menus[key]['active'] = menu.permalink === path ? true : false;
  });
}

async function logout() {
  await axios.post('/logout').then((res) => {
    if (res.status) {
      window.location.href = '/';
    }
  });
}

/**
 * Search functionality
 *
 */
const searchValue: Ref<string | null> = ref('');
const currentURL = window.location.href;

if (currentURL.includes('?')) {
  const queryString = window.location.search,
    urlParams = new URLSearchParams(queryString),
    search = urlParams.get('q');

  searchValue.value = search;
}

const spinner = ref(false);

const searchFunction = () => {
  spinner.value = true;
  const param = searchValue.value?.replace('#', '');
  let href = param ? `/activities?q=${param}` : '/activities/';
  window.location.href = href;
};

onMounted(async () => {
  changeActiveMenu();
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

<style lang="scss" scoped>
.activity__header {
  nav {
    a:hover {
      @apply text-white;
    }
  }
}
.toast {
  @apply absolute  left-2/4 z-50;
  transform: translate(-50%, -50%);
}
.profile__dropdown {
  @apply invisible absolute right-10 z-20 bg-white text-left text-sm text-bluecoral opacity-0 shadow-dropdown  duration-300;
  top: 50px;
  width: 265px;
  box-shadow: 4px 4px 40px rgba(0, 50, 76, 0.2);

  li {
    @apply flex items-center space-x-3 p-4;

    a:hover {
      @apply text-bluecoral;
    }

    .user-profile {
      font-size: 26px;
    }
  }
  .dropdown__list {
    @apply bg-n-10 hover:bg-n-20 hover:text-bluecoral;

    a {
      @apply capitalize;
    }
  }
}
.dropdown-btn:hover {
  .profile__dropdown {
    @apply visible opacity-100;
    transform: translateY(10px);
  }
  .dropdown__arrow {
    transform: rotate(180deg);
  }
}

.spinner {
  @apply absolute top-3 right-3 inline-block animate-spin rounded-full border-2 border-n-10 border-opacity-5;
  width: 15px;
  height: 15px;
  border-top-color: white;
}
</style>
