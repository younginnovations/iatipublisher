<template>
  <header
    class="activity__header flex min-h-[60px] max-w-full justify-between gap-5 bg-bluecoral px-5 text-xs leading-normal text-white sm:gap-10 xl:px-10"
  >
    <Toast
      v-if="toastVisibility"
      class="toast -bottom-24"
      :message="toastMessage"
      :type="toastType"
    />
    <div class="flex items-center gap-5">
      <div
        class="hamburger-menu"
        @click="
          () => {
            showSidebar = !showSidebar;
          }
        "
      >
        <div id="hamburger" class="hamburger scale-75">
          <span class="bg-n-20" />
          <span class="bg-n-20" />
          <span class="bg-n-20" />
        </div>
      </div>
      <figure class="flex grow-0 items-center">
        <a href="/activities">
          <svg-vue icon="logo" class="text-4xl" />
        </a>
      </figure>
      <div
        id="activity-menu-overlay"
        @click="
          () => {
            showSidebar = !showSidebar;
          }
        "
      ></div>
    </div>
    <div id="nav-list" class="activity-nav-menu flex w-full justify-between">
      <!-- commented to temporarily hide language buttons -->
      <!-- <nav class="justify-end">
        <ul class="flex">
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
              <span>{{ language.language }}</span>
            </a>
          </li>
        </ul>
      </nav> -->
      <nav>
        <ul class="activity-nav-list -mx-4">
          <li
            v-for="(menu, index) in data[superAdmin ? 'superadmin_menus' : 'org_menus']"
            :key="index"
            :class="data.menuNavLiClasses"
          >
            <a
              v-if="menu.name !== 'Add / Import Activity'"
              :class="[{ nav__pointer: menu.active }, data.menuNavAnchorClasses]"
              :href="menu.permalink"
            >
              <span class="">{{ menu.name }}</span>
            </a>
            <span
              v-if="menu.name === 'Add / Import Activity'"
              :class="[{ nav__pointer: menu.active }, data.menuNavAnchorClasses]"
            >
              <span class="add-import"
                >{{ menu.name }}
                <div
                  v-if="menu.name === 'Add / Import Activity'"
                  class="button__dropdown add-import-dropdown absolute top-full z-10 w-56 -translate-y-3 bg-white p-2 text-left shadow-dropdown transition-all duration-300"
                >
                  <ul class="flex-col">
                    <li>
                      <a
                        class="cursor-pointer"
                        :class="liClass"
                        @click="modalValue = true"
                        >Add activity manually</a
                      >
                    </li>
                    <li>
                      <a href="/import" :class="liClass"
                        >Import activities from .csv/.xml</a
                      >
                    </li>
                  </ul>
                </div>
              </span>
            </span>
            <div v-if="superAdmin || menu.superadmin_access">
              <a
                v-if="menu.name !== 'Add / Import Activity'"
                :class="[{ nav__pointer: menu.active }, data.menuNavAnchorClasses]"
                :href="menu.permalink"
              >
                <span class="">{{ menu.name }}</span>
              </a>
              <span
                v-if="menu.name === 'Add / Import Activity'"
                :class="[{ nav__pointer: menu.active }, data.menuNavAnchorClasses]"
              >
                <span class="add-import">{{ menu.name }}</span>
              </span>
              <div
                v-if="menu.name === 'Add / Import Activity'"
                class="button__dropdown invisible absolute left-4 top-full z-10 w-56 -translate-y-3 bg-white p-2 text-left opacity-0 shadow-dropdown outline transition-all duration-300 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100"
              >
                <ul class="flex-col">
                  <li>
                    <a :class="liClass" @click="modalValue = true"
                      >Add activity manually</a
                    >
                  </li>
                  <li>
                    <a href="/import" :class="liClass"
                      >Import activities from .csv/.xml</a
                    >
                  </li>
                </ul>
              </div>
            </div>
          </li>
        </ul>
      </nav>
    </div>
    <div
      class="user-nav"
      :class="{ 'grow-0': !superAdmin, 'grow justify-end': superAdmin }"
    >
      <div class="user-nav">
        <div class="search">
          <input
            v-if="!superAdmin"
            v-model="searchValue"
            class="search__input mr-3.5"
            type="text"
            placeholder="Search activity..."
            @keyup.enter="searchFunction('/activities')"
          />
          <input
            v-else
            v-model="searchValue"
            class="search__input mr-3.5"
            type="text"
            placeholder="Search organisation..."
            @keyup.enter="searchFunction('/list-organisations')"
          />
          <svg-vue icon="search" />
          <span v-if="spinner" class="spinner" />
        </div>
        <button
          :class="
            isTouchDevice
              ? 'button secondary-btn--touch'
              : 'button secondary-btn dropdown-btn'
          "
          @click="showUserDropdown = !showUserDropdown"
        >
          <svg-vue icon="user-profile" />
          <svg-vue class="dropdown__arrow" icon="dropdown-arrow" />
          <div v-if="!isTouchDevice" class="profile__dropdown">
            <ul>
              <li class="border-b border-b-n-20">
                <div>
                  <svg-vue class="user-profile" icon="user-profile" />
                </div>
                <div class="flex flex-col break-all capitalize leading-4">
                  <span class="text-n-50">
                    {{ user.full_name }}
                  </span>
                  <span class="text-tiny text-n-40">
                    {{ organization?.publisher_name }}
                  </span>
                </div>
              </li>
              <li class="dropdown__list border-b border-b-n-20">
                <a class="flex w-full space-x-4" href="/profile"
                  ><svg-vue class="mx-1 text-base" icon="user" />
                  <span>Your Profile</span></a
                >
              </li>
              <li class="dropdown__list flex" @click="logout">
                <svg-vue class="mr-3 ml-1" icon="logout"></svg-vue>
                <button class="text-sm">Logout</button>
              </li>
            </ul>
          </div>
          <div
            v-else
            :class="
              !showUserDropdown
                ? 'invisible -translate-y-2 opacity-0'
                : 'opacity-1 visible translate-y-0'
            "
            class="profile__dropdown--touch"
          >
            <ul>
              <li class="border-b border-b-n-20">
                <div>
                  <svg-vue class="user-profile" icon="user-profile" />
                </div>
                <div class="flex flex-col break-all capitalize leading-4">
                  <span class="text-n-50">
                    {{ user.full_name }}
                  </span>
                  <span class="text-tiny text-n-40">
                    {{ organization?.publisher_name }}
                  </span>
                </div>
              </li>
              <li class="dropdown__list border-b border-b-n-20">
                <a href="/profile"><svg-vue icon="user" /> Your Profile</a>
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

    <CreateModal
      v-if="!superAdmin"
      :modal-active="modalValue"
      @close="ToggleModel"
      @close-modal="ToggleModel"
      @toast="toast"
    />
  </header>
</template>

<script setup lang="ts">
import {
  defineProps,
  ref,
  reactive,
  onMounted,
  computed,
  onUnmounted,
  Ref,
  watch,
} from "vue";
import axios from "axios";
import { useToggle, useStorage } from "@vueuse/core";
import CreateModal from "../views/activity/CreateModal.vue";
import Toast from "./ToastMessage.vue";

const props = defineProps({
  user: { type: Object, required: true },
  organization: {
    type: Object,
    validator: (v: unknown) =>
      typeof v === "object" || typeof v === "string" || v === null,
    required: false,
    default() {
      return {};
    },
  },
  superAdmin: { type: Boolean, required: true },
});

const showUserDropdown = ref(false);
const toastVisibility = ref(false);
const showSidebar = ref(false);
const toastMessage = ref("");
const toastType = ref(false);
const data = reactive({
  languageNavLiClasses: "flex",
  languageNavAnchorClasses:
    "flex text-white items-center uppercase nav__pointer-hover px-1.5",
  menuNavLiClasses: "flex px-4 relative",
  menuNavAnchorClasses: "flex text-white items-center uppercase nav__pointer-hover",
  languages: [
    {
      language: "EN",
      permalink: "#",
      active: true,
    },
    {
      language: "FR",
      permalink: "#",
      active: false,
    },
    {
      language: "ES",
      permalink: "#",
      active: false,
    },
  ],
  org_menus: [
    {
      name: "Activity DATA",
      permalink: "/activities",
      active: true,
    },
    {
      name: "Organisation DATA",
      permalink: "/organisation",
      active: false,
    },
    {
      name: "Settings",
      permalink: "/setting",
      active: false,
    },
    {
      name: "Add / Import Activity",
      permalink: "#",
      active: false,
    },
    {
      name: "Users",
      permalink: "/users",
      active: false,
    },
  ],
  superadmin_menus: [
    {
      name: "Organisation List",
      permalink: "/list-organisations",
      active: false,
    },
    {
      name: "Users",
      permalink: "/users",
      active: false,
    },
  ],
});

const liClass =
  "block p-2.5 text-n-40 text-tiny uppercase leading-[1.5] font-bold hover:!text-n-50 hover:bg-n-10";
const [modalValue, modalToggle] = useToggle();
function toast(message: string, type: boolean) {
  toastVisibility.value = true;
  setTimeout(() => (toastVisibility.value = false), 15000);
  toastMessage.value = message;
  toastType.value = type;
}
const isTouchDevice = computed(() => {
  return "ontouchstart" in window || navigator.maxTouchPoints > 0;
});
function ToggleModel() {
  modalToggle();
  window.localStorage.removeItem("openAddModel");
}
watch(
  () => showSidebar.value,
  (sidebar) => {
    if (sidebar) {
      document.documentElement.style.overflow = "hidden";
    } else document.documentElement.style.overflow = "auto";
  }
);
function changeActiveMenu() {
  const path = window.location.pathname;
  data.org_menus.forEach((menu, key) => {
    data.org_menus[key]["active"] = menu.permalink === path ? true : false;
  });
  if (
    path.includes("activity") ||
    path.includes("result") ||
    path.includes("indicator")
  ) {
    data.org_menus[0]["active"] = true;
  }
  if (path.includes("organisation")) {
    data.org_menus[1]["active"] = true;
  }
  if (path.includes("import")) {
    data.org_menus[3]["active"] = true;
  }
  if (path.includes("users")) {
    data.org_menus[4]["active"] = true;
    data.superadmin_menus[1]["active"] = true;
  }
  if (path.includes("list-organisations")) {
    data.superadmin_menus[0]["active"] = true;
  }
}

// local storage for publishing
const pa = useStorage("vue-use-local-storage", {
  publishingActivities: localStorage.getItem("publishingActivities") ?? {},
});

async function logout() {
  pa.value.publishingActivities = {};
  await axios.post("/logout").then((res) => {
    if (res.status) {
      window.location.href = "/";
    }
  });
}
/**
 * Search functionality
 *
 */
const searchValue: Ref<string | null> = ref("");
const currentURL = window.location.href;

if (currentURL.includes("?")) {
  const queryString = window.location.search,
    urlParams = new URLSearchParams(queryString),
    search = urlParams.get("q");
  searchValue.value = search;
}

const spinner = ref(false);

const searchFunction = (url: string) => {
  spinner.value = true;
  const param = searchValue.value?.replace("#", "");
  let sortingParam = "";
  if (currentURL.includes("?") && currentURL.includes("&")) {
    const queryString = window.location.search;
    let queryStringArr = queryString.split("&") as [];
    sortingParam = "&" + queryStringArr.slice(1).join("&");
  }
  let href = param
    ? `${url}?q=${param}${sortingParam}`
    : props.superAdmin
    ? "/list-organisations"
    : "/activities/";
  window.location.href = href;
};

onMounted(() => {
  changeActiveMenu();
  if (
    localStorage.getItem("openAddModel") === "true" &&
    window.location.pathname === "/activities"
  ) {
    modalValue.value = true;
  }
});

onUnmounted(() => {
  localStorage.removeItem("openAddModel");
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

<style lang="scss" scoped>
.activity__header {
  position: fixed;
  width: 100vw;
  top: 0px;
  z-index: 100;

  nav {
    display: flex;

    a:hover {
      @apply text-white;
    }
    ul {
      @apply flex;
    }
  }
  .add-btn {
    @media screen and (max-width: 375px) {
      display: none;
    }
  }
  .user-nav {
    @apply flex items-center;
  }
}
.toast {
  @apply absolute  left-2/4 z-50;
  transform: translate(-50%, -50%);
}
.profile__dropdown {
  @apply invisible absolute right-3 z-20 bg-white text-left text-sm text-bluecoral opacity-0 shadow-dropdown duration-300 sm:right-10;
  top: 50px;
  width: 265px;
  box-shadow: 4px 4px 40px rgba(0, 50, 76, 0.2);

  @media screen and (max-width: 640px) {
    width: 220px;
  }

  li {
    @apply flex items-center space-x-3 p-3 sm:p-4;
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
.profile__dropdown--touch {
  @apply absolute  right-5 z-20 bg-white text-left text-sm text-bluecoral shadow-dropdown  duration-300;
  top: 50px;
  width: 265px;
  box-shadow: 4px 4px 40px rgba(0, 50, 76, 0.2);

  @media screen and (max-width: 640px) {
    width: 220px;
  }

  li {
    @apply flex items-center space-x-3 p-3 sm:p-4;
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
.dropdown-btn:hover,
.dropdown-btn:active {
  .profile__dropdown {
    @apply visible opacity-100;
    transform: translateY(10px);
  }
  .dropdown__arrow {
    transform: rotate(180deg);
  }
}
.add-import {
  cursor: pointer;
}
.add-import-dropdown {
  visibility: hidden;
  opacity: 0;
}
.add-import:hover .add-import-dropdown {
  visibility: visible;
  opacity: 1;
  transform: translateY(0);
}

.spinner {
  @apply absolute top-3 right-7 inline-block animate-spin rounded-full border-2 border-n-10 border-opacity-5;
  width: 15px;
  height: 15px;
  border-top-color: white;
}
</style>
