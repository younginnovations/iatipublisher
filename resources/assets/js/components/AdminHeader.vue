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
      <div class="flex">
        <button class="button secondary-btn mr-3.5 font-bold">
          <svg-vue icon="plus"></svg-vue>
        </button>

        <!--====================
        Add Activity Modal
    ========================-->
        <Modal @close="modalToggle" :modalActive="modalValue">
          <h5 class="title mb-6 flex">
            Add a title and identifier for the activity
          </h5>
          <div class="flex justify-end">
            <div class="inline-flex">
              <BtnComponent
                class="bg-white px-6 uppercase"
                @click="modalValue = false"
                text="Cancel"
              />
              <BtnComponent
                class="space"
                type="primary"
                @click="modalValue = false"
                text="Publish"
              />
            </div>
          </div>
        </Modal>

        <button class="button secondary-btn font-bold">
          <svg-vue icon="user-profile"></svg-vue>
        </button>
      </div>
    </div>
  </header>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useToggle } from '@vueuse/core';

export default defineComponent({
  name: 'header-component',
  components: {},
  setup() {
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
          permalink: '#',
          active: true,
        },
        {
          name: 'Organisation DATA',
          permalink: '#',
          active: false,
        },
        {
          name: 'Settings',
          permalink: '#',
          active: false,
        },
      ],
    };
    const [modalValue, modalToggle] = useToggle();
    return {
      data,
      modalValue,
      modalToggle,
    };
  },
});
</script>
