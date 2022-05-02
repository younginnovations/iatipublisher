<template>
  <header
    class="flex min-h-[60px] max-w-full gap-10 bg-bluecoral px-10 text-xs leading-normal text-white"
  >
    <figure class="flex grow-0 items-center">
      <a href="/">
        <svg-vue icon="logo" class="text-4xl"></svg-vue>
      </a>
    </figure>
    <nav class="flex grow-0">
      <ul class="flex flex-wrap">
        <li
          v-for="(language, index) in data.languages"
          :class="data.languageNavLiClasses"
          v-bind:key="index"
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
          v-bind:key="index"
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
          />
          <svg-vue
            class="absolute left-3 top-3 text-base"
            icon="search"
          ></svg-vue>
        </div>
        <!--        <input type="text" v-model="keyword">-->
        <button class="button secondary-btn mr-3.5 font-bold">
          <svg-vue icon="add"></svg-vue>
        </button>
        <button
          class="button secondary-btn dropdown-btn"
          @click="toggle"
          ref="dropdownBtn"
        >
          <svg-vue icon="user-profile"></svg-vue>
          <svg-vue
            :class="
              state.isVisible ? 'dropdown__arrow rotate-180' : 'dropdown__arrow'
            "
            icon="dropdown-arrow"
          ></svg-vue>
        </button>
        <div v-show="state.isVisible" class="profile__dropdown" ref="dropdown">
          <ul>
            <li class="border-b border-b-n-20">
              <svg-vue class="user-profile" icon="user-profile"></svg-vue>
              <div class="flex flex-col capitalize leading-4">
                <span class="text-n-50">{{ props.user.full_name }}</span
                ><span class="text-tiny text-n-40">{{
                  props.organization.publisher_name
                }}</span>
              </div>
            </li>
            <li class="dropdown__list border-b border-b-n-20">
              <svg-vue icon="user"></svg-vue>
              <a href="#">Your Profile</a>
            </li>
            <li class="dropdown__list" @click="logout">
              <svg-vue icon="logout"></svg-vue>
              <a href="#">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </header>
</template>

<script lang="ts">
import { reactive, defineComponent, onMounted, ref } from 'vue';
import axios from 'axios';

export default defineComponent({
  name: 'header-component',

  components: {},

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
    const dropdown = ref();
    const dropdownBtn = ref();
    const data = {
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
          permalink: 'activities',
          active: true,
        },
        {
          name: 'Organisation DATA',
          permalink: '#',
          active: false,
        },
        {
          name: 'Settings',
          permalink: 'setting',
          active: false,
        },
      ],
    };
    const state = reactive({
      isVisible: false,
    });

    onMounted(() => {
      window.addEventListener('click', (e) => {
        if (
          !dropdownBtn.value.contains(e.target) &&
          !dropdown.value.contains(e.target)
        ) {
          state.isVisible = false;
        }
      });
    });

    const toggle = () => {
      state.isVisible = !state.isVisible;
    };

    async function logout() {
      await axios.post('/logout').then((res) => {
        if (res.status) {
          window.location.href = '/';
        }
      });
    }

    return {
      props,
      data,
      state,
      dropdown,
      dropdownBtn,
      toggle,
      logout,
    };
  },
});
</script>

<style lang="scss">
.search {
  position: relative;

  &__input {
    @apply mr-3.5 border border-n-30 bg-transparent outline-none;
    border-radius: 20px;
    padding: 10px 42px 10px 34px;
  }
}

.profile__dropdown {
  @apply absolute right-10 z-20 bg-white text-left text-sm text-bluecoral shadow-dropdown;
  top: 60px;
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
  }
}
</style>
