<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    class="elements-detail"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="category text-sm font-bold">
      <span v-if="post.type">{{ types.contactType[post.type] }}</span>
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
                  <ConditionalTextDisplay
                    :condition="narrative.language"
                    :success-text="types.languages[narrative.language]"
                  />)
                </div>
                <div class="w-[500px] max-w-full">
                  <ConditionalTextDisplay
                    :condition="narrative.narrative"
                    :success-text="narrative.narrative"
                    failure-text="organisation"
                  />
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
                  <ConditionalTextDisplay
                    :condition="narrative.language"
                    :success-text="types.languages[narrative.language]"
                  />)
                </div>
                <div class="w-[500px] max-w-full">
                  <ConditionalTextDisplay
                    :condition="narrative.narrative"
                    :success-text="narrative.narrative"
                    failure-text="person name"
                  />
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
                  <ConditionalTextDisplay
                    :condition="narrative.language"
                    :success-text="types.languages[narrative.language]"
                  />)
                </div>
                <div class="w-[500px] max-w-full">
                  <ConditionalTextDisplay
                    :condition="narrative.narrative"
                    :success-text="narrative.narrative"
                    failure-text="department"
                  />
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
                  <ConditionalTextDisplay
                    :condition="narrative.language"
                    :success-text="types.languages[narrative.language]"
                  />)
                </div>
                <div class="w-[500px] max-w-full">
                  <ConditionalTextDisplay
                    :condition="narrative.narrative"
                    :success-text="narrative.narrative"
                    failure-text="job title"
                  />
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
                  <ConditionalTextDisplay
                    :condition="email_value.email"
                    :success-text="email_value.email"
                    failure-text="email"
                  />
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
                  <ConditionalTextDisplay
                    :condition="tel.telephone"
                    :success-text="tel.telephone"
                    failure-text="telephone"
                  />
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
                  <ConditionalTextDisplay
                    :condition="w.website"
                    :success-text="w.website"
                    failure-text="website"
                  />
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
                    <ConditionalTextDisplay
                      :condition="narrative.language"
                      :success-text="types.languages[narrative.language]"
                    />)
                  </div>
                  <div class="w-[500px] max-w-full">
                    <ConditionalTextDisplay
                      :condition="narrative.narrative"
                      :success-text="narrative.narrative"
                      failure-text="mailing address"
                    />
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
import ConditionalTextDisplay from 'Components/ConditionalTextDisplay.vue';

export default defineComponent({
  name: 'ActivityContactInfo',
  components: { ConditionalTextDisplay },
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
});
</script>
