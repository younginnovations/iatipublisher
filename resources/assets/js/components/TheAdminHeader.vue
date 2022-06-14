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
    <figure class="flex grow-0 items-center">
      <a href="/activities">
        <svg-vue
          icon="logo"
          class="text-4xl"
        />
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
    <nav class="flex grow justify-end">
      <ul class="-mx-4 flex flex-wrap">
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
    <div class="flex grow-0 items-center">
      <div class="flex items-center">
        <div class="search">
          <input
            class="search__input"
            type="text"
            placeholder="Search activity..."
          >
          <svg-vue
            class="absolute left-3 top-3 text-base"
            icon="search"
          />
        </div>
        <!--        <input type="text" v-model="keyword">-->
        <button
          class="button secondary-btn mr-3.5 font-bold"
          @click="modalValue = true"
        >
          <svg-vue icon="add" />
        </button>
        <button class="button secondary-btn dropdown-btn">
          <svg-vue icon="user-profile" />
          <svg-vue
            class="dropdown__arrow"
            icon="dropdown-arrow"
          />
          <div class="profile__dropdown">
            <ul>
              <li class="border-b border-b-n-20">
                <div>
                  <svg-vue
                    class="user-profile"
                    icon="user-profile"
                  />
                </div>
                <div class="flex flex-col break-all capitalize leading-4">
                  <span class="text-n-50">{{ props.user.full_name }}</span><span class="text-tiny text-n-40">{{
                    props.organization.publisher_name
                  }}</span>
                </div>
              </li>
              <li class="dropdown__list border-b border-b-n-20">
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
      @closeModal="modalToggle"
      @toast="toast"
    />
  </header>
</template>

<script lang="ts">
import { defineComponent, ref, reactive, onMounted } from 'vue';
import axios from 'axios';
import { useToggle } from '@vueuse/core';
import CreateModal from '../views/activity/CreateModal.vue';
import Toast from './Toast.vue';

export default defineComponent({
  name: 'HeaderComponent',
  components: {
    CreateModal,
    Toast,
  },
  props: {
    user: {
      type: Object,
      required: true,
    },
    organization: {
      type: Object,
      required: true,
    },
  },

  setup(props) {
    const toastVisibility = ref(false);
    const toastMessage = ref('');
    const toastType = ref(false);

    const activeTab = ref('activities');
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

    const state = reactive({
      isVisible: false,
    });

    const toggle = () => {
      state.isVisible = !state.isVisible;
    };

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

    onMounted(async () => {
      changeActiveMenu();
    });

    return {
      props,
      data,
      modalValue,
      toastVisibility,
      toastMessage,
      toastType,
      toast,
      toggle,
      activeTab,
      modalToggle,
      logout,
    };
  },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

<style lang="scss">
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
</style>
