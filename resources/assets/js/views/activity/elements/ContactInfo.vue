<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    class="elements-detail"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="category text-sm font-bold">
      <span v-if="post.type">{{ types.contactType[post.type] }}</span>
      <span v-else class="italic">
        {{ translate.missing('type') }}
      </span>
    </div>

    <div class="ml-5">
      <table>
        <tbody>
          <tr>
            <td>{{ translate.commonText('organisation') }}</td>
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
                  ({{ translate.commonText('language') }}:
                  {{
                    narrative.language
                      ? types.languages[narrative.language]
                      : translate.missing()
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{ narrative.narrative ?? translate.missing() }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('person_name') }}</td>
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
                  ({{ translate.commonText('language') }}:
                  {{
                    narrative.language
                      ? types.languages[narrative.language]
                      : translate.missing()
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{ narrative.narrative ?? translate.missing() }}
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td>{{ translate.commonText('department') }}</td>
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
                  ({{ translate.commonText('language') }}:
                  {{
                    narrative.language
                      ? types.languages[narrative.language]
                      : translate.missing()
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{ narrative.narrative ?? translate.missing() }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('job_title') }}</td>
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
                  ({{ translate.commonText('language') }}:
                  {{
                    narrative.language
                      ? types.languages[narrative.language]
                      : translate.missing()
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{ narrative.narrative ?? translate.missing() }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('email') }}l</td>
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
                  {{ email_value.email ?? translate.missing() }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('telephone') }}</td>
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
                  {{ tel.telephone ?? translate.missing() }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('website') }}</td>
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
                  {{ w.website ?? translate.missing() }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('mailing_address') }}</td>
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
                    ({{ translate.commonText('language') }}:
                    {{
                      narrative.language
                        ? types.languages[narrative.language]
                        : translate.missing()
                    }})
                  </div>
                  <div class="w-[500px] max-w-full">
                    {{
                      narrative.narrative ?? translate.missing('not_available')
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
import { Translate } from 'Composable/translationHelper';

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
    const translate = new Translate();
    const types = inject('types') as Types;

    return { types, translate };
  },
});
</script>
