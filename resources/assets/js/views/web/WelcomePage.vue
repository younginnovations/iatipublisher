<template>
  <section class="main mt-10 sm:mx-10 xl:mx-24 xl:px-1">
    <div
      class="main__container rounded-lg bg-bluecoral pb-8 sm:mb-10 md:mb-20 md:flex md:bg-none md:pb-0"
    >
      <div
        class="left flex flex-col items-center justify-center bg-bluecoral px-3 pt-5 pb-72 text-white sm:rounded-r-lg sm:rounded-l-lg sm:px-5 sm:pt-10 md:basis-2/4 md:rounded-r-none md:pb-16 lg:pt-44 lg:pb-44 xl:px-24"
      >
        <div class="left__container rounded-lg p-5 sm:p-10">
          <span class="left__title home-translated-text font-bold">{{
            translate.textFromKey('home.iati_publishing_tool_header')
          }}</span>
          <p class="home-translated-text pt-2 sm:pt-6 sm:pb-8">
            {{
              translate.textFromKey(
                'home.iati_publishing_tool_section.welcome_text'
              )
            }}
          </p>
          <div class="block">
            <span class="home-translated-text flex flex-wrap">
              {{
                pageContent === translate.webText('join_now')
                  ? translate.textFromKey(
                      'home.iati_publishing_tool_section.havent_registered_label'
                    )
                  : translate.textFromKey(
                      'home.iati_publishing_tool_section.already_have_account_label'
                    )
              }}
              <button
                class="ml-1 border-b-2 border-b-transparent text-base text-turquoise hover:border-b-2 hover:border-b-turquoise"
                @click="togglePage"
              >
                {{ pageContent }}
              </button>
            </span>
          </div>
        </div>
      </div>

      <SignIn
        v-if="pageContent === translate.webText('join_now')"
        :message="message"
        :intent="intent"
      />
      <JoinNow v-else />
    </div>
  </section>
</template>

<script>
import { defineComponent, ref } from 'vue';
import SignIn from './partials/SignIn.vue';
import JoinNow from './partials/JoinNow.vue';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  components: {
    JoinNow,
    SignIn,
  },
  props: {
    page: {
      type: String,
      required: false,
      default: 'signin',
    },
    message: {
      type: String,
      required: true,
    },
    intent: {
      type: String,
      required: true,
    },
  },
  setup(props) {
    const translate = new Translate();
    const pageContent = ref(
      props.page === 'signin'
        ? translate.webText('join_now')
        : translate.webText('sign_in')
    );
    function togglePage() {
      pageContent.value =
        pageContent.value === translate.webText('join_now')
          ? translate.webText('sign_in')
          : translate.webText('join_now');
    }

    return {
      pageContent,
      togglePage,
      translate,
    };
  },
});
</script>
