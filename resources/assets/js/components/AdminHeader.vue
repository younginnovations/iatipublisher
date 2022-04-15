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
        <button
          @click="modalValue = true"
          class="button secondary-btn mr-3.5 font-bold"
        >
          <svg-vue icon="plus"></svg-vue>
        </button>
        <button class="button secondary-btn font-bold">
          <svg-vue icon="user-profile"></svg-vue>
        </button>
      </div>
    </div>

    <!--====================
        Add Activity Modal
    ========================-->
    <Modal @close="modalToggle" :modalActive="modalValue">
      <h5 class="title mb-5 flex text-2xl font-bold text-bluecoral">
        Add a title and identifier for the activity
      </h5>
      <div>
        <form>
          <div class="mb-5">
            <div class="form-group-title-container">
              <HoverText
                :name="'title'"
                :hover_text="'Help text'"
                position="left"
              ></HoverText>
              <p class="form-group-title">title</p>
            </div>
            <div class="form-group">
              <div class="form__content">
                <div>
                  <div class="flex items-center justify-between">
                    <label class="label" for=""
                      >narrative
                      <span class="text-salmon-40"> *</span>
                    </label>
                    <HoverText
                      :name="'test'"
                      :hover_text="'UNFPA Angola Improved national population data systems to map and address inequalities; to advance the achievement of the Sustainable Development Goals and the commitments of the Programme of Action of the International Conference on Population and Development'"
                      :link="'https://google.com'"
                    ></HoverText>
                  </div>
                  <input
                    class="error__input form__input"
                    type="text"
                    placeholder="Enter an activity title"
                  />

                  <span class="text-xs font-normal text-n-40"
                    >This is a help text
                  </span>
                </div>
                <div>
                  <div class="flex items-center justify-between">
                    <label class="label" for=""
                      >@xml: lang
                      <span class="text-salmon-40"> *</span>
                    </label>
                    <HoverText
                      :name="'test'"
                      :hover_text="'lorem ipsum'"
                    ></HoverText>
                  </div>

                  <Multiselect
                    class="vue__select"
                    :searchable="true"
                    :options="{ one: 'one', two: 'two' }"
                  />

                  <span class="text-xs font-normal text-n-40"
                    >This is a help text
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div>
            <div class="form-group-title-container">
              <HoverText
                :name="'title'"
                :hover_text="'Help text'"
                position="left"
              ></HoverText>
              <p class="form-group-title">iati-identifier</p>
            </div>
            <div class="form-group">
              <div class="form__content">
                <div>
                  <div class="flex items-center justify-between">
                    <label class="label" for=""
                      >activity identifier
                      <span class="text-salmon-40"> *</span>
                    </label>
                    <HoverText
                      :name="'test'"
                      :hover_text="'lorem ipsum'"
                    ></HoverText>
                  </div>
                  <Multiselect
                    class="vue__select"
                    :searchable="true"
                    :options="{ one: 'one', two: 'two' }"
                  />

                  <span class="text-xs font-normal text-n-40"
                    >This is a help text
                  </span>
                </div>
                <div>
                  <div class="flex items-center justify-between">
                    <label class="label" for=""
                      >iati-identifier
                      <span class="text-salmon-40"> *</span>
                    </label>
                    <HoverText
                      :name="'test'"
                      :hover_text="'lorem ipsum'"
                    ></HoverText>
                  </div>
                  <input
                    class="error__input form__input"
                    type="text"
                    placeholder="Unique activity identifier"
                  />

                  <span class="text-xs font-normal text-n-40"
                    >This is a help text
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="mt-8 flex justify-end">
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
                text="Save"
              />
            </div>
          </div>
        </form>
      </div>
    </Modal>
  </header>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useToggle } from '@vueuse/core';
import Multiselect from '@vueform/multiselect';

import Modal from './PopupModal.vue';
import BtnComponent from './ButtonComponent.vue';
import HoverText from './HoverText.vue';

export default defineComponent({
  name: 'header-component',
  components: {
    Modal,
    BtnComponent,
    HoverText,
    Multiselect,
  },
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
    const [modalValue, modalToggle] = useToggle();
    return {
      data,
      modalValue,
      modalToggle,
    };
  },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

<style lang="scss">
.form-group {
  @apply rounded-lg border border-n-20 p-5;

  &:last-child {
    margin-bottom: 0;
  }

  .form__content {
    margin-top: 0;
  }
}
.form-group-title-container {
  @apply mb-1 flex space-x-1;
}
.form-group-title {
  @apply text-xs font-bold text-bluecoral;
}
</style>
