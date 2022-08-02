<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    class="elements-detail"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="text-sm font-bold category">
      <span v-if="post.type">{{ types.contactType[post.type] }}</span>
      <span v-else class="italic">Type Not Available</span>
    </div>

    <div
      v-for="(item, i) in post.person_name"
      :key="i"
      :class="{ 'mb-4': i !== post.person_name.length - 1 }"
    >
      <div
        v-for="(narrative, j) in item.narrative"
        :key="j"
        class="elements-detail"
        :class="{ 'mb-0': j !== item.narrative.length - 1 }"
      >
        <div v-if="narrative.narrative" class="space-x-1 text-sm">
          <span class="description">{{ narrative.narrative }}</span>
          <span v-if="narrative.language" class="italic text-n-30"
            >(Language: {{ types.languages[narrative.language] }})</span
          >
        </div>
        <span v-else class="text-sm italic">Person Name Not Available</span>
      </div>
    </div>

    <div
      v-for="(item, i) in post.organisation"
      :key="i"
      :class="{ 'mb-4': i !== post.organisation.length - 1 }"
    >
      <div
        v-for="(narrative, j) in item.narrative"
        :key="j"
        class="text-sm"
        :class="{ 'mb-4': j !== item.narrative.length - 1 }"
      >
        <div v-if="narrative.narrative" class="space-x-1">
          <span class="description">{{ narrative.narrative }}</span>
          <span v-if="narrative.language" class="italic text-n-30"
            >(Language: {{ types.languages[narrative.language] }})</span
          >
        </div>
        <span v-else class="italic">Organisation Not Available</span>
      </div>
    </div>
    <div class="ml-5">
      <div
        v-for="(item, i) in post.department"
        :key="i"
        :class="{ 'mb-4': i !== post.department.length - 1 }"
      >
        <div
          v-for="(narrative, j) in item.narrative"
          :key="j"
          :class="{ 'mb-4': j !== item.narrative.length - 1 }"
        >
          <table>
            <tr class="multiline">
              <td>Department</td>
              <td>
                <div v-if="narrative.narrative" class="flex flex-col">
                  <span v-if="narrative.language" class="language"
                    >(Language: {{ types.languages[narrative.language] }})</span
                  >
                  <span class="description">{{ narrative.narrative }}</span>
                </div>
                <span v-else class="italic">Not Available</span>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div
        v-for="(item, i) in post.job_title"
        :key="i"
        :class="{ 'mb-4': i !== post.job_title.length - 1 }"
      >
        <div
          v-for="(narrative, j) in item.narrative"
          :key="j"
          :class="{ 'mb-4': j !== item.narrative.length - 1 }"
        >
          <table>
            <tr class="multiline">
              <td>Job Title</td>
              <td>
                <div v-if="narrative.narrative" class="flex flex-col">
                  <span v-if="narrative.language" class="language"
                    >(Language: {{ types.languages[narrative.language] }})</span
                  >
                  <span class="description">{{ narrative.narrative }}</span>
                </div>
                <span v-else class="italic">Not Available</span>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div
        v-for="(item, i) in post.telephone"
        :key="i"
        :class="{ 'mb-4': i !== post.telephone.length - 1 }"
      >
        <table class="flex flex-col">
          <tr>
            <td>Telephone</td>
            <td>
              <span v-if="item.telephone">{{ item.telephone }}</span>
              <span v-else class="italic">Not Available</span>
            </td>
          </tr>
        </table>
      </div>
      <div
        v-for="(item, i) in post.email"
        :key="i"
        :class="{ 'mb-4': i !== post.email.length - 1 }"
      >
        <table class="flex flex-col">
          <tr>
            <td>Email</td>
            <td>
              <span v-if="item.email">{{ item.email }}</span>
              <span v-else class="italic">Not Available</span>
            </td>
          </tr>
        </table>
      </div>
      <div
        v-for="(item, i) in post.website"
        :key="i"
        :class="{ 'mb-4': i !== post.website.length - 1 }"
      >
        <table class="flex flex-col">
          <tr>
            <td>Website</td>
            <td>
              <span v-if="item.website">{{ item.website }}</span>
              <span v-else class="italic">Not Available</span>
            </td>
          </tr>
        </table>
      </div>
      <div
        v-for="(item, i) in post.mailing_address"
        :key="i"
        :class="{ 'mb-4': i !== post.mailing_address.length - 1 }"
      >
        <div
          v-for="(narrative, j) in item.narrative"
          :key="j"
          :class="{ 'mb-4': j !== item.narrative.length - 1 }"
        >
          <table class="flex">
            <tr class="multiline">
              <td>Mailing Address</td>
              <td>
                <div v-if="narrative.narrative">
                  <span class="description"
                    >{{ narrative.narrative }}
                    <span v-if="narrative.language" class="language"
                      >(Language:
                      {{ types.languages[narrative.language] }})</span
                    ></span
                  >
                </div>
                <span v-else class="italic">Not Available</span>
              </td>
            </tr>
          </table>
        </div>
      </div>
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
    const types = inject('types') as Types;

    return { types };
  },
});
</script>
