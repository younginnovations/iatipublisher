<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    class="elements-detail"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="category text-sm font-bold">
      <span v-if="post.type">{{ types.contactType[post.type] }}</span>
      <span v-else class="italic">{{
        language.common_lang.missing.element.replace(
          ':element',
          language.common_lang.type
        )
      }}</span>
    </div>

    <div class="ml-5">
      <table>
        <tbody>
          <tr>
            <td>{{ language.common_lang.organisation }}</td>
            <td>
              <div
                v-for="(narrative, k) in post.organisation[0].narrative"
                :key="k"
                class="description-content"
                :class="{
                  'mb-4': k !== post.organisation[0].narrative.length - 1,
                }"
              >
                <div class="language mb-1.5">
                  ({{ language.common_lang.language }}:
                  {{
                    narrative.language
                      ? types.languages[narrative.language]
                      : language.common_lang.missing.default
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{
                    narrative.narrative ?? language.common_lang.missing.default
                  }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.person_name }}</td>
            <td>
              <div
                v-for="(narrative, k) in post.person_name[0].narrative"
                :key="k"
                class="description-content"
                :class="{
                  'mb-4': k !== post.person_name[0].narrative.length - 1,
                }"
              >
                <div class="language mb-1.5">
                  ({{ language.common_lang.language }}:
                  {{
                    narrative.language
                      ? types.languages[narrative.language]
                      : language.common_lang.missing.default
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{
                    narrative.narrative ?? language.common_lang.missing.default
                  }}
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td>{{ language.common_lang.department }}</td>
            <td>
              <div
                v-for="(narrative, k) in post.department[0].narrative"
                :key="k"
                class="description-content"
                :class="{
                  'mb-4': k !== post.department[0].narrative.length - 1,
                }"
              >
                <div class="language mb-1.5">
                  ({{ language.common_lang.language }}:
                  {{
                    narrative.language
                      ? types.languages[narrative.language]
                      : language.common_lang.missing.default
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{
                    narrative.narrative ?? language.common_lang.missing.default
                  }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.job_title }}</td>
            <td>
              <div
                v-for="(narrative, k) in post.job_title[0].narrative"
                :key="k"
                class="description-content"
                :class="{
                  'mb-4': k !== post.job_title[0].narrative.length - 1,
                }"
              >
                <div class="language mb-1.5">
                  ({{ language.common_lang.language }}:
                  {{
                    narrative.language
                      ? types.languages[narrative.language]
                      : language.common_lang.missing.default
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{
                    narrative.narrative ?? language.common_lang.missing.default
                  }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.email }}l</td>
            <td>
              <div
                v-for="(email_value, k) in post.email"
                :key="k"
                class="description-content"
                :class="{
                  'mb-4': k !== post.email.length - 1,
                }"
              >
                <div class="w-[500px] max-w-full">
                  {{
                    email_value.email ?? language.common_lang.missing.default
                  }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.telephone }}</td>
            <td>
              <div
                v-for="(tel, k) in post.telephone"
                :key="k"
                class="description-content"
                :class="{
                  'mb-4': k !== post.telephone.length - 1,
                }"
              >
                <div class="w-[500px] max-w-full">
                  {{ tel.telephone ?? language.common_lang.missing.default }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.website }}</td>
            <td>
              <div
                v-for="(w, k) in post.website"
                :key="k"
                class="description-content"
                :class="{
                  'mb-4': k !== post.website.length - 1,
                }"
              >
                <div class="w-[500px] max-w-full">
                  {{ w.website ?? language.common_lang.missing.default }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.mailing_address }}</td>
            <td>
              <div
                v-for="(address, address_index) in post.mailing_address"
                :key="address_index"
                :class="{
                  'mb-4': k !== address.narrative.length - 1,
                }"
              >
                <div
                  v-for="(narrative, k) in address.narrative"
                  :key="k"
                  class="description-content"
                >
                  <div class="language mb-1.5">
                    ({{ language.common_lang.language }}:
                    {{
                      narrative.language
                        ? types.languages[narrative.language]
                        : language.common_lang.missing.default
                    }})
                  </div>
                  <div class="w-[500px] max-w-full">
                    {{
                      narrative.narrative ??
                      language.common_lang.missing.not_available
                    }}
                  </div>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, inject } from 'vue';

export default defineComponent({
  name: 'ActivityContactInfo',
  components: {},
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  setup() {
    interface Types {
      contactType: [];
      languages: [];
    }
    const language = window['globalLang'];
    const types = inject('types') as Types;

    return { types, language };
  },
});
</script>
