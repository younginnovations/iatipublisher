<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    class="elements-detail"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="category text-sm font-bold">
      <span v-if="!isEmpty(post.type)">{{ types.contactType[post.type] }}</span>
      <span v-else class="italic">Type Missing</span>
    </div>

    <div class="ml-5">
      <table>
        <tbody>
          <tr>
            <td>Organization</td>
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
                  (Language:
                  {{
                    isEmpty(narrative, 'language')
                      ? 'Not Available'
                      : types.languages[narrative.language]
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{
                    isEmpty(narrative, 'narrative')
                      ? 'Missing'
                      : narrative.narrative
                  }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>Person Name</td>
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
                  (Language:
                  {{
                    isEmpty(narrative, 'language')
                      ? 'Not Available'
                      : types.languages[narrative.language]
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{
                    isEmpty(narrative, 'narrative')
                      ? 'Missing'
                      : narrative.narrative
                  }}
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td>Department</td>
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
                  (Language:
                  {{
                    isEmpty(narrative, 'language')
                      ? 'Not Available'
                      : types.languages[narrative.language]
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{
                    isEmpty(narrative, 'narrative')
                      ? 'Missing'
                      : narrative.narrative
                  }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>Job Title</td>
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
                  (Language:
                  {{
                    isEmpty(narrative, 'language')
                      ? 'Not Available'
                      : types.languages[narrative.language]
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{
                    isEmpty(narrative, 'narrative')
                      ? 'Missing'
                      : narrative.narrative
                  }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>Email</td>
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
                    isEmpty(email_value, 'email')
                      ? 'Missing'
                      : email_value.email
                  }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>Telephone</td>
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
                  {{ isEmpty(tel, 'telephone') ? 'Missing' : tel.telephone }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>Website</td>
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
                  {{ isEmpty(w, 'website') ? 'Missing' : w.website }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>Mailing Address</td>
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
                    (Language:
                    {{
                      isEmpty(narrative, 'language')
                        ? 'Not Available'
                        : types.languages[narrative.language]
                    }})
                  </div>
                  <div class="w-[500px] max-w-full">
                    {{
                      isEmpty(narrative, 'narrative')
                        ? 'Missing'
                        : narrative.narrative
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
import isEmpty from 'Composable/helper';
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
    const types = inject('types') as Types;

    return { types };
  },
  methods: { isEmpty },
});
</script>
