<template>
  <div class="wrapper relative h-56 bg-bluecoral sm:h-72">
    <div class="mx-3 sm:mx-10 xl:mx-24 xl:px-1">
      <header class="relative z-10 grid">
        <nav
          class="relative z-10 mt-6 flex items-center justify-between rounded-md bg-white px-5 pt-5 text-xs sm:mt-12 sm:px-10"
        >
          <a class="pb-5" href="#">
            <svg-vue class="w-52 text-6xl sm:w-60" icon="header-logo"></svg-vue>
          </a>
          <div>
            <ul
              id="nav-list"
              class="nav__list flex pt-10 leading-5 xl:space-x-3"
            >
              <li class="nav__links active dropdown">
                <a href="#about">{{ props.translation.about }}</a>
                <NavDropdown
                  :name="props.translation.about"
                  :text="props.translation.about_description"
                  :btnText="props.translation.learn_more"
                ></NavDropdown>
              </li>
              <li class="nav__links active dropdown">
                <a href="#step-by-step-publishing-guide">{{
                  props.translation.publishing_checklist
                }}</a>
                <NavDropdown
                  :name="props.translation.publishing_checklist"
                  :text="props.translation.publishing_checklist_description"
                  :btnText="props.translation.read_more"
                ></NavDropdown>
              </li>
              <li class="nav__links active dropdown relative">
                <a href="#iati-standard">{{
                  props.translation.iati_standard
                }}</a>
                <NavDropdown
                  :name="props.translation.iati_standard"
                  :text="props.translation.iati_standard_description"
                  :btnText="props.translation.see_all_data_fields"
                ></NavDropdown>
              </li>
              <li class="nav__links active dropdown">
                <a href="#support">{{ props.translation.support }}</a>
                <NavDropdown
                  :name="props.translation.support"
                  :text="props.translation.support_description"
                  :btnText="props.translation.read_more"
                ></NavDropdown>
              </li>
              <li class="absolute bottom-4 left-0 right-0 xl:hidden">
                <div class="flex items-center justify-center">
                  <span class="mr-2 pt-5 pb-5 uppercase text-white xl:pt-0"
                    >{{ props.translation.language }}:</span
                  >
                  <ul class="languages flex items-center justify-center">
                    <li class="nav__links">
                      <a class="nav__active links__active" href="#">{{
                        props.translation.en
                      }}</a>
                    </li>
                    <li class="nav__links">
                      <a href="#">{{ props.translation.fr }}</a>
                    </li>
                    <li class="nav__links">
                      <a href="#">{{ props.translation.es }}</a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
          <div class="languages hidden pt-11 xl:block">
            <div class="flex">
              <span class="mr-2 pt-5 pb-5 uppercase xl:pt-0"
                >{{ props.translation.language }}:</span
              >
              <ul class="flex items-center justify-center">
                <li class="nav__links">
                  <a class="nav__active links__active" href="#">{{
                    props.translation.en
                  }}</a>
                </li>
                <li class="nav__links">
                  <a href="#">{{ props.translation.fr }}</a>
                </li>
                <li class="nav__links">
                  <a href="#">{{ props.translation.es }}</a>
                </li>
              </ul>
            </div>
          </div>
          <div
            id="hamburger"
            class="hamburger relative mb-4 flex h-11 w-11 cursor-pointer items-center justify-center overflow-hidden rounded xl:hidden"
          >
            <span
              class="absolute h-1 w-10 rounded-lg bg-bluecoral duration-300"
            ></span>
            <span
              class="absolute h-1 w-10 rounded-lg bg-bluecoral duration-300"
            ></span>
            <span
              class="absolute h-1 w-10 rounded-lg bg-bluecoral duration-300"
            ></span>
          </div>
        </nav>
        <div
          class="header__title mt-6 border-l-4 border-l-turquoise py-2 px-4 sm:py-5 sm:px-6"
        >
          <h1 class="text-4xl font-bold text-white sm:text-heading-2">
            {{ props.translation.iati_publisher }}
          </h1>
        </div>
      </header>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import NavDropdown from '../../../components/NavDropdown.vue';

export default defineComponent({
  components: {
    NavDropdown,
  },
  props: {
    translation: String,
  },
  setup(props) {
    return {
      props,
    };
  },
});
</script>
