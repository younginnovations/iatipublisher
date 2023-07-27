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
          <div class="basis-4/6">
            <ul
              id="nav-list"
              class="nav__list flex justify-between pt-10 uppercase leading-5 xl:flex-row-reverse"
            >
              <li class="flex">
                <span class="mr-2 pt-5 pb-5 uppercase xl:pt-0"
                  >{{ translate.webText('language') }}:</span
                >
                <ul class="flex items-center justify-center">
                  <li class="nav__links language-hover">
                    <a
                      :class="
                        translate.webText('active') === 'en'
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
                        translate.webText('active') === 'fr'
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
                        translate.webText('active') === 'es'
                          ? 'nav__active links__active'
                          : ''
                      "
                      href="/lang/es"
                      >ES</a
                    >
                  </li>
                </ul>
              </li>

              <li>
                <ul class="flex flex-col xl:flex-row">
                  <li class="nav__links active dropdown">
                    <a href="/about">{{ translate.webText('about') }}</a>
                    <NavDropdown
                      :name="translate.webText('about')"
                      :text="translate.webText('about_hover_text')"
                      :btn-text="translate.button('learn_more')"
                      btn-link="/about"
                    />
                  </li>
                  <li class="nav__links active dropdown">
                    <a href="/publishing-checklist">{{
                      translate.webText('publishing_checklist')
                    }}</a>
                    <NavDropdown
                      :name="translate.webText('publishing_checklist')"
                      :text="
                        translate.webText(
                          'header.publishing_checklist_hover_text'
                        )
                      "
                      :btn-text="translate.button('read_more')"
                      btn-link="/publishing-checklist"
                    />
                  </li>
                  <li class="nav__links active dropdown relative">
                    <a href="/iati-standard">{{
                      translate.webText('iati_standard')
                    }}</a>
                    <NavDropdown
                      :name="translate.webText('iati_standard')"
                      :text="translate.webText('iati_standard_hover_text')"
                      :btn-text="translate.button('see_all_data_fields')"
                      btn-link="/iati-standard"
                    />
                  </li>
                  <li class="nav__links active dropdown">
                    <a href="/support">{{ translate.webText('support') }}</a>
                    <NavDropdown
                      :name="translate.webText('support')"
                      :text="translate.webText('support_hover_text')"
                      :btn-text="translate.button('read_more')"
                      btn-link="/support"
                    />
                  </li>
                </ul>
              </li>
            </ul>
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
                ? `${translate.commonText('go_to')} ${translate.commonText(
                    'org_list'
                  )}`
                : `${translate.commonText('go_to')} ${translate.textFromKey(
                    'activities.your_activities'
                  )}`
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
import { Translate } from 'Composable/translationHelper';

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
    const translate = new Translate();
    return { translate };
  },
});
</script>
