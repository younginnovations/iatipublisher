<template>
  <div class="wrapper smooth relative bg-bluecoral sm:h-72">
    <div class="mx-3 sm:mx-10 xl:mx-24 xl:px-1">
      <header class="header relative z-10 grid">
        <nav
          class="relative z-10 mt-6 flex items-center justify-between rounded-md bg-white px-3 pt-5 text-xs sm:mt-12 sm:px-10"
        >
          <a class="pb-5" href="/">
            <svg-vue class="w-52 text-6xl sm:w-60" icon="header-logo" />
          </a>
          <div>
            <ul
              id="nav-list"
              class="nav__list flex pt-10 uppercase leading-5 xl:space-x-3"
            >
              <li class="nav__links active dropdown">
                <a href="/about">{{ language.web_lang.about }}</a>
                <NavDropdown
                  :name="language.web_lang.about"
                  :text="language.web_lang.header.about_hover_text"
                  :btn-text="language.button_lang.learn_more"
                  btn-link="/about"
                />
              </li>
              <li class="nav__links active dropdown">
                <a href="/publishing-checklist">{{
                  language.web_lang.publishing_checklist
                }}</a>
                <NavDropdown
                  :name="language.web_lang.publishing_checklist"
                  :text="
                    language.web_lang.header.publishing_checklist_hover_text
                  "
                  :btn-text="language.button_lang.read_more"
                  btn-link="/publishing-checklist"
                />
              </li>
              <li class="nav__links active dropdown relative">
                <a href="/iati-standard">{{
                  language.web_lang.iati_standard
                }}</a>
                <NavDropdown
                  :name="language.web_lang.iati_standard"
                  :text="language.web_lang.header.iati_standard_hover_text"
                  :btn-text="language.button_lang.see_all_data_fields"
                  btn-link="/iati-standard"
                />
              </li>
              <li class="nav__links active dropdown">
                <a href="/support">{{ language.web_lang.support }}</a>
                <NavDropdown
                  :name="language.web_lang.support"
                  :text="language.web_lang.header.support_hover_text"
                  :btn-text="language.button_lang.read_more"
                  btn-link="/support"
                />
              </li>
              <li class="flex xl:hidden">
                <span class="mr-2 pt-5 pb-5 uppercase xl:pt-0"
                  >{{ language.web_lang.language }}:</span
                >
                <ul class="flex items-center justify-center">
                  <li class="nav__links language-hover">
                    <a
                      :class="
                        language.web_lang.active === 'en'
                          ? 'nav__active links__active'
                          : ''
                      "
                      href="/lang/en"
                      >EN</a
                    >
                  </li>
                  <li class="nav__links language-hover">
                    <a
                      :class="
                        language.web_lang.active === 'fr'
                          ? 'nav__active links__active'
                          : ''
                      "
                      href="/lang/fr"
                      >FR</a
                    >
                  </li>
                  <li class="nav__links language-hover">
                    <a
                      :class="
                        language.web_lang.active === 'es'
                          ? 'nav__active links__active'
                          : ''
                      "
                      href="/lang/es"
                      >ES</a
                    >
                  </li>
                </ul>
              </li>
            </ul>
          </div>

          <!-- remove width later -->
          <div class="languages hidden w-[170px] pt-11 xl:block">
            <div class="flex">
              <span class="mr-2 pt-5 pb-5 uppercase xl:pt-0"
                >{{ language.web_lang.language }}:</span
              >
              <ul class="flex items-center justify-center">
                <li class="nav__links">
                  <a
                    :class="
                      language.web_lang.active === 'en'
                        ? 'nav__active links__active'
                        : ''
                    "
                    href="/lang/en"
                    >EN</a
                  >
                </li>
                <li class="nav__links">
                  <a
                    :class="
                      language.web_lang.active === 'fr'
                        ? 'nav__active links__active'
                        : ''
                    "
                    href="/lang/fr"
                    >FR</a
                  >
                </li>
                <li class="nav__links">
                  <a
                    :class="
                      language.web_lang.active === 'es'
                        ? 'nav__active links__active'
                        : ''
                    "
                    href="/lang/es"
                    >ES</a
                  >
                </li>
              </ul>
            </div>
          </div>

          <div id="menu-overlay"></div>
          <div
            id="hamburger"
            class="hamburger home-burger-menu mb-4 scale-90 xl:hidden"
          >
            <span class="bg-bluecoral" />
            <span class="bg-bluecoral" />
            <span class="bg-bluecoral" />
          </div>
        </nav>
        <div
          class="header__title mt-6 flex flex-wrap items-center justify-between gap-2 border-l-4 border-l-turquoise py-2 px-4 sm:py-5 sm:px-6"
        >
          <h1
            class="text-xl font-bold normal-case text-white sm:text-4xl sm:text-heading-2"
          >
            {{ title }}
          </h1>
          <a
            v-if="auth === '1'"
            :href="superAdmin ? '/list-organisations' : '/activities'"
            class="button secondary-btn"
          >
            {{
              superAdmin
                ? `${language.common_lang.go_to} ${language.common_lang.org_list}`
                : `${language.common_lang.go_to} ${language.activity_lang.your_activities_label}`
            }}
            <svg-vue class="text-2xl" icon="right-arrow" />
          </a>
        </div>
      </header>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, onUnmounted } from 'vue';
import NavDropdown from '../../../components/NavDropdown.vue';

export default defineComponent({
  components: {
    NavDropdown,
  },
  props: {
    title: { type: String, required: true },
    auth: { type: String, required: true },
    superAdmin: { type: Boolean, required: false, default: false },
  },
  setup() {
    onMounted(() => {
      document.body.classList.add('no-nav');
    });
    onUnmounted(() => {
      document.body.classList.remove('no-nav');
    });
    const language = window['globalLang'];
    return { language };
  },
});
</script>
